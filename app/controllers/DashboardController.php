<?php
require_once 'app/models/UserModel.php';
require_once 'app/models/RideModel.php';
require_once 'app/models/VehicleModel.php';
require_once 'app/models/ConnectionModel.php';
require_once 'app/helpers/Security.php';
require_once 'app/helpers/Mailer.php';
require_once 'app/helpers/Database.php';

class DashboardController {
    private $userModel;
    private $rideModel;
    private $vehicleModel;
    private $connectionModel;
    private $mailer;
    private $db; // Add database property

    public function __construct() {
        Security::redirectIfNotLoggedIn();
        
        $this->userModel = new UserModel();
        $this->rideModel = new RideModel();
        $this->vehicleModel = new VehicleModel();
        $this->connectionModel = new ConnectionModel();
        $this->mailer = new Mailer();
        $this->db = Database::getInstance(); // Initialize database
    }
    
 public function index() {
    $user = Security::getCurrentUser();
    $searchResults = [];
    
    try {
        // Get search results if search was performed
        if (isset($_GET['search']) && $_GET['search'] === 'true') {
            $searchResults = $_SESSION['last_search_results'] ?? [];
        }
        
        // Safely get user data
        $userData = $this->userModel->getUserById($user['id']);
        if (!$userData) {
            $userData = $user; // Fallback to session data
        }
        
        // Safely get vehicle data
        $vehicleData = null;
        try {
            $vehicleData = $this->vehicleModel->getUserVehicle($user['id']);
        } catch (Exception $e) {
            error_log("Vehicle fetch error: " . $e->getMessage());
        }
        
        // Safely get user rides
        $myRides = ['created' => [], 'booked' => []];
        try {
            $myRides = $this->rideModel->getUserRides($user['id']);
        } catch (Exception $e) {
            error_log("Rides fetch error: " . $e->getMessage());
        }
        
        // Safely get connection stats
        $connectionStats = ['total_connections' => 0, 'pending_incoming' => 0, 'pending_outgoing' => 0];
        try {
            if (isset($this->connectionModel)) {
                $connectionStats = $this->connectionModel->getConnectionStats($user['id']);
            }
        } catch (Exception $e) {
            error_log("Connection stats error: " . $e->getMessage());
        }
        
        $data = [
            'page_title' => 'Dashboard - Carpool India',
            'user' => $userData,
            'vehicle' => $vehicleData,
            'my_rides' => $myRides,
            'search_results' => $searchResults,
            'connection_stats' => $connectionStats,
            'csrf_token' => Security::generateCSRFToken()
        ];
        
        $this->loadView('dashboard/index', $data);
        
    } catch (Exception $e) {
        error_log("Dashboard error: " . $e->getMessage());
        
        // Fallback data in case of any error
        $data = [
            'page_title' => 'Dashboard - Carpool India',
            'user' => $user,
            'vehicle' => null,
            'my_rides' => ['created' => [], 'booked' => []],
            'search_results' => [],
            'connection_stats' => ['total_connections' => 0, 'pending_incoming' => 0, 'pending_outgoing' => 0],
            'csrf_token' => Security::generateCSRFToken()
        ];
        
        $this->loadView('dashboard/index', $data);
    }
}

    
    public function searchRides() {
        header('Content-Type: application/json');
        
        try {
            $source = Security::sanitizeInput($_POST['source'] ?? '');
            $destination = Security::sanitizeInput($_POST['destination'] ?? '');
            $date = $_POST['date'] ?? '';
            
            if (empty($source) || empty($destination) || empty($date)) {
                throw new Exception('Please fill all search fields');
            }
            
            // Validate date
            if (!strtotime($date) || $date < date('Y-m-d')) {
                throw new Exception('Please select a valid future date');
            }
            
            $rides = $this->rideModel->searchRides($source, $destination, $date, 20);
            
            // Store search results in session for display
            $_SESSION['last_search_results'] = $rides;
            $_SESSION['last_search'] = [
                'source' => $source,
                'destination' => $destination,
                'date' => $date
            ];
            
            echo json_encode([
                'success' => true, 
                'rides' => $rides,
                'count' => count($rides),
                'message' => count($rides) > 0 ? 'Found ' . count($rides) . ' rides' : 'No rides found for your search'
            ]);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function createRide() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            
            // Validate CSRF token
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            // Get and validate input data
            $source = Security::sanitizeInput($_POST['source'] ?? '');
            $destination = Security::sanitizeInput($_POST['destination'] ?? '');
            $rideDate = $_POST['ride_date'] ?? '';
            $rideTime = $_POST['ride_time'] ?? '';
            $seatsAvailable = (int)($_POST['seats_available'] ?? 0);
            $pricePerSeat = (float)($_POST['price_per_seat'] ?? 0);
            $description = Security::sanitizeInput($_POST['description'] ?? '');
            
            // Validation
            if (empty($source) || empty($destination) || empty($rideDate) || empty($rideTime)) {
                throw new Exception('Please fill all required fields');
            }
            
            if ($seatsAvailable < 1 || $seatsAvailable > 6) {
                throw new Exception('Seats available must be between 1 and 6');
            }
            
            if ($pricePerSeat < 0 || $pricePerSeat > 1000) {
                throw new Exception('Price per seat must be between ₹0 and ₹1000');
            }
            
            // Validate date and time
            $rideDateTime = strtotime($rideDate . ' ' . $rideTime);
            if ($rideDateTime <= time() + 3600) { // At least 1 hour in future
                throw new Exception('Ride must be scheduled at least 1 hour in advance');
            }
            
            // Check if user has a vehicle registered
            $vehicle = $this->vehicleModel->getUserVehicle($user['id']);
            if (!$vehicle) {
                throw new Exception('Please add your vehicle details first');
            }
            
            // Geocode source and destination
            $sourceCoords = $this->geocodeAddress($source);
            $destCoords = $this->geocodeAddress($destination);
            
            $rideData = [
                'user_id' => $user['id'],
                'source' => $source,
                'destination' => $destination,
                'source_lat' => $sourceCoords['lat'] ?? null,
                'source_lng' => $sourceCoords['lng'] ?? null,
                'dest_lat' => $destCoords['lat'] ?? null,
                'dest_lng' => $destCoords['lng'] ?? null,
                'ride_date' => $rideDate,
                'ride_time' => $rideTime,
                'seats_available' => $seatsAvailable,
                'price_per_seat' => $pricePerSeat,
                'description' => $description
            ];
            
            $rideId = $this->rideModel->createRide($rideData);
            
            if ($rideId) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Ride created successfully!',
                    'ride_id' => $rideId
                ]);
            } else {
                throw new Exception('Failed to create ride. Please try again.');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // public function myRides() {
    //     $user = Security::getCurrentUser();
        
    //     // Use existing method instead of getUserRidesDetailed (which might not exist)
    //     $rides = $this->rideModel->getUserRides($user['id']);
        
    //     // Get pending booking requests for user's rides
    //     $bookingRequests = [];
    //     if (method_exists($this->rideModel, 'getPendingBookingRequests')) {
    //         $bookingRequests = $this->rideModel->getPendingBookingRequests($user['id']);
    //     }
        
    //     // Calculate total earnings
    //     $totalEarnings = 0;
    //     if (isset($rides['created'])) {
    //         foreach ($rides['created'] as $ride) {
    //             $totalEarnings += ($ride['total_bookings'] ?? 0) * $ride['price_per_seat'];
    //         }
    //     }
        
    //     $data = [
    //         'page_title' => 'My Rides - Carpool India',
    //         'user' => $this->userModel->getUserById($user['id']),
    //         'rides' => $rides,
    //         'booking_requests' => $bookingRequests,
    //         'total_earnings' => $totalEarnings,
    //         'csrf_token' => Security::generateCSRFToken()
    //     ];
        
    //     $this->loadView('dashboard/my-rides', $data);
    // }

    
    public function myRides() {
    $user = Security::getCurrentUser();
    
    try {
        // Initialize database if not already done
        if (!isset($this->db)) {
            $this->db = Database::getInstance();
        }
        
        // Get user's created rides with safe query
        $createdRides = [];
        try {
            $createdRides = $this->db->fetchAll("
                SELECT r.*, 
                       COALESCE(COUNT(CASE WHEN b.booking_status = 'confirmed' THEN 1 END), 0) as confirmed_bookings,
                       COALESCE(COUNT(CASE WHEN b.booking_status = 'pending' THEN 1 END), 0) as pending_requests,
                       COALESCE(SUM(CASE WHEN b.booking_status = 'confirmed' THEN b.booking_amount ELSE 0 END), 0) as total_expected,
                       COALESCE(SUM(CASE WHEN b.booking_status = 'confirmed' AND b.payment_mode IS NOT NULL THEN b.booking_amount ELSE 0 END), 0) as total_received
                FROM rides r 
                LEFT JOIN bookings b ON r.id = b.ride_id 
                WHERE r.user_id = ? 
                GROUP BY r.id
                ORDER BY r.ride_date DESC, r.ride_time DESC
            ", [$user['id']]);
        } catch (Exception $e) {
            error_log("Created rides query error: " . $e->getMessage());
        }

        // Get user's booked rides with safe query
        $bookedRides = [];
        try {
            $bookedRides = $this->db->fetchAll("
                SELECT r.*, 
                       b.id as booking_id, 
                       COALESCE(b.seats_booked, 1) as seats_booked, 
                       COALESCE(b.booking_amount, 0) as booking_amount, 
                       COALESCE(b.booking_status, 'pending') as booking_status,
                       b.payment_mode,
                       b.created_at as booking_date, 
                       u.name as driver_name, 
                       u.phone as driver_phone,
                       COALESCE(v.model, 'Vehicle') as vehicle_model, 
                       v.number_plate
                FROM bookings b 
                JOIN rides r ON b.ride_id = r.id 
                JOIN users u ON r.user_id = u.id 
                LEFT JOIN vehicles v ON u.id = v.user_id 
                WHERE b.user_id = ?
                ORDER BY r.ride_date DESC, r.ride_time DESC
            ", [$user['id']]);
        } catch (Exception $e) {
            error_log("Booked rides query error: " . $e->getMessage());
        }

        // Get pending booking requests with safe query
        $bookingRequests = [];
        try {
            $bookingRequests = $this->db->fetchAll("
                SELECT b.*, r.source, r.destination, r.ride_date, r.ride_time,
                       u.name as passenger_name, u.email as passenger_email
                FROM bookings b
                JOIN rides r ON b.ride_id = r.id
                JOIN users u ON b.user_id = u.id
                WHERE r.user_id = ? AND b.booking_status = 'pending'
                ORDER BY b.created_at DESC
            ", [$user['id']]);
        } catch (Exception $e) {
            error_log("Booking requests query error: " . $e->getMessage());
        }

        // Calculate total earnings safely
        $totalEarnings = 0;
        foreach ($createdRides as $ride) {
            $totalEarnings += floatval($ride['total_received'] ?? 0);
        }

        $data = [
            'page_title' => 'My Rides - Carpool India',
            'user' => $user,
            'rides' => [
                'created' => $createdRides,
                'booked' => $bookedRides
            ],
            'booking_requests' => $bookingRequests,
            'total_earnings' => $totalEarnings,
            'csrf_token' => Security::generateCSRFToken()
        ];
        
        $this->loadView('dashboard/my-rides', $data);
        
    } catch (Exception $e) {
        error_log("MyRides controller error: " . $e->getMessage());
        
        // Fallback data if everything fails
        $data = [
            'page_title' => 'My Rides - Carpool India',
            'user' => $user,
            'rides' => [
                'created' => [],
                'booked' => []
            ],
            'booking_requests' => [],
            'total_earnings' => 0,
            'csrf_token' => Security::generateCSRFToken()
        ];
        
        $this->loadView('dashboard/my-rides', $data);
    }
}


    /* ----------  CANCEL BOOKING  ---------- */
   

    public function deleteRide() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $rideId = (int)($_POST['ride_id'] ?? 0);
            
            if (method_exists($this->rideModel, 'deleteRide')) {
                $success = $this->rideModel->deleteRide($rideId, $user['id']);
            } else {
                // Fallback delete method
                $success = $this->db->delete('rides', 'id = ? AND user_id = ?', [$rideId, $user['id']]);
            }
            
            if ($success) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Ride deleted successfully!'
                ]);
            } else {
                throw new Exception('Failed to delete ride');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

   

    // ===============================
    // CONNECTION METHODS
    // ===============================
    
    public function connections() {
        $user = Security::getCurrentUser();
        
        $data = [
            'page_title' => 'Connections & Requests - Carpool India',
            'csrf_token' => Security::generateCSRFToken(),
            'user' => $this->userModel->getUserById($user['id']),
            
            // Get ALL requests (all statuses)
            'all_incoming_requests' => $this->connectionModel->getIncomingRequests($user['id'], 'all'),
            'all_outgoing_requests' => $this->connectionModel->getOutgoingRequests($user['id'], 'all'),
            'connections' => $this->connectionModel->getUserConnections($user['id']),
            'connection_stats' => $this->connectionModel->getConnectionStats($user['id'])
        ];
        
        $this->loadView('dashboard/connections', $data);
    }

    public function sendConnectionRequest() {
        header('Content-Type: application/json');
        
        try {
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $user = Security::getCurrentUser();
            $receiverId = (int)($_POST['receiver_id'] ?? 0);
            $rideId = !empty($_POST['ride_id']) ? (int)$_POST['ride_id'] : null;
            $message = Security::sanitizeInput($_POST['message'] ?? '');
            $type = $_POST['type'] ?? 'connection';
            
            if ($receiverId === $user['id']) {
                throw new Exception('Cannot send request to yourself');
            }
            
            // Check if receiver exists
            $receiver = $this->userModel->getUserById($receiverId);
            if (!$receiver) {
                throw new Exception('User not found');
            }
            
            $requestId = $this->connectionModel->sendRequest(
                $user['id'], 
                $receiverId, 
                $rideId, 
                $type, 
                $message
            );
            
            echo json_encode([
                'success' => true,
                'message' => 'Request sent successfully!',
                'request_id' => $requestId
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
    
    public function respondToRequest() {
        header('Content-Type: application/json');
        
        try {
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $user = Security::getCurrentUser();
            $requestId = (int)($_POST['request_id'] ?? 0);
            $status = $_POST['status'] ?? '';
            
            if (!in_array($status, ['accepted', 'declined'])) {
                throw new Exception('Invalid status');
            }
            
            $this->connectionModel->updateRequestStatus($requestId, $user['id'], $status);
            
            $message = $status === 'accepted' ? 'Request accepted!' : 'Request declined!';
            
            echo json_encode([
                'success' => true,
                'message' => $message
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    // ===============================
    // BOOKING REQUEST METHODS
    // ===============================

    public function sendBookingRequest() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $rideId = (int)($_POST['ride_id'] ?? 0);
            $seatsRequested = (int)($_POST['seats_requested'] ?? 1);
            $message = Security::sanitizeInput($_POST['message'] ?? '');
            
            // Get ride and driver details
            $ride = $this->db->fetchOne("
                SELECT r.*, u.name as driver_name, u.email as driver_email
                FROM rides r
                JOIN users u ON r.user_id = u.id
                WHERE r.id = ?
            ", [$rideId]);
            
            if (!$ride) {
                throw new Exception('Ride not found');
            }
            
            if ($ride['user_id'] == $user['id']) {
                throw new Exception('Cannot request booking for your own ride');
            }
            
            // Create booking request
            $bookingAmount = $ride['price_per_seat'] * $seatsRequested;
            $bookingId = $this->db->insert('bookings', [
                'ride_id' => $rideId,
                'user_id' => $user['id'],
                'seats_booked' => $seatsRequested,
                'booking_amount' => $bookingAmount,
                'booking_status' => 'pending',
                'request_message' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            if ($bookingId) {
                // Send email to driver
                $rideDetails = [
                    'source' => $ride['source'],
                    'destination' => $ride['destination'],
                    'date' => date('d M Y', strtotime($ride['ride_date'])),
                    'time' => date('h:i A', strtotime($ride['ride_time'])),
                    'amount' => $bookingAmount
                ];
                
                $this->mailer->sendBookingRequest(
                    $ride['driver_email'],
                    $ride['driver_name'],
                    $user['name'],
                    $rideDetails
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Booking request sent! Driver will be notified via email.',
                    'booking_id' => $bookingId
                ]);
            } else {
                throw new Exception('Failed to send booking request');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

   

  

    // ===============================
    // HELPER METHODS
    // ===============================

    private function sendRideStatusEmails($rideId, $status) {
        try {
            // Get ride details and all confirmed passengers
            $ride = $this->db->fetchOne("
                SELECT r.*, u.name as driver_name, u.email as driver_email
                FROM rides r
                JOIN users u ON r.user_id = u.id
                WHERE r.id = ?
            ", [$rideId]);
            
            if (!$ride) return;
            
            $passengers = $this->db->fetchAll("
                SELECT u.name, u.email
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                WHERE b.ride_id = ? AND b.booking_status = 'confirmed'
            ", [$rideId]);
            
            $rideDetails = [
                'source' => $ride['source'],
                'destination' => $ride['destination'],
                'date' => date('d M Y', strtotime($ride['ride_date'])),
                'time' => date('h:i A', strtotime($ride['ride_time'])),
                'amount' => $ride['price_per_seat']
            ];
            
            // Send emails to all passengers
            foreach ($passengers as $passenger) {
                if ($status === 'started') {
                    $this->mailer->sendRideStarted($passenger['email'], $passenger['name'], $rideDetails, false);
                } elseif ($status === 'completed') {
                    $this->mailer->sendRideCompleted($passenger['email'], $passenger['name'], $rideDetails, false);
                }
            }
            
            // Send email to driver
            if ($status === 'started') {
                $this->mailer->sendRideStarted($ride['driver_email'], $ride['driver_name'], $rideDetails, true);
            } elseif ($status === 'completed') {
                $this->mailer->sendRideCompleted($ride['driver_email'], $ride['driver_name'], $rideDetails, true);
            }
            
        } catch (Exception $e) {
            error_log("Failed to send ride status emails: " . $e->getMessage());
        }
    }

    private function calculateTotalEarnings($createdRides) {
        $total = 0;
        foreach ($createdRides as $ride) {
            $total += ($ride['confirmed_bookings'] ?? 0) * $ride['price_per_seat'];
        }
        return $total;
    }

    public function checkConnectionStatus() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            $otherUserId = (int)($_GET['user_id'] ?? 0);
            
            if ($otherUserId <= 0) {
                throw new Exception('Invalid user ID');
            }
            
            $isConnected = $this->connectionModel->areUsersConnected($user['id'], $otherUserId);
            
            echo json_encode([
                'success' => true,
                'connected' => $isConnected
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    // Legacy method redirect
    public function bookRide() {
        return $this->sendBookingRequest();
    }

    private function geocodeAddress($address) {
        try {
            $query = urlencode(trim($address));
            $url = OSM_NOMINATIM_URL . "/search?format=json&q={$query}&limit=1&countrycodes=in";
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'user_agent' => 'Carpool India v1.0'
                ]
            ]);
            
            $response = file_get_contents($url, false, $context);
            
            if ($response !== false) {
                $data = json_decode($response, true);
                if (!empty($data)) {
                    return [
                        'lat' => (float)$data[0]['lat'],
                        'lng' => (float)$data[0]['lon']
                    ];
                }
            }
        } catch (Exception $e) {
            error_log("Geocoding error: " . $e->getMessage());
        }
        
        return null;
    }



       // Start ride method
    // public function startRide() {
    //     header('Content-Type: application/json');
        
    //     try {
    //         $user = Security::getCurrentUser();
    //         $rideId = (int)($_POST['ride_id'] ?? 0);
            
    //         if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
    //             throw new Exception('Invalid request');
    //         }
            
    //         if ($rideId <= 0) {
    //             throw new Exception('Invalid ride ID');
    //         }
            
    //         $ride = $this->rideModel->getRideById($rideId);
            
    //         if (!$ride) {
    //             throw new Exception('Ride not found');
    //         }
            
    //         if ($ride['user_id'] != $user['id']) {
    //             throw new Exception('You can only start your own rides');
    //         }
            
    //         if ($ride['status'] === 'started') {
    //             throw new Exception('Ride is already started');
    //         }
            
    //         if ($ride['status'] === 'completed') {
    //             throw new Exception('Ride is already completed');
    //         }
            
    //         // Update ride status to started
    //         $result = $this->rideModel->updateRideStatus($rideId, 'started');
            
    //         if ($result) {
    //             echo json_encode([
    //                 'success' => true,
    //                 'message' => 'Ride started successfully!'
    //             ]);
    //         } else {
    //             throw new Exception('Failed to start ride');
    //         }
            
    //     } catch (Exception $e) {
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    //     exit;
    // }
    
    // Complete ride method
    // public function completeRide() {
    //     header('Content-Type: application/json');
        
    //     try {
    //         $user = Security::getCurrentUser();
    //         $rideId = (int)($_POST['ride_id'] ?? 0);
            
    //         if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
    //             throw new Exception('Invalid request');
    //         }
            
    //         $ride = $this->rideModel->getRideById($rideId);
            
    //         if (!$ride || $ride['user_id'] != $user['id']) {
    //             throw new Exception('Invalid ride or unauthorized');
    //         }
            
    //         if ($ride['status'] !== 'started') {
    //             throw new Exception('Ride must be started before completing');
    //         }
            
    //         // Complete the ride and all bookings
    //         $result = $this->rideModel->completeRide($rideId);
            
    //         if ($result) {
    //             echo json_encode([
    //                 'success' => true,
    //                 'message' => 'Ride completed successfully!'
    //             ]);
    //         } else {
    //             throw new Exception('Failed to complete ride');
    //         }
            
    //     } catch (Exception $e) {
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    //     exit;
    // }
    



    // Mark cash received method
    public function markCashReceived() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            $bookingId = (int)($_POST['booking_id'] ?? 0);
            
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $result = $this->rideModel->markCashReceived($bookingId, $user['id']);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cash received marked successfully!'
                ]);
            } else {
                throw new Exception('Failed to mark cash received');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    // Get rides with filter
    public function getFilteredRides() {
        $user = Security::getCurrentUser();
        $filter = $_GET['filter'] ?? 'all';
        
        $rides = $this->rideModel->getUserRides($user['id'], 'all', $filter);
        
        $data = [
            'page_title' => 'My Rides - Carpool India',
            'rides' => $rides,
            'filter' => $filter,
            'user' => $user,
            'csrf_token' => Security::generateCSRFToken()
        ];
        
        $this->loadView('dashboard/my-rides', $data);
    }
    


    /* app/controllers/DashboardController.php */

/*  POST /dashboard/record-payment  */


/*  POST /dashboard/complete-ride  */
// Record payment method


// Complete ride method
// public function completeRide() {
//     header('Content-Type: application/json');
    
//     try {
//         $user = Security::getCurrentUser();
        
//         if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
//             throw new Exception('Invalid request');
//         }
        
//         $rideId = (int)($_POST['ride_id'] ?? 0);
        
//         // Check if all payments are recorded
//         $unpaidBookings = $this->db->fetchOne(
//             "SELECT COUNT(*) as count FROM bookings 
//              WHERE ride_id = ? AND booking_status = 'confirmed' AND payment_mode IS NULL",
//             [$rideId]
//         );
        
//         if ($unpaidBookings['count'] > 0) {
//             throw new Exception('Please record payment mode for all passengers first');
//         }
        
//         // Complete the ride
//         $success = $this->db->update('rides', [
//             'status' => 'completed'
//         ], 'id = ? AND user_id = ?', [$rideId, $user['id']]);
        
//         if ($success) {
//             // Update all bookings to completed
//             $this->db->update('bookings', [
//                 'booking_status' => 'completed'
//             ], 'ride_id = ?', [$rideId]);
            
//             echo json_encode([
//                 'success' => true,
//                 'message' => 'Ride completed successfully!'
//             ]);
//         } else {
//             throw new Exception('Failed to complete ride');
//         }
        
//     } catch (Exception $e) {
//         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
//     }
//     exit;
// }





// Start ride method (fixed)
public function startRide() {
    header('Content-Type: application/json');
    
    try {
        $user = Security::getCurrentUser();
        $rideId = (int)($_POST['ride_id'] ?? 0);
        
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            throw new Exception('Invalid request');
        }
        
        // Check if ride belongs to user
        $ride = $this->db->fetchOne("SELECT * FROM rides WHERE id = ? AND user_id = ?", [$rideId, $user['id']]);
        
        if (!$ride) {
            throw new Exception('Ride not found or unauthorized');
        }
        
        if ($ride['status'] !== 'active') {
            throw new Exception('Only active rides can be started');
        }
        
        // Update ride status directly with database
        $success = $this->db->update('rides', [
            'status' => 'started',
            'started_at' => date('Y-m-d H:i:s')
        ], 'id = ?', [$rideId]);
        
        if ($success) {
            // Update confirmed bookings to started
            $this->db->update('bookings', [
                'booking_status' => 'started'
            ], 'ride_id = ? AND booking_status = ?', [$rideId, 'confirmed']);
            
            echo json_encode([
                'success' => true,
                'message' => 'Ride started successfully! You can now record passenger payments.'
            ]);
        } else {
            throw new Exception('Failed to start ride');
        }
        
    } catch (Exception $e) {
        error_log("Start ride error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Complete ride method (fixed)
public function completeRide() {
    header('Content-Type: application/json');
    
    try {
        $user = Security::getCurrentUser();
        $rideId = (int)($_POST['ride_id'] ?? 0);
        
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            throw new Exception('Invalid request');
        }
        
        // Check if ride belongs to user
        $ride = $this->db->fetchOne("SELECT * FROM rides WHERE id = ? AND user_id = ?", [$rideId, $user['id']]);
        
        if (!$ride) {
            throw new Exception('Ride not found or unauthorized');
        }
        
        if ($ride['status'] !== 'started') {
            throw new Exception('Ride must be started before completing');
        }
        
        // Check if all confirmed bookings have payment mode recorded
        $unpaidBookings = $this->db->fetchOne(
            "SELECT COUNT(*) as count FROM bookings 
             WHERE ride_id = ? AND booking_status IN ('confirmed', 'started') AND payment_mode IS NULL",
            [$rideId]
        );
        
        if ($unpaidBookings['count'] > 0) {
            throw new Exception('Please record payment mode for all passengers before completing the ride');
        }
        
        // Complete the ride
        $success = $this->db->update('rides', [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ], 'id = ?', [$rideId]);
        
        if ($success) {
            // Update all bookings to completed
            $this->db->update('bookings', [
                'booking_status' => 'completed'
            ], 'ride_id = ? AND booking_status IN (?, ?)', [$rideId, 'confirmed', 'started']);
            
            echo json_encode([
                'success' => true,
                'message' => 'Ride completed successfully! Payment collected.'
            ]);
        } else {
            throw new Exception('Failed to complete ride');
        }
        
    } catch (Exception $e) {
        error_log("Complete ride error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Update ride status method (fixed)
public function updateRideStatus() {
    header('Content-Type: application/json');
    
    try {
        $user = Security::getCurrentUser();
        
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            throw new Exception('Invalid request');
        }
        
        $rideId = (int)($_POST['ride_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $reason = $_POST['reason'] ?? '';
        
        if (!in_array($status, ['active', 'started', 'completed', 'cancelled'])) {
            throw new Exception('Invalid status');
        }
        
        // Check if ride belongs to user
        $ride = $this->db->fetchOne("SELECT * FROM rides WHERE id = ? AND user_id = ?", [$rideId, $user['id']]);
        
        if (!$ride) {
            throw new Exception('Ride not found or unauthorized');
        }
        
        $updateData = ['status' => $status];
        
        if ($status === 'started') {
            $updateData['started_at'] = date('Y-m-d H:i:s');
        } elseif ($status === 'completed') {
            $updateData['completed_at'] = date('Y-m-d H:i:s');
        } elseif ($status === 'cancelled') {
            $updateData['cancellation_reason'] = $reason;
            $updateData['cancelled_at'] = date('Y-m-d H:i:s');
        }
        
        $success = $this->db->update('rides', $updateData, 'id = ?', [$rideId]);
        
        if ($success) {
            // Update booking statuses accordingly
            if ($status === 'cancelled') {
                $this->db->update('bookings', [
                    'booking_status' => 'cancelled'
                ], 'ride_id = ? AND booking_status IN (?, ?, ?)', [$rideId, 'pending', 'confirmed', 'started']);
            } elseif ($status === 'started') {
                $this->db->update('bookings', [
                    'booking_status' => 'started'
                ], 'ride_id = ? AND booking_status = ?', [$rideId, 'confirmed']);
            } elseif ($status === 'completed') {
                $this->db->update('bookings', [
                    'booking_status' => 'completed'
                ], 'ride_id = ? AND booking_status IN (?, ?)', [$rideId, 'confirmed', 'started']);
            }
            
            $message = match($status) {
                'started' => 'Ride started successfully!',
                'completed' => 'Ride completed successfully!',
                'cancelled' => 'Ride cancelled successfully!',
                default => 'Ride status updated successfully!'
            };
            
            echo json_encode([
                'success' => true,
                'message' => $message
            ]);
        } else {
            throw new Exception('Failed to update ride status');
        }
        
    } catch (Exception $e) {
        error_log("Update ride status error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Record payment method (enhanced)
public function recordPayment() {
    header('Content-Type: application/json');
    
    try {
        $user = Security::getCurrentUser();
        
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            throw new Exception('Invalid request');
        }
        
        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $paymentMode = $_POST['payment_mode'] ?? '';
        
        if (!in_array($paymentMode, ['cash', 'online'])) {
            throw new Exception('Invalid payment mode');
        }
        
        // Verify booking belongs to driver's ride and ride is started
        $booking = $this->db->fetchOne("
            SELECT b.*, r.user_id as driver_id, r.status as ride_status
            FROM bookings b
            JOIN rides r ON b.ride_id = r.id
            WHERE b.id = ?
        ", [$bookingId]);
        
        if (!$booking || $booking['driver_id'] != $user['id']) {
            throw new Exception('Unauthorized access');
        }
        
        if ($booking['ride_status'] !== 'started') {
            throw new Exception('Ride must be started before recording payments');
        }
        
        if ($booking['booking_status'] !== 'started') {
            throw new Exception('Booking must be in started status');
        }
        
        // Update payment mode
        $success = $this->db->update('bookings', [
            'payment_mode' => $paymentMode,
            'payment_recorded_at' => date('Y-m-d H:i:s'),
            'payment_confirmed_by' => $user['id']
        ], 'id = ?', [$bookingId]);
        
        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Payment mode recorded successfully!'
            ]);
        } else {
            throw new Exception('Failed to record payment');
        }
        
    } catch (Exception $e) {
        error_log("Record payment error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Accept booking request
public function respondToBookingRequest() {
    header('Content-Type: application/json');
    
    try {
        $user = Security::getCurrentUser();
        
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            throw new Exception('Invalid request');
        }
        
        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $reason = $_POST['reason'] ?? '';
        
        if (!in_array($status, ['confirmed', 'rejected'])) {
            throw new Exception('Invalid status');
        }
        
        // Verify booking belongs to user's ride
        $booking = $this->db->fetchOne("
            SELECT b.*, r.user_id as driver_id, r.seats_available, r.status as ride_status
            FROM bookings b
            JOIN rides r ON b.ride_id = r.id
            WHERE b.id = ? AND b.booking_status = 'pending'
        ", [$bookingId]);
        
        if (!$booking || $booking['driver_id'] != $user['id']) {
            throw new Exception('Booking not found or unauthorized');
        }
        
        if ($booking['ride_status'] !== 'active') {
            throw new Exception('Cannot respond to bookings for inactive rides');
        }
        
        if ($status === 'confirmed' && $booking['seats_booked'] > $booking['seats_available']) {
            throw new Exception('Not enough seats available');
        }
        
        $updateData = [
            'booking_status' => $status,
            'responded_at' => date('Y-m-d H:i:s')
        ];
        
        if ($status === 'rejected' && $reason) {
            $updateData['rejection_reason'] = $reason;
        }
        
        $success = $this->db->update('bookings', $updateData, 'id = ?', [$bookingId]);
        
        if ($success && $status === 'confirmed') {
            // Reduce available seats
            $this->db->update('rides', [
                'seats_available' => $booking['seats_available'] - $booking['seats_booked']
            ], 'id = ?', [$booking['ride_id']]);
        }
        
        if ($success) {
            $message = $status === 'confirmed' ? 'Booking request accepted!' : 'Booking request rejected!';
            echo json_encode([
                'success' => true,
                'message' => $message
            ]);
        } else {
            throw new Exception('Failed to update booking status');
        }
        
    } catch (Exception $e) {
        error_log("Respond to booking error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Cancel booking
public function cancelBooking() {
    header('Content-Type: application/json');
    
    try {
        $user = Security::getCurrentUser();
        
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            throw new Exception('Invalid request');
        }
        
        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $reason = $_POST['reason'] ?? '';
        
        // Verify booking belongs to user
        $booking = $this->db->fetchOne("
            SELECT b.*, r.seats_available 
            FROM bookings b
            JOIN rides r ON b.ride_id = r.id
            WHERE b.id = ? AND b.user_id = ?
        ", [$bookingId, $user['id']]);
        
        if (!$booking) {
            throw new Exception('Booking not found or unauthorized');
        }
        
        if (!in_array($booking['booking_status'], ['pending', 'confirmed', 'started'])) {
            throw new Exception('Cannot cancel this booking');
        }
        
        $success = $this->db->update('bookings', [
            'booking_status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => date('Y-m-d H:i:s')
        ], 'id = ?', [$bookingId]);
        
        if ($success && $booking['booking_status'] === 'confirmed') {
            // Return seats to ride
            $this->db->update('rides', [
                'seats_available' => $booking['seats_available'] + $booking['seats_booked']
            ], 'id = ?', [$booking['ride_id']]);
        }
        
        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Booking cancelled successfully!'
            ]);
        } else {
            throw new Exception('Failed to cancel booking');
        }
        
    } catch (Exception $e) {
        error_log("Cancel booking error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}



    private function loadView($view, $data = []) {
        extract($data);
        ob_start();
        include "app/views/{$view}.php";
        $content = ob_get_clean();
        echo $content;
    }





}
?>
