<?php
require_once 'app/models/UserModel.php';
require_once 'app/helpers/Security.php';
require_once 'app/helpers/Mailer.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->userModel = new UserModel();
    }
    
    public function showSignup() {
        if (Security::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        
        $data = [
            'page_title' => 'Sign Up - Join Carpool India',
            'csrf_token' => Security::generateCSRFToken()
        ];
        $this->loadView('auth/signup', $data);
    }
    
    public function signupStep1() {
        header('Content-Type: application/json');
        
        try {
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            
            if (!Security::validateEmail($email)) {
                throw new Exception('Please enter a valid email address');
            }
            
            if ($this->userModel->emailExists($email)) {
                throw new Exception('This email is already registered. Please login instead.');
            }
            
            // Generate OTP
            $otp = Security::generateOTP();
            $this->userModel->storeOtp($email, $otp);
            
            // Try to send OTP email
            $mailer = new Mailer();
            $emailSent = $mailer->sendOTP($email, $otp);
            
            $_SESSION['signup_email'] = $email;
            
            if ($emailSent) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'OTP sent successfully to your email! Please check your inbox.'
                ]);
            } else {
                // Show OTP in response as fallback
                echo json_encode([
                    'success' => true, 
                    'message' => "Email delivery may be delayed. Your OTP is: {$otp}\n\nPlease use this OTP to continue registration.",
                    'otp' => $otp
                ]);
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    public function signupStep2() {
        header('Content-Type: application/json');
        
        try {
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $email = $_SESSION['signup_email'] ?? '';
            $otp = $_POST['otp'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $name = Security::sanitizeInput($_POST['name'] ?? '');
            $phone = Security::sanitizeInput($_POST['phone'] ?? '');
            
            if (empty($email) || empty($otp) || empty($password) || empty($name)) {
                throw new Exception('Please fill all required fields');
            }
            
            if ($password !== $confirmPassword) {
                throw new Exception('Passwords do not match');
            }
            
            if (strlen($password) < 8) {
                throw new Exception('Password must be at least 8 characters long');
            }
            
            if (!empty($phone) && !preg_match('/^[6-9]\d{9}$/', $phone)) {
                throw new Exception('Please enter a valid Indian phone number');
            }
            
            // Verify OTP
            if (!$this->userModel->verifyOtp($email, $otp)) {
                throw new Exception('Invalid or expired OTP. Please try again.');
            }
            
            // Create user
            $userData = [
                'email' => $email,
                'password' => $password,
                'name' => $name,
                'phone' => $phone
            ];
            
            $userId = $this->userModel->createUser($userData);
            
            if ($userId) {
                // Send welcome email
                $mailer = new Mailer();
                $mailer->sendWelcome($email, $name);
                
                // Create session
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                
                // Clear signup session
                unset($_SESSION['signup_email']);
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Account created successfully! Welcome to Carpool India.',
                    'redirect' => '/dashboard'
                ]);
            } else {
                throw new Exception('Registration failed. Please try again.');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    public function showLogin() {
        if (Security::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        
        $data = [
            'page_title' => 'Login - Carpool India',
            'csrf_token' => Security::generateCSRFToken()
        ];
        $this->loadView('auth/login', $data);
    }
    
    public function login() {
        header('Content-Type: application/json');
        
        try {
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            
            if (!Security::validateEmail($email)) {
                throw new Exception('Please enter a valid email address');
            }
            
            if (empty($password)) {
                throw new Exception('Please enter your password');
            }
            
            $user = $this->userModel->getUserByEmail($email);
            
            if (!$user || !Security::verifyPassword($password, $user['password'])) {
                throw new Exception('Invalid email or password');
            }
            
            // Create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            
            echo json_encode([
                'success' => true, 
                'message' => 'Login successful!',
                'redirect' => '/dashboard'
            ]);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
    
    public function forgotPassword() {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Feature under development']);
        exit;
    }
    
    public function resetPassword() {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Feature under development']);
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
