<?php
require_once 'app/models/UserModel.php';
require_once 'app/models/VehicleModel.php';
require_once 'app/helpers/Security.php';
require_once 'app/helpers/Mailer.php';

class ProfileController {
    private $userModel;
    private $vehicleModel;
    private $mailer;
    
    public function __construct() {
        Security::redirectIfNotLoggedIn();
        
        $this->userModel = new UserModel();
        $this->vehicleModel = new VehicleModel();
        $this->mailer = new Mailer();
    }
    
    public function index() {
        $user = Security::getCurrentUser();
        
        $data = [
            'page_title' => 'Profile - Carpool India',
            'user' => $this->userModel->getUserById($user['id']),
            'vehicle' => $this->vehicleModel->getUserVehicle($user['id']),
            'csrf_token' => Security::generateCSRFToken()
        ];
        
        $this->loadView('profile', $data);
    }
    
    public function updateProfile() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            
            // Validate CSRF token
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $name = Security::sanitizeInput($_POST['name'] ?? '');
            $phone = Security::sanitizeInput($_POST['phone'] ?? '');
            
            if (empty($name)) {
                throw new Exception('Name is required');
            }
            
            if (strlen($name) < 2 || strlen($name) > 50) {
                throw new Exception('Name must be between 2 and 50 characters');
            }
            
            if (!empty($phone) && !preg_match('/^[6-9]\d{9}$/', $phone)) {
                throw new Exception('Please enter a valid Indian phone number');
            }
            
            $updateData = [
                'name' => $name,
                'phone' => $phone
            ];
            
            if ($this->userModel->updateUser($user['id'], $updateData)) {
                // Update session
                $_SESSION['user_name'] = $name;
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Profile updated successfully!'
                ]);
            } else {
                throw new Exception('Failed to update profile. Please try again.');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function updateVehicle() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            
            // Validate CSRF token
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $model = Security::sanitizeInput($_POST['model'] ?? '');
            $numberPlate = Security::sanitizeInput($_POST['number_plate'] ?? '');
            $color = Security::sanitizeInput($_POST['color'] ?? '');
            $seats = (int)($_POST['seats'] ?? 4);
            
            if (empty($model)) {
                throw new Exception('Vehicle model is required');
            }
            
            if (empty($numberPlate)) {
                throw new Exception('Number plate is required');
            }
            
            // Validate number plate format (Indian)
            if (!preg_match('/^[A-Z]{2}\s?\d{1,2}\s?[A-Z]{1,2}\s?\d{1,4}$/', strtoupper($numberPlate))) {
                throw new Exception('Please enter a valid Indian number plate (e.g., MH 01 AB 1234)');
            }
            
            if ($seats < 2 || $seats > 8) {
                throw new Exception('Number of seats must be between 2 and 8');
            }
            
            // Check if number plate already exists for another user
            if ($this->vehicleModel->isNumberPlateExists($numberPlate, $user['id'])) {
                throw new Exception('This number plate is already registered by another user');
            }
            
            $vehicleData = [
                'model' => $model,
                'number_plate' => $numberPlate,
                'color' => $color,
                'seats' => $seats
            ];
            
            if ($this->vehicleModel->updateVehicle($user['id'], $vehicleData)) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Vehicle details updated successfully!'
                ]);
            } else {
                throw new Exception('Failed to update vehicle details. Please try again.');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function changePassword() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            
            // Validate CSRF token
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                throw new Exception('Please fill all password fields');
            }
            
            if ($newPassword !== $confirmPassword) {
                throw new Exception('New passwords do not match');
            }
            
            if (strlen($newPassword) < 8) {
                throw new Exception('New password must be at least 8 characters long');
            }
            
            // Verify current password
            $userData = $this->userModel->getUserById($user['id']);
            if (!Security::verifyPassword($currentPassword, $userData['password'])) {
                throw new Exception('Current password is incorrect');
            }
            
            if ($this->userModel->updatePassword($user['id'], $newPassword)) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Password changed successfully!'
                ]);
            } else {
                throw new Exception('Failed to change password. Please try again.');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function uploadAvatar() {
        header('Content-Type: application/json');
        
        try {
            $user = Security::getCurrentUser();
            
            if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Please select a valid image file');
            }
            
            $file = $_FILES['avatar'];
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            
            // Validate file type
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception('Only JPEG, PNG and GIF files are allowed');
            }
            
            // Validate file size
            if ($file['size'] > $maxSize) {
                throw new Exception('File size must be less than 2MB');
            }
            
            // Create upload directory if not exists
            if (!file_exists(PROFILE_UPLOAD_PATH)) {
                mkdir(PROFILE_UPLOAD_PATH, 0755, true);
            }
            
            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . $user['id'] . '_' . time() . '.' . $extension;
            $filepath = PROFILE_UPLOAD_PATH . $filename;
            
            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Update user profile picture
                if ($this->userModel->updateProfilePicture($user['id'], $filename)) {
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Profile picture updated successfully!',
                        'filename' => $filename
                    ]);
                } else {
                    // Delete uploaded file if database update fails
                    unlink($filepath);
                    throw new Exception('Failed to update profile picture');
                }
            } else {
                throw new Exception('Failed to upload file');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
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
