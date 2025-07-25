<?php
// Database Configuration
// define('DB_HOST', 'srv1086.hstgr.io');
// define('DB_NAME', 'u141142577_carpoolindia');
// define('DB_USER', 'u141142577_carpoolindia');
// define('DB_PASS', 'Pink@1234!');



// define('DB_HOST', 'localhost');
// define('DB_NAME', 'carpoolindiaa');
// define('DB_USER', 'root');
// define('DB_PASS', '');


define('DB_HOST', 'localhost');
define('DB_NAME', 'recru2l1_carpoolindia');
define('DB_USER', 'recru2l1_carpoolindia');
define('DB_PASS', 'Carpool@1925@');

// SMTP Configuration
define('SMTP_HOST', 'smtp.office365.com');
define('SMTP_USERNAME', 'noreply@carpoolindia.com');
define('SMTP_PASSWORD', 'rN0RiXVw');
define('SMTP_PORT', 587);

// App Configuration
define('APP_NAME', 'Carpool India');
define('APP_URL', 'http://localhost/carpoolIndia');  // Correct case
define('BASE_PATH', '/carpoolIndia');  // Correct case

// Security Keys
// define('JWT_SECRET', 'carpool_india_jwt_secret_2024');
// define('CSRF_SECRET', 'carpool_india_csrf_secret_2024');

// Upload paths
$base_dir = __DIR__ . '/..';
define('UPLOAD_PATH', $base_dir . '/public/uploads/');
define('PROFILE_UPLOAD_PATH', UPLOAD_PATH . 'profiles/');
define('VEHICLE_UPLOAD_PATH', UPLOAD_PATH . 'vehicles/');

// Create upload directories if they don't exist
if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755, true);
}
if (!file_exists(PROFILE_UPLOAD_PATH)) {
    mkdir(PROFILE_UPLOAD_PATH, 0755, true);
}
if (!file_exists(VEHICLE_UPLOAD_PATH)) {
    mkdir(VEHICLE_UPLOAD_PATH, 0755, true);
}

// OpenStreetMap API
define('OSM_NOMINATIM_URL', 'https://nominatim.openstreetmap.org');

// Error reporting for development
if (!defined('PRODUCTION')) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
}

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Test database connection
try {
    $test_conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed in config: " . $e->getMessage());
}
?>
