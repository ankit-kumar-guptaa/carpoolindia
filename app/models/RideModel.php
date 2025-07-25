<?php
require_once 'app/helpers/Database.php';

class RideModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function createRide($data) {
        $rideData = [
            'user_id' => $data['user_id'],
            'source' => $data['source'],
            'destination' => $data['destination'],
            'source_lat' => $data['source_lat'] ?? null,
            'source_lng' => $data['source_lng'] ?? null,
            'dest_lat' => $data['dest_lat'] ?? null,
            'dest_lng' => $data['dest_lng'] ?? null,
            'ride_date' => $data['ride_date'],
            'ride_time' => $data['ride_time'],
            'seats_available' => $data['seats_available'],
            'total_seats' => $data['seats_available'],
            'price_per_seat' => $data['price_per_seat'],
            'description' => $data['description'] ?? null,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('rides', $rideData);
    }
    
    public function searchRides($source, $destination, $date, $limit = 20) {
        $sql = "
            SELECT r.*, u.name as driver_name, u.phone as driver_phone, 
                   v.model as vehicle_model, v.number_plate, v.color as vehicle_color,
                   (SELECT COUNT(*) FROM bookings b WHERE b.ride_id = r.id AND b.booking_status = 'confirmed') as booked_seats
            FROM rides r 
            JOIN users u ON r.user_id = u.id 
            LEFT JOIN vehicles v ON u.id = v.user_id 
            WHERE r.ride_date = ? 
            AND r.seats_available > 0 
            AND r.status = 'active'
            AND (LOWER(r.source) LIKE LOWER(?) OR LOWER(r.destination) LIKE LOWER(?))
            ORDER BY r.created_at DESC 
            LIMIT ?
        ";
        
        $searchTerm = "%{$source}%";
        $destTerm = "%{$destination}%";
        
        return $this->db->fetchAll($sql, [$date, $searchTerm, $destTerm, $limit]);
    }
    
    public function getRideById($id) {
        $sql = "
            SELECT r.*, u.name as driver_name, u.email as driver_email, u.phone as driver_phone,
                   v.model as vehicle_model, v.number_plate, v.color as vehicle_color
            FROM rides r 
            JOIN users u ON r.user_id = u.id 
            LEFT JOIN vehicles v ON u.id = v.user_id 
            WHERE r.id = ?
        ";
        
        return $this->db->fetchOne($sql, [$id]);
    }
    
    public function getFeaturedRides($limit = 4) {
        $sql = "
            SELECT r.*, u.name as driver_name, v.model as vehicle_model,
                   (SELECT COUNT(*) FROM bookings b WHERE b.ride_id = r.id AND b.booking_status = 'confirmed') as booked_count
            FROM rides r 
            JOIN users u ON r.user_id = u.id 
            LEFT JOIN vehicles v ON u.id = v.user_id 
            WHERE r.ride_date >= CURDATE() 
            AND r.seats_available > 0 
            AND r.status = 'active'
            ORDER BY r.created_at DESC 
            LIMIT ?
        ";
        
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // NEW: Create booking request (not confirmed until accepted)
    public function sendBookingRequest($rideId, $userId, $seatsRequested = 1, $message = '') {
        try {
            // Get ride details
            $ride = $this->getRideById($rideId);
            if (!$ride) {
                throw new Exception('Ride not found');
            }
            
            if ($ride['user_id'] == $userId) {
                throw new Exception('Cannot request booking for your own ride');
            }
            
            if ($ride['seats_available'] < $seatsRequested) {
                throw new Exception('Not enough seats available');
            }
            
            // Check if user already has a pending/confirmed booking
            $existingBooking = $this->db->fetchOne(
                "SELECT id FROM bookings WHERE ride_id = ? AND user_id = ? AND booking_status IN ('pending', 'confirmed')",
                [$rideId, $userId]
            );
            
            if ($existingBooking) {
                throw new Exception('You already have a booking request for this ride');
            }
            
            $bookingAmount = $ride['price_per_seat'] * $seatsRequested;
            
            // Create booking request with 'pending' status
            $bookingId = $this->db->insert('bookings', [
                'ride_id' => $rideId,
                'user_id' => $userId,
                'seats_booked' => $seatsRequested,
                'booking_amount' => $bookingAmount,
                'booking_status' => 'pending', // Start as pending
                'request_message' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            return $bookingId;
            
        } catch (Exception $e) {
            error_log("RideModel sendBookingRequest error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // NEW: Accept/Reject booking request
    public function respondToBookingRequest($bookingId, $driverId, $status) {
        try {
            $this->db->getConnection()->beginTransaction();
            
            // Get booking details and verify driver
            $booking = $this->db->fetchOne("
                SELECT b.*, r.user_id as driver_id, r.seats_available, r.price_per_seat
                FROM bookings b 
                JOIN rides r ON b.ride_id = r.id 
                WHERE b.id = ? AND r.user_id = ?
            ", [$bookingId, $driverId]);
            
            if (!$booking) {
                throw new Exception('Booking request not found or you are not the driver');
            }
            
            if ($booking['booking_status'] !== 'pending') {
                throw new Exception('Booking request already processed');
            }
            
            if ($status === 'confirmed') {
                // Check if enough seats still available
                if ($booking['seats_available'] < $booking['seats_booked']) {
                    throw new Exception('Not enough seats available');
                }
                
                // Update booking status to confirmed
                $this->db->update('bookings', 
                    ['booking_status' => 'confirmed'], 
                    'id = ?', 
                    [$bookingId]
                );
                
                // Update available seats in ride
                $this->db->update('rides', 
                    ['seats_available' => $booking['seats_available'] - $booking['seats_booked']], 
                    'id = ?', 
                    [$booking['ride_id']]
                );
                
            } else if ($status === 'rejected') {
                // Update booking status to rejected
                $this->db->update('bookings', 
                    ['booking_status' => 'rejected'], 
                    'id = ?', 
                    [$bookingId]
                );
            }
            
            $this->db->getConnection()->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            error_log("RideModel respondToBookingRequest error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // NEW: Get pending booking requests for driver
    // public function getPendingBookingRequests($driverId) {
    //     try {
    //         $sql = "
    //             SELECT b.*, r.source, r.destination, r.ride_date, r.ride_time, r.price_per_seat,
    //                    u.name as passenger_name, u.email as passenger_email
    //             FROM bookings b
    //             JOIN rides r ON b.ride_id = r.id
    //             JOIN users u ON b.user_id = u.id
    //             WHERE r.user_id = ? AND b.booking_status = 'pending'
    //             ORDER BY b.created_at DESC
    //         ";
            
    //         return $this->db->fetchAll($sql, [$driverId]);
            
    //     } catch (Exception $e) {
    //         error_log("RideModel getPendingBookingRequests error: " . $e->getMessage());
    //         return [];
    //     }
    // }
    
    // NEW: Get confirmed bookings for a ride
    public function getConfirmedBookings($rideId) {
        try {
            $sql = "
                SELECT b.*, u.name as passenger_name, u.email as passenger_email, u.phone as passenger_phone
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                WHERE b.ride_id = ? AND b.booking_status = 'confirmed'
                ORDER BY b.created_at ASC
            ";
            
            return $this->db->fetchAll($sql, [$rideId]);
            
        } catch (Exception $e) {
            error_log("RideModel getConfirmedBookings error: " . $e->getMessage());
            return [];
        }
    }
    
    // UPDATED: Get user rides with booking requests
    // public function getUserRides($userId, $type = 'all') {
    //     if ($type === 'created') {
    //         $sql = "
    //             SELECT r.*, 
    //                    COUNT(CASE WHEN b.booking_status = 'confirmed' THEN b.id END) as confirmed_bookings,
    //                    COUNT(CASE WHEN b.booking_status = 'pending' THEN b.id END) as pending_requests,
    //                    SUM(CASE WHEN b.booking_status = 'confirmed' THEN b.seats_booked ELSE 0 END) as total_booked_seats
    //             FROM rides r 
    //             LEFT JOIN bookings b ON r.id = b.ride_id 
    //             WHERE r.user_id = ? 
    //             GROUP BY r.id
    //             ORDER BY r.ride_date DESC, r.ride_time DESC
    //         ";
    //         return $this->db->fetchAll($sql, [$userId]);
    //     } 
    //     elseif ($type === 'booked') {
    //         $sql = "
    //             SELECT r.*, b.seats_booked, b.booking_amount, b.booking_status, b.request_message,
    //                    b.created_at as booking_date, u.name as driver_name, 
    //                    CASE WHEN b.booking_status = 'confirmed' THEN u.phone ELSE NULL END as driver_phone,
    //                    v.model as vehicle_model, v.number_plate
    //             FROM bookings b 
    //             JOIN rides r ON b.ride_id = r.id 
    //             JOIN users u ON r.user_id = u.id 
    //             LEFT JOIN vehicles v ON u.id = v.user_id 
    //             WHERE b.user_id = ? 
    //             ORDER BY r.ride_date DESC, r.ride_time DESC
    //         ";
    //         return $this->db->fetchAll($sql, [$userId]);
    //     }
    //     else {
    //         $created = $this->getUserRides($userId, 'created');
    //         $booked = $this->getUserRides($userId, 'booked');
            
    //         return [
    //             'created' => $created,
    //             'booked' => $booked
    //         ];
    //     }
    // }
    
    // Legacy method for backward compatibility
    public function bookRide($rideId, $userId, $seatsRequested = 1) {
        return $this->sendBookingRequest($rideId, $userId, $seatsRequested);
    }
    
    
    public function getTotalRides() {
        try {
            $result = $this->db->fetchOne("SELECT COUNT(*) as count FROM rides");
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("RideModel getTotalRides error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getCompletedRides() {
        try {
            $result = $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM rides WHERE status = 'completed'"
            );
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("RideModel getCompletedRides error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getActiveRidesWithCoordinates($limit = 50) {
        try {
            $sql = "
                SELECT r.id, r.source, r.destination, r.source_lat, r.source_lng, 
                       r.dest_lat, r.dest_lng, r.price_per_seat, r.seats_available,
                       r.ride_date, r.ride_time, u.name as driver_name 
                FROM rides r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.ride_date >= CURDATE() 
                AND r.seats_available > 0 
                AND r.status = 'active'
                AND r.source_lat IS NOT NULL 
                AND r.source_lng IS NOT NULL 
                LIMIT ?
            ";
            
            return $this->db->fetchAll($sql, [$limit]);
        } catch (Exception $e) {
            error_log("RideModel getActiveRidesWithCoordinates error: " . $e->getMessage());
            return [];
        }
    }
    
    // public function updateRideStatus($rideId, $status) {
    //     try {
    //         return $this->db->update('rides', 
    //             ['status' => $status], 
    //             'id = ?', 
    //             [$rideId]
    //         );
    //     } catch (Exception $e) {
    //         error_log("RideModel updateRideStatus error: " . $e->getMessage());
    //         return false;
    //     }
    // }
    
    // public function cancelBooking($bookingId, $userId) {
    //     try {
    //         $this->db->getConnection()->beginTransaction();
            
    //         $booking = $this->db->fetchOne(
    //             "SELECT * FROM bookings WHERE id = ? AND user_id = ?",
    //             [$bookingId, $userId]
    //         );
            
    //         if (!$booking) {
    //             throw new Exception('Booking not found');
    //         }
            
    //         if ($booking['booking_status'] === 'cancelled') {
    //             throw new Exception('Booking already cancelled');
    //         }
            
    //         $this->db->update('bookings',
    //             ['booking_status' => 'cancelled'],
    //             'id = ?',
    //             [$bookingId]
    //         );
            
    //         // Return seats only if booking was confirmed
    //         if ($booking['booking_status'] === 'confirmed') {
    //             $this->db->query(
    //                 "UPDATE rides SET seats_available = seats_available + ? WHERE id = ?",
    //                 [$booking['seats_booked'], $booking['ride_id']]
    //             );
    //         }
            
    //         $this->db->getConnection()->commit();
    //         return true;
            
    //     } catch (Exception $e) {
    //         $this->db->getConnection()->rollback();
    //         error_log("RideModel cancelBooking error: " . $e->getMessage());
    //         throw $e;
    //     }
    // }
    
    public function getRideStats($userId) {
        try {
            $sql = "
                SELECT 
                    COUNT(DISTINCT CASE WHEN r.user_id = ? THEN r.id END) as rides_created,
                    COUNT(DISTINCT CASE WHEN b.user_id = ? AND b.booking_status = 'confirmed' THEN b.id END) as rides_taken,
                    COALESCE(SUM(CASE WHEN b.user_id = ? AND b.booking_status = 'confirmed' THEN b.seats_booked * 5.2 ELSE 0 END), 0) as co2_saved
                FROM rides r
                LEFT JOIN bookings b ON r.id = b.ride_id
                WHERE r.user_id = ? OR b.user_id = ?
            ";
            
            return $this->db->fetchOne($sql, [$userId, $userId, $userId, $userId, $userId]);
        } catch (Exception $e) {
            error_log("RideModel getRideStats error: " . $e->getMessage());
            return [
                'rides_created' => 0,
                'rides_taken' => 0,
                'co2_saved' => 0
            ];
        }
    }
    
    public function canUserBookRide($rideId, $userId) {
        try {
            $ride = $this->getRideById($rideId);
            
            if (!$ride) {
                return ['can_book' => false, 'reason' => 'Ride not found'];
            }
            
            if ($ride['user_id'] == $userId) {
                return ['can_book' => false, 'reason' => 'Cannot book your own ride'];
            }
            
            if ($ride['seats_available'] <= 0) {
                return ['can_book' => false, 'reason' => 'No seats available'];
            }
            
            if ($ride['status'] !== 'active') {
                return ['can_book' => false, 'reason' => 'Ride is not active'];
            }
            
            $existingBooking = $this->db->fetchOne(
                "SELECT id FROM bookings WHERE ride_id = ? AND user_id = ? AND booking_status IN ('pending', 'confirmed')",
                [$rideId, $userId]
            );
            
            if ($existingBooking) {
                return ['can_book' => false, 'reason' => 'Already have a booking for this ride'];
            }
            
            return ['can_book' => true, 'reason' => 'Can book'];
            
        } catch (Exception $e) {
            error_log("RideModel canUserBookRide error: " . $e->getMessage());
            return ['can_book' => false, 'reason' => 'System error'];
        }
    }



     // NEW: Enhanced method for detailed ride information
    public function getUserRidesDetailed($userId) {
        try {
            // Get detailed created rides
            $createdRides = $this->db->fetchAll("
                SELECT r.*, 
                       COUNT(CASE WHEN b.booking_status = 'confirmed' THEN b.id END) as confirmed_bookings,
                       COUNT(CASE WHEN b.booking_status = 'pending' THEN b.id END) as pending_requests,
                       SUM(CASE WHEN b.booking_status = 'confirmed' THEN b.seats_booked ELSE 0 END) as total_booked_seats,
                       r.seats_available + COALESCE(SUM(CASE WHEN b.booking_status = 'confirmed' THEN b.seats_booked ELSE 0 END), 0) as total_seats
                FROM rides r 
                LEFT JOIN bookings b ON r.id = b.ride_id 
                WHERE r.user_id = ? 
                GROUP BY r.id
                ORDER BY r.ride_date DESC, r.ride_time DESC
            ", [$userId]);
            
            // Get detailed booked rides
            $bookedRides = $this->db->fetchAll("
                SELECT r.*, b.id as booking_id, b.seats_booked, b.booking_amount, b.booking_status, 
                       b.payment_status, b.created_at as booking_date, b.request_message,
                       u.name as driver_name, u.email as driver_email, 
                       CASE WHEN b.booking_status = 'confirmed' THEN u.phone ELSE NULL END as driver_phone,
                       v.model as vehicle_model, v.number_plate, v.color as vehicle_color
                FROM bookings b 
                JOIN rides r ON b.ride_id = r.id 
                JOIN users u ON r.user_id = u.id 
                LEFT JOIN vehicles v ON u.id = v.user_id 
                WHERE b.user_id = ? 
                ORDER BY r.ride_date DESC, r.ride_time DESC
            ", [$userId]);
            
            return [
                'created' => $createdRides,
                'booked' => $bookedRides
            ];
            
        } catch (Exception $e) {
            error_log("RideModel getUserRidesDetailed error: " . $e->getMessage());
            return [
                'created' => [],
                'booked' => []
            ];
        }
    }
    
    // NEW: Enhanced method to get pending booking requests for driver
    public function getPendingBookingRequests($driverId) {
        try {
            $sql = "
                SELECT b.*, r.source, r.destination, r.ride_date, r.ride_time, r.price_per_seat,
                       u.name as passenger_name, u.email as passenger_email, u.phone as passenger_phone
                FROM bookings b
                JOIN rides r ON b.ride_id = r.id
                JOIN users u ON b.user_id = u.id
                WHERE r.user_id = ? AND b.booking_status = 'pending'
                ORDER BY b.created_at DESC
            ";
            
            return $this->db->fetchAll($sql, [$driverId]);
            
        } catch (Exception $e) {
            error_log("RideModel getPendingBookingRequests error: " . $e->getMessage());
            return [];
        }
    }
    
    // NEW: Enhanced update ride status with history tracking
    // public function updateRideStatus($rideId, $status, $userId, $reason = '') {
    //     try {
    //         $this->db->getConnection()->beginTransaction();
            
    //         // Get current ride details
    //         $ride = $this->db->fetchOne(
    //             "SELECT * FROM rides WHERE id = ? AND user_id = ?",
    //             [$rideId, $userId]
    //         );
            
    //         if (!$ride) {
    //             throw new Exception('Ride not found or you are not the owner');
    //         }
            
    //         $currentStatus = $ride['status'];
            
    //         // Validate status transition
    //         if (!$this->isValidStatusTransition($currentStatus, $status)) {
    //             throw new Exception('Invalid status transition');
    //         }
            
    //         // Update ride status
    //         $updateData = ['status' => $status];
            
    //         if ($status === 'in-progress') {
    //             $updateData['started_at'] = date('Y-m-d H:i:s');
                
    //             // Update all confirmed bookings to in-progress
    //             $this->db->query(
    //                 "UPDATE bookings SET booking_status = 'in-progress' 
    //                  WHERE ride_id = ? AND booking_status = 'confirmed'",
    //                 [$rideId]
    //             );
    //         } elseif ($status === 'completed') {
    //             $updateData['completed_at'] = date('Y-m-d H:i:s');
                
    //             // Update all in-progress bookings to completed
    //             $this->db->query(
    //                 "UPDATE bookings SET booking_status = 'completed' 
    //                  WHERE ride_id = ? AND booking_status = 'in-progress'",
    //                 [$rideId]
    //             );
    //         } elseif ($status === 'cancelled') {
    //             $updateData['cancellation_reason'] = $reason;
                
    //             // Cancel all pending and confirmed bookings
    //             $this->db->query(
    //                 "UPDATE bookings SET booking_status = 'cancelled', cancellation_reason = ? 
    //                  WHERE ride_id = ? AND booking_status IN ('pending', 'confirmed')",
    //                 [$reason, $rideId]
    //             );
    //         }
            
    //         $this->db->update('rides', $updateData, 'id = ?', [$rideId]);
            
    //         // Log status change in history
    //         $this->logStatusChange($rideId, $currentStatus, $status, $userId, $reason);
            
    //         $this->db->getConnection()->commit();
    //         return true;
            
    //     } catch (Exception $e) {
    //         $this->db->getConnection()->rollback();
    //         error_log("RideModel updateRideStatus error: " . $e->getMessage());
    //         throw $e;
    //     }
    // }
    
    // NEW: Delete ride with validation
    public function deleteRide($rideId, $userId) {
        try {
            $this->db->getConnection()->beginTransaction();
            
            // Check if user owns the ride
            $ride = $this->db->fetchOne(
                "SELECT * FROM rides WHERE id = ? AND user_id = ?",
                [$rideId, $userId]
            );
            
            if (!$ride) {
                throw new Exception('Ride not found or you are not the owner');
            }
            
            // Check if there are any confirmed bookings
            $confirmedBookings = $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM bookings 
                 WHERE ride_id = ? AND booking_status = 'confirmed'",
                [$rideId]
            );
            
            if ($confirmedBookings['count'] > 0) {
                throw new Exception('Cannot delete ride with confirmed bookings');
            }
            
            // Cancel any pending bookings
            $this->db->query(
                "UPDATE bookings SET booking_status = 'cancelled', cancellation_reason = 'Ride deleted by driver' 
                 WHERE ride_id = ? AND booking_status = 'pending'",
                [$rideId]
            );
            
            // Delete the ride
            $this->db->delete('rides', 'id = ? AND user_id = ?', [$rideId, $userId]);
            
            $this->db->getConnection()->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            error_log("RideModel deleteRide error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // NEW: Enhanced cancel booking with reason
    public function cancelBooking($bookingId, $userId, $reason = '') {
        try {
            $this->db->getConnection()->beginTransaction();
            
            $booking = $this->db->fetchOne(
                "SELECT b.*, r.user_id as driver_id FROM bookings b 
                 JOIN rides r ON b.ride_id = r.id 
                 WHERE b.id = ? AND b.user_id = ?",
                [$bookingId, $userId]
            );
            
            if (!$booking) {
                throw new Exception('Booking not found');
            }
            
            if (!in_array($booking['booking_status'], ['pending', 'confirmed'])) {
                throw new Exception('Cannot cancel this booking');
            }
            
            // Update booking status
            $this->db->update('bookings',
                [
                    'booking_status' => 'cancelled',
                    'cancellation_reason' => $reason
                ],
                'id = ?',
                [$bookingId]
            );
            
            // Return seats to ride if booking was confirmed
            if ($booking['booking_status'] === 'confirmed') {
                $this->db->query(
                    "UPDATE rides SET seats_available = seats_available + ? WHERE id = ?",
                    [$booking['seats_booked'], $booking['ride_id']]
                );
            }
            
            $this->db->getConnection()->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            error_log("RideModel cancelBooking error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Helper method to validate status transitions
   // Helper method to validate status transitions
private function isValidStatusTransition($currentStatus, $newStatus) {
    $validTransitions = [
        'active' => ['started', 'cancelled'],  // Fixed: 'in-progress' को 'started' में change
        'started' => ['completed', 'cancelled'], // Fixed: 'in-progress' को 'started' में change
        'completed' => [], // No transitions from completed
        'cancelled' => []  // No transitions from cancelled
    ];
    
    return in_array($newStatus, $validTransitions[$currentStatus] ?? []);
}

// Update updateRideStatus method
public function updateRideStatus($rideId, $status, $userId, $reason = '') {
    try {
        $this->db->getConnection()->beginTransaction();
        
        // Get current ride details
        $ride = $this->db->fetchOne(
            "SELECT * FROM rides WHERE id = ? AND user_id = ?",
            [$rideId, $userId]
        );
        
        if (!$ride) {
            throw new Exception('Ride not found or you are not the owner');
        }
        
        $currentStatus = $ride['status'];
        
        // Validate status transition
        if (!$this->isValidStatusTransition($currentStatus, $status)) {
            throw new Exception("Cannot change ride status from '{$currentStatus}' to '{$status}'");
        }
        
        // Update ride status
        $updateData = ['status' => $status];
        
        if ($status === 'started') {  // Changed from 'in-progress'
            $updateData['started_at'] = date('Y-m-d H:i:s');
            
            // Update all confirmed bookings to started
            $this->db->query(
                "UPDATE bookings SET booking_status = 'started' 
                 WHERE ride_id = ? AND booking_status = 'confirmed'",
                [$rideId]
            );
        } elseif ($status === 'completed') {
            $updateData['completed_at'] = date('Y-m-d H:i:s');
            
            // Update all started bookings to completed
            $this->db->query(
                "UPDATE bookings SET booking_status = 'completed' 
                 WHERE ride_id = ? AND booking_status = 'started'",
                [$rideId]
            );
        } elseif ($status === 'cancelled') {
            $updateData['cancellation_reason'] = $reason;
            
            // Cancel all pending and confirmed bookings
            $this->db->query(
                "UPDATE bookings SET booking_status = 'cancelled', cancellation_reason = ? 
                 WHERE ride_id = ? AND booking_status IN ('pending', 'confirmed', 'started')",
                [$reason, $rideId]
            );
        }
        
        $this->db->update('rides', $updateData, 'id = ?', [$rideId]);
        
        // Log status change in history
        $this->logStatusChange($rideId, $currentStatus, $status, $userId, $reason);
        
        $this->db->getConnection()->commit();
        return true;
        
    } catch (Exception $e) {
        $this->db->getConnection()->rollback();
        error_log("RideModel updateRideStatus error: " . $e->getMessage());
        throw $e;
    }
}

    // Helper method to log status changes
    private function logStatusChange($rideId, $oldStatus, $newStatus, $changedBy, $reason = '') {
        try {
            // Check if ride_status_history table exists, if not create it
            $this->createStatusHistoryTableIfNotExists();
            
            $this->db->insert('ride_status_history', [
                'ride_id' => $rideId,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => $changedBy,
                'reason' => $reason
            ]);
        } catch (Exception $e) {
            error_log("Failed to log status change: " . $e->getMessage());
            // Don't throw error as this is just logging
        }
    }
    
    // Helper method to create status history table if it doesn't exist
    private function createStatusHistoryTableIfNotExists() {
        try {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS ride_status_history (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    ride_id INT NOT NULL,
                    old_status VARCHAR(50),
                    new_status VARCHAR(50) NOT NULL,
                    changed_by INT NOT NULL,
                    reason TEXT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    
                    FOREIGN KEY (ride_id) REFERENCES rides(id) ON DELETE CASCADE,
                    FOREIGN KEY (changed_by) REFERENCES users(id) ON DELETE CASCADE,
                    INDEX idx_ride_status (ride_id, new_status)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        } catch (Exception $e) {
            // Table might already exist or foreign key constraint issues
            error_log("Status history table creation warning: " . $e->getMessage());
        }
    }




    // Complete ride method
public function completeRide($rideId) {
    try {
        $this->db->getConnection()->beginTransaction();
        
        // Update ride status
        $this->db->update('rides', 
            ['status' => 'completed'], 
            'id = ?', 
            [$rideId]
        );
        
        // Update all confirmed bookings to completed
        $this->db->update('bookings',
            ['booking_status' => 'completed'],
            'ride_id = ? AND booking_status = ?',
            [$rideId, 'confirmed']
        );
        
        $this->db->getConnection()->commit();
        return true;
        
    } catch (Exception $e) {
        $this->db->getConnection()->rollback();
        error_log("RideModel completeRide error: " . $e->getMessage());
        return false;
    }
}

// Mark cash received
public function markCashReceived($bookingId, $driverId) {
    try {
        // First verify this booking belongs to driver's ride
        $booking = $this->db->fetchOne(
            "SELECT b.*, r.user_id as driver_id 
             FROM bookings b 
             JOIN rides r ON b.ride_id = r.id 
             WHERE b.id = ?",
            [$bookingId]
        );
        
        if (!$booking || $booking['driver_id'] != $driverId) {
            throw new Exception('Unauthorized or booking not found');
        }
        
        // Update payment status to completed
        $this->db->update('bookings',
            ['payment_status' => 'completed'],
            'id = ?',
            [$bookingId]
        );
        
        return true;
        
    } catch (Exception $e) {
        error_log("RideModel markCashReceived error: " . $e->getMessage());
        throw $e;
    }
}

// Get user rides with enhanced filtering
public function getUserRides($userId, $type = 'all', $filter = 'all') {
    if ($type === 'created') {
        $sql = "
            SELECT r.*, 
                   COUNT(CASE WHEN b.booking_status != 'cancelled' THEN b.id END) as total_bookings,
                   SUM(CASE WHEN b.booking_status != 'cancelled' THEN b.seats_booked ELSE 0 END) as total_booked_seats,
                   SUM(CASE WHEN b.payment_status = 'completed' THEN b.booking_amount ELSE 0 END) as total_received,
                   SUM(CASE WHEN b.booking_status != 'cancelled' THEN b.booking_amount ELSE 0 END) as total_expected
            FROM rides r 
            LEFT JOIN bookings b ON r.id = b.ride_id 
            WHERE r.user_id = ?
        ";
        
        // Add filter conditions
        if ($filter !== 'all') {
            $sql .= " AND r.status = ?";
            $params = [$userId, $filter];
        } else {
            $params = [$userId];
        }
        
        $sql .= " GROUP BY r.id ORDER BY r.ride_date DESC, r.ride_time DESC";
        
        return $this->db->fetchAll($sql, $params);
        
    } elseif ($type === 'booked') {
        $sql = "
            SELECT r.*, b.id as booking_id, b.seats_booked, b.booking_amount, 
                   b.booking_status, b.payment_status,
                   b.created_at as booking_date, u.name as driver_name, u.phone as driver_phone,
                   v.model as vehicle_model, v.number_plate
            FROM bookings b 
            JOIN rides r ON b.ride_id = r.id 
            JOIN users u ON r.user_id = u.id 
            LEFT JOIN vehicles v ON u.id = v.user_id 
            WHERE b.user_id = ?
        ";
        
        // Add filter for booked rides
        if ($filter !== 'all') {
            $sql .= " AND b.booking_status = ?";
            $params = [$userId, $filter];
        } else {
            $params = [$userId];
        }
        
        $sql .= " ORDER BY r.ride_date DESC, r.ride_time DESC";
        
        return $this->db->fetchAll($sql, $params);
        
    } else {
        // Return both with filter
        $created = $this->getUserRides($userId, 'created', $filter);
        $booked = $this->getUserRides($userId, 'booked', $filter);
        
        return [
            'created' => $created,
            'booked' => $booked
        ];
    }
}

// Get booking details with payment info
public function getBookingDetails($rideId, $driverId) {
    $sql = "
        SELECT b.*, u.name as passenger_name, u.email as passenger_email,
               CASE 
                   WHEN b.payment_status = 'completed' THEN 'Cash Received'
                   WHEN b.payment_status = 'pending' THEN 'Payment Pending'
                   ELSE 'Unknown'
               END as payment_status_text
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN rides r ON b.ride_id = r.id
        WHERE b.ride_id = ? AND r.user_id = ? AND b.booking_status != 'cancelled'
        ORDER BY b.created_at ASC
    ";
    
    return $this->db->fetchAll($sql, [$rideId, $driverId]);
}


/* app/models/RideModel.php  (new helper) */
public function canCompleteRide($rideId) {
    $row = $this->db->fetchOne(
        "SELECT COUNT(*) as pending
           FROM bookings
          WHERE ride_id = ? AND status = 'confirmed' AND payment_mode IS NULL",
        [$rideId]
    );
    return $row['pending'] == 0;
}

/* app/models/RideModel.php  (new) */
public function recordPayment($bookingId, $driverId, $mode) {
    return $this->db->update('bookings',
        ['payment_mode'=>$mode,
         'payment_recorded_at'=>date('Y-m-d H:i:s'),
         'payment_confirmed_by'=>$driverId],
        'id = ?',[$bookingId]);
}


}
?>
