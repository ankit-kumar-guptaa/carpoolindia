<?php
require_once 'app/models/ContactModel.php';
require_once 'app/helpers/Security.php';
require_once 'app/helpers/Mailer.php';

class ContactController {
    private $contactModel;
    private $mailer;
    
    public function __construct() {
        $this->contactModel = new ContactModel();
        $this->mailer = new Mailer();
    }
    
    public function index() {
        $data = [
            'page_title' => 'Contact Us - Carpool India',
            'csrf_token' => Security::generateCSRFToken(),
            'contact_info' => $this->getContactInfo()
        ];
        
        $this->loadView('contact', $data);
    }
    
    public function submit() {
        header('Content-Type: application/json');
        
        try {
            // Validate CSRF token
            if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid request');
            }
            
            $name = Security::sanitizeInput($_POST['name'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $subject = Security::sanitizeInput($_POST['subject'] ?? '');
            $message = Security::sanitizeInput($_POST['message'] ?? '');
            
            // Validation
            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                throw new Exception('Please fill all required fields');
            }
            
            if (!Security::validateEmail($email)) {
                throw new Exception('Please enter a valid email address');
            }
            
            if (strlen($name) < 2 || strlen($name) > 50) {
                throw new Exception('Name must be between 2 and 50 characters');
            }
            
            if (strlen($subject) < 5 || strlen($subject) > 100) {
                throw new Exception('Subject must be between 5 and 100 characters');
            }
            
            if (strlen($message) < 10 || strlen($message) > 1000) {
                throw new Exception('Message must be between 10 and 1000 characters');
            }
            
            $contactData = [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message
            ];
            
            if ($this->contactModel->saveContact($contactData)) {
                // Send auto-reply to user
                $this->sendAutoReply($email, $name, $subject);
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Thank you for contacting us! We will get back to you soon.'
                ]);
            } else {
                throw new Exception('Failed to submit your message. Please try again.');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    private function sendAutoReply($email, $name, $subject) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = SMTP_PORT;
            
            $mail->setFrom(SMTP_USERNAME, APP_NAME);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Thank you for contacting Carpool India';
            
            $mail->Body = "
                <div style='max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;'>
                    <div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;'>
                        <h1 style='color: white; margin: 0;'>Thank You for Reaching Out!</h1>
                    </div>
                    <div style='background: white; padding: 40px; border-left: 5px solid #667eea;'>
                        <h2 style='color: #333;'>Dear {$name},</h2>
                        <p style='color: #666; line-height: 1.6;'>
                            Thank you for contacting Carpool India regarding: <strong>{$subject}</strong>
                        </p>
                        <p style='color: #666; line-height: 1.6;'>
                            We have received your message and our team will review it carefully. 
                            We typically respond within 24-48 hours during business days.
                        </p>
                        <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <h3 style='color: #667eea; margin: 0 0 10px 0;'>Need Immediate Help?</h3>
                            <p style='margin: 0; color: #666;'>
                                📧 Email: support@carpoolindia.com<br>
                                📱 Phone: +91-9876543210<br>
                                🕒 Business Hours: Mon-Fri, 9 AM - 6 PM IST
                            </p>
                        </div>
                        <p style='color: #666;'>
                            Best regards,<br>
                            <strong>Carpool India Team</strong>
                        </p>
                    </div>
                </div>
            ";
            
            $mail->send();
        } catch (Exception $e) {
            error_log("Auto-reply email error: " . $e->getMessage());
        }
    }
    
    private function getContactInfo() {
        return [
            'email' => 'support@carpoolindia.com',
            'phone' => '+91-9876543210',
            'address' => 'Elite Corporate Solutions, Sector 62, Noida, UP 201309',
            'business_hours' => 'Monday - Friday: 9:00 AM - 6:00 PM IST',
            'social_media' => [
                'facebook' => 'https://facebook.com/carpoolindia',
                'twitter' => 'https://twitter.com/carpoolindia',
                'linkedin' => 'https://linkedin.com/company/carpoolindia',
                'instagram' => 'https://instagram.com/carpoolindia'
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
