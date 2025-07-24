<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load configuration
require_once 'config/config.php';

// Check if helper files exist and load them
$required_files = [
    'app/helpers/Router.php',
    'app/helpers/Database.php',
    'app/helpers/Security.php',
    'app/helpers/Mailer.php'  // ⭐ यह line add करनी है
];

foreach ($required_files as $file) {
    if (!file_exists($file)) {
        die("Required file missing: {$file}");
    }
    require_once $file;
}

// Test database connection
try {
    $testDb = Database::getInstance();
    $connection = $testDb->getConnection();
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Initialize router
$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/signup', 'AuthController@showSignup');
$router->post('/signup-step1', 'AuthController@signupStep1');
$router->post('/signup-step2', 'AuthController@signupStep2');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->post('/forgot-password', 'AuthController@forgotPassword');
$router->post('/reset-password', 'AuthController@resetPassword');
$router->get('/dashboard', 'DashboardController@index');
$router->post('/dashboard/search', 'DashboardController@searchRides');
$router->post('/dashboard/create-ride', 'DashboardController@createRide');
$router->post('/dashboard/book-ride', 'DashboardController@bookRide');
$router->get('/dashboard/my-rides', 'DashboardController@myRides');
$router->get('/profile', 'ProfileController@index');
$router->post('/profile/update', 'ProfileController@updateProfile');
$router->post('/profile/update-vehicle', 'ProfileController@updateVehicle');
$router->post('/profile/change-password', 'ProfileController@changePassword');
$router->post('/profile/upload-avatar', 'ProfileController@uploadAvatar');
$router->get('/about', 'AboutController@index');
$router->get('/esg', 'EsgController@index');
$router->get('/contact', 'ContactController@index');
$router->post('/contact/submit', 'ContactController@submit');
$router->get('/privacy', 'HomeController@privacy');
$router->get('/api/map-data', 'HomeController@getMapData');
$router->get('/api/geocode', 'HomeController@geocodeLocation');
$router->post('/api/search-rides', 'DashboardController@searchRides');
$router->get('/api/stats', 'HomeController@getStats');


// Connection routes
$router->get('/dashboard/connections', 'DashboardController@connections');
$router->post('/dashboard/send-request', 'DashboardController@sendConnectionRequest');
$router->post('/dashboard/respond-request', 'DashboardController@respondToRequest');
$router->post('/dashboard/send-booking-request', 'DashboardController@sendBookingRequest');
$router->post('/dashboard/respond-booking-request', 'DashboardController@respondToBookingRequest');

// Add these routes after existing dashboard routes
$router->post('/dashboard/start-ride', 'DashboardController@startRide');
$router->post('/dashboard/complete-ride', 'DashboardController@completeRide');
$router->post('/dashboard/mark-cash-received', 'DashboardController@markCashReceived');
$router->get('/dashboard/rides/filter', 'DashboardController@getFilteredRides');




// Booking request routes (ADD THESE)
$router->post('/dashboard/send-booking-request', 'DashboardController@sendBookingRequest');
$router->post('/dashboard/respond-booking-request', 'DashboardController@respondToBookingRequest');
$router->get('/dashboard/booking-requests', 'DashboardController@getBookingRequests');


// Enhanced My Rides routes
$router->get('/dashboard/my-rides', 'DashboardController@myRides');
$router->post('/dashboard/update-ride-status', 'DashboardController@updateRideStatus');
$router->post('/dashboard/delete-ride', 'DashboardController@deleteRide');
$router->post('/dashboard/cancel-booking', 'DashboardController@cancelBooking');
$router->post('/dashboard/mark-cash-received', 'DashboardController@markCashReceived');
$router->post('/dashboard/send-booking-request', 'DashboardController@sendBookingRequest');
$router->post('/dashboard/respond-booking-request', 'DashboardController@respondToBookingRequest');

$router->post('/dashboard/record-payment', 'DashboardController@recordPayment');
$router->post('/dashboard/complete-ride',  'DashboardController@completeRide');


$router->post('/dashboard/record-payment', 'DashboardController@recordPayment');
$router->post('/dashboard/complete-ride', 'DashboardController@completeRide');


// Add these routes in index.php
$router->post('/dashboard/start-ride', 'DashboardController@startRide');
$router->post('/dashboard/complete-ride', 'DashboardController@completeRide');
$router->post('/dashboard/update-ride-status', 'DashboardController@updateRideStatus');
$router->post('/dashboard/record-payment', 'DashboardController@recordPayment');
$router->post('/dashboard/respond-booking-request', 'DashboardController@respondToBookingRequest');
$router->post('/dashboard/cancel-booking', 'DashboardController@cancelBooking');




// Dispatch the request
try {
    $router->dispatch();
} catch (Exception $e) {
    error_log('Router error: ' . $e->getMessage());
    
    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => true,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
