<?php
require_once 'app/models/UserModel.php';
require_once 'app/models/RideModel.php';
require_once 'app/models/EsgModel.php';

class HomeController {
    private $userModel;
    private $rideModel;
    private $esgModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
        $this->rideModel = new RideModel();
        $this->esgModel = new EsgModel();
    }
    
    public function index() {
        $data = [
            'stats' => $this->getStatsData(), // Changed method name
            'featured_rides' => $this->rideModel->getFeaturedRides(4),
            'testimonials' => $this->getTestimonials(),
            'page_title' => 'Home - Ride Smarter, Connect Better',
            'csrf_token' => Security::generateCSRFToken()
        ];
        
        $this->loadView('home', $data);
    }
    
    // Separate method for API calls
    public function getStats() {
        header('Content-Type: application/json');
        
        try {
            $stats = $this->getStatsData();
            echo json_encode($stats);
        } catch (Exception $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
        exit; // Important: Stop execution after JSON output
    }
    
    // Internal method to get stats data (no JSON output)
    private function getStatsData() {
        try {
            return [
                'total_rides' => $this->rideModel->getTotalRides(),
                'co2_saved' => $this->esgModel->getCO2Savings(),
                'money_saved' => $this->esgModel->getMoneySaved(),
                'active_users' => $this->userModel->getActiveUsersCount()
            ];
        } catch (Exception $e) {
            // Return default values if database error
            return [
                'total_rides' => 0,
                'co2_saved' => 0,
                'money_saved' => 0,
                'active_users' => 0
            ];
        }
    }
    
    public function getMapData() {
        header('Content-Type: application/json');
        
        try {
            $rides = $this->rideModel->getActiveRidesWithCoordinates();
            echo json_encode(['success' => true, 'rides' => $rides]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    public function geocodeLocation() {
        header('Content-Type: application/json');
        
        $query = $_GET['q'] ?? '';
        if (empty($query)) {
            echo json_encode([]);
            exit;
        }
        
        try {
            $url = OSM_NOMINATIM_URL . "/search?format=json&q=" . urlencode($query) . "&limit=5&countrycodes=in";
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'user_agent' => 'Carpool India v1.0'
                ]
            ]);
            
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                echo json_encode([]);
            } else {
                $data = json_decode($response, true);
                $results = [];
                
                if (is_array($data)) {
                    foreach ($data as $item) {
                        $results[] = [
                            'display_name' => $item['display_name'],
                            'lat' => $item['lat'],
                            'lon' => $item['lon'],
                            'type' => $item['type'] ?? 'location'
                        ];
                    }
                }
                
                echo json_encode($results);
            }
        } catch (Exception $e) {
            error_log("Geocoding error: " . $e->getMessage());
            echo json_encode([]);
        }
        exit;
    }
    
    public function privacy() {
        $data = [
            'page_title' => 'Privacy Policy - Carpool India'
        ];
        $this->loadView('privacy', $data);
    }
    
    private function getTestimonials() {
        return [
            [
                'name' => 'Priya Sharma',
                'designation' => 'Software Engineer',
                'company' => 'TCS Mumbai',
                'text' => 'Carpool India has completely transformed my daily commute! I save ₹3000+ monthly and have made amazing friends.',
                'rating' => 5,
                'avatar' => 'PS'
            ],
            [
                'name' => 'Rahul Kumar',
                'designation' => 'Marketing Manager', 
                'company' => 'Wipro Bangalore',
                'text' => 'Excellent platform with great safety features and verified users. Highly recommended for corporate employees!',
                'rating' => 5,
                'avatar' => 'RK'
            ],
            [
                'name' => 'Sneha Patel',
                'designation' => 'Data Analyst',
                'company' => 'Infosys Pune', 
                'text' => 'Love the ESG focus! I feel good knowing I\'m contributing to a greener environment while saving money.',
                'rating' => 5,
                'avatar' => 'SP'
            ]
        ];
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
