<?php
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private function getMailConfig() {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreploy@carpoolindia.com';
        $mail->Password = 'rN0RiXVw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('noreploy@carpoolindia.com', 'Carpool India');
        return $mail;
    }

    // Existing methods (keep as is)
    public function sendOTP($email, $otp, $name = '') {
        try {
            error_log("=== CARPOOL INDIA OTP ===");
            error_log("Email: {$email}");
            error_log("OTP: {$otp}");
            error_log("=========================");

            $mail = $this->getMailConfig();
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "Your Carpool India OTP - {$otp}";
            $mail->Body = $this->getOTPTemplate($otp, $name);
            $mail->send();
            
            error_log("OTP Email sent successfully to {$email}");
            return true;
        } catch (Exception $e) {
            error_log("OTP email error: " . $e->getMessage());
            return false;
        }
    }

    public function sendWelcome($email, $name) {
        try {
            $mail = $this->getMailConfig();
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "🚗 Welcome to Carpool India - Start Your Journey!";
            $mail->Body = $this->getWelcomeTemplate($name);
            $mail->send();
            
            error_log("Welcome email sent to {$email}");
            return true;
        } catch (Exception $e) {
            error_log("Welcome email error: " . $e->getMessage());
            return false;
        }
    }

    // NEW: Booking request sent notification
    public function sendBookingRequest($driverEmail, $driverName, $passengerName, $rideDetails) {
        try {
            $mail = $this->getMailConfig();
            $mail->addAddress($driverEmail, $driverName);
            $mail->isHTML(true);
            $mail->Subject = "🚗 New Booking Request for Your Ride";
            $mail->Body = $this->getBookingRequestTemplate($driverName, $passengerName, $rideDetails);
            $mail->send();
            
            error_log("Booking request email sent to driver: {$driverEmail}");
            return true;
        } catch (Exception $e) {
            error_log("Booking request email error: " . $e->getMessage());
            return false;
        }
    }

    // NEW: Booking accepted notification
    public function sendBookingAccepted($passengerEmail, $passengerName, $driverName, $rideDetails) {
        try {
            $mail = $this->getMailConfig();
            $mail->addAddress($passengerEmail, $passengerName);
            $mail->isHTML(true);
            $mail->Subject = "✅ Your Booking Request Accepted!";
            $mail->Body = $this->getBookingAcceptedTemplate($passengerName, $driverName, $rideDetails);
            $mail->send();
            
            error_log("Booking accepted email sent to passenger: {$passengerEmail}");
            return true;
        } catch (Exception $e) {
            error_log("Booking accepted email error: " . $e->getMessage());
            return false;
        }
    }

    // NEW: Booking rejected notification
    public function sendBookingRejected($passengerEmail, $passengerName, $driverName, $rideDetails, $reason = '') {
        try {
            $mail = $this->getMailConfig();
            $mail->addAddress($passengerEmail, $passengerName);
            $mail->isHTML(true);
            $mail->Subject = "❌ Booking Request Update";
            $mail->Body = $this->getBookingRejectedTemplate($passengerName, $driverName, $rideDetails, $reason);
            $mail->send();
            
            error_log("Booking rejected email sent to passenger: {$passengerEmail}");
            return true;
        } catch (Exception $e) {
            error_log("Booking rejected email error: " . $e->getMessage());
            return false;
        }
    }

    // NEW: Ride started notification
    public function sendRideStarted($email, $name, $rideDetails, $isDriver = false) {
        try {
            $mail = $this->getMailConfig();
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "🚀 Your Ride Has Started!";
            $mail->Body = $this->getRideStartedTemplate($name, $rideDetails, $isDriver);
            $mail->send();
            
            error_log("Ride started email sent to: {$email}");
            return true;
        } catch (Exception $e) {
            error_log("Ride started email error: " . $e->getMessage());
            return false;
        }
    }

    // NEW: Ride completed notification
    public function sendRideCompleted($email, $name, $rideDetails, $isDriver = false) {
        try {
            $mail = $this->getMailConfig();
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "🏁 Ride Completed Successfully!";
            $mail->Body = $this->getRideCompletedTemplate($name, $rideDetails, $isDriver);
            $mail->send();
            
            error_log("Ride completed email sent to: {$email}");
            return true;
        } catch (Exception $e) {
            error_log("Ride completed email error: " . $e->getMessage());
            return false;
        }
    }

    // NEW: Booking cancelled notification
    public function sendBookingCancelled($email, $name, $rideDetails, $reason = '', $isDriver = false) {
        try {
            $mail = $this->getMailConfig();
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "❌ Booking Cancelled";
            $mail->Body = $this->getBookingCancelledTemplate($name, $rideDetails, $reason, $isDriver);
            $mail->send();
            
            error_log("Booking cancelled email sent to: {$email}");
            return true;
        } catch (Exception $e) {
            error_log("Booking cancelled email error: " . $e->getMessage());
            return false;
        }
    }

    // Email Templates
    private function getOTPTemplate($otp, $name) {
        return "
        <html>
        <body style='font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;'>
            <div style='max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 20px rgba(0,0,0,0.1);'>
                <div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;'>
                    <h1 style='color: white; margin: 0; font-size: 28px;'>🚗 Carpool India</h1>
                    <p style='color: white; margin: 10px 0 0 0; opacity: 0.9;'>Your trusted carpooling platform</p>
                </div>
                <div style='padding: 40px 30px;'>
                    <h2 style='color: #333; margin-bottom: 20px; text-align: center;'>Hello " . ($name ?: 'Friend') . "!</h2>
                    <p style='font-size: 16px; color: #666; margin-bottom: 30px; line-height: 1.5; text-align: center;'>
                        Your OTP for Carpool India verification is:
                    </p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <div style='background: #667eea; color: white; font-size: 32px; font-weight: bold; 
                                    padding: 20px; border-radius: 10px; letter-spacing: 5px; display: inline-block; min-width: 200px;'>
                            {$otp}
                        </div>
                    </div>
                    <div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; text-align: center; margin: 20px 0;'>
                        <p style='margin: 0; color: #856404; font-size: 14px;'>
                            ⏰ This OTP will expire in <strong>10 minutes</strong> for security reasons.
                        </p>
                    </div>
                </div>
                <div style='background: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #eee;'>
                    <p style='color: #666; font-size: 14px; margin: 0;'>
                        Thanks for choosing Carpool India - Ride Smarter, Connect Better! 🌟
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getWelcomeTemplate($name) {
        return "
        <html>
        <body style='font-family: Arial,sans-serif; margin:0; padding:20px; background-color:#f4f4f4;'>
            <div style='max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.1);'>
                <div style='background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); padding:30px; text-align:center;'>
                    <h1 style='color:white; margin:0; font-size:28px;'>🎉 Welcome to Carpool India!</h1>
                </div>
                <div style='padding:40px 30px;'>
                    <h2 style='color:#333; margin-bottom:20px; text-align:center;'>Hello " . ($name ?: 'Friend') . "!</h2>
                    <p style='font-size:16px; color:#666; margin-bottom:30px; line-height:1.5; text-align:center;'>
                        Welcome to India's most trusted carpooling platform! 🚗 <br><br>
                        You can now:
                    </p>
                    <ul style='color:#666; margin:20px 0;'>
                        <li>🔍 <strong>Search rides</strong> from verified drivers</li>
                        <li>🚗 <strong>Create rides</strong> and earn cash</li>
                        <li>💰 <strong>Pay in cash</strong> - no digital payments needed</li>
                        <li>📱 <strong>Connect</strong> with other carpoolers</li>
                        <li>🌱 <strong>Save money</strong> and help environment</li>
                    </ul>
                    <div style='text-align:center; margin:30px 0;'>
                        <a href='https://carpoolindia.com/dashboard' style='background:#667eea; color:white; padding:15px 30px; text-decoration:none; border-radius:5px; font-weight:bold;'>
                            Start Your Journey 🚀
                        </a>
                    </div>
                </div>
                <div style='background:#f8f9fa; padding:20px; text-align:center; border-top:1px solid #eee;'>
                    <p style='color:#666; font-size:14px; margin:0;'>
                        Happy Carpooling! 🌟 Save Money, Make Friends, Go Green! 
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getBookingRequestTemplate($driverName, $passengerName, $rideDetails) {
        return "
        <html>
        <body style='font-family: Arial,sans-serif; margin:0; padding:20px; background-color:#f4f4f4;'>
            <div style='max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.1);'>
                <div style='background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); padding:30px; text-align:center;'>
                    <h1 style='color:white; margin:0; font-size:28px;'>🔔 New Booking Request!</h1>
                </div>
                <div style='padding:40px 30px;'>
                    <h2 style='color:#333; margin-bottom:20px;'>Hello {$driverName}!</h2>
                    <p style='font-size:16px; color:#666; margin-bottom:20px; line-height:1.5;'>
                        <strong>{$passengerName}</strong> wants to book your ride:
                    </p>
                    <div style='background:#f8f9fa; padding:20px; border-radius:10px; margin:20px 0;'>
                        <h3 style='color:#333; margin-top:0;'>Ride Details:</h3>
                        <p style='margin:5px 0;'><strong>From:</strong> {$rideDetails['source']}</p>
                        <p style='margin:5px 0;'><strong>To:</strong> {$rideDetails['destination']}</p>
                        <p style='margin:5px 0;'><strong>Date:</strong> {$rideDetails['date']}</p>
                        <p style='margin:5px 0;'><strong>Time:</strong> {$rideDetails['time']}</p>
                        <p style='margin:5px 0;'><strong>Amount:</strong> ₹{$rideDetails['amount']} (Cash Payment)</p>
                    </div>
                    <div style='text-align:center; margin:30px 0;'>
                        <a href='https://carpoolindia.com/dashboard/my-rides' style='background:#28a745; color:white; padding:15px 30px; text-decoration:none; border-radius:5px; font-weight:bold; margin-right:10px;'>
                            Accept Request ✅
                        </a>
                        <a href='https://carpoolindia.com/dashboard/my-rides' style='background:#dc3545; color:white; padding:15px 30px; text-decoration:none; border-radius:5px; font-weight:bold;'>
                            Decline Request ❌
                        </a>
                    </div>
                </div>
                <div style='background:#f8f9fa; padding:20px; text-align:center; border-top:1px solid #eee;'>
                    <p style='color:#666; font-size:14px; margin:0;'>
                        Login to your dashboard to respond to this request.
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getBookingAcceptedTemplate($passengerName, $driverName, $rideDetails) {
        return "
        <html>
        <body style='font-family: Arial,sans-serif; margin:0; padding:20px; background-color:#f4f4f4;'>
            <div style='max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.1);'>
                <div style='background:linear-gradient(135deg,#28a745 0%,#20c997 100%); padding:30px; text-align:center;'>
                    <h1 style='color:white; margin:0; font-size:28px;'>🎉 Booking Confirmed!</h1>
                </div>
                <div style='padding:40px 30px;'>
                    <h2 style='color:#333; margin-bottom:20px;'>Great news, {$passengerName}!</h2>
                    <p style='font-size:16px; color:#666; margin-bottom:20px; line-height:1.5;'>
                        <strong>{$driverName}</strong> has accepted your booking request! 🚗
                    </p>
                    <div style='background:#d4edda; padding:20px; border-radius:10px; margin:20px 0; border:1px solid #c3e6cb;'>
                        <h3 style='color:#155724; margin-top:0;'>Your Confirmed Ride:</h3>
                        <p style='margin:5px 0; color:#155724;'><strong>Driver:</strong> {$driverName}</p>
                        <p style='margin:5px 0; color:#155724;'><strong>From:</strong> {$rideDetails['source']}</p>
                        <p style='margin:5px 0; color:#155724;'><strong>To:</strong> {$rideDetails['destination']}</p>
                        <p style='margin:5px 0; color:#155724;'><strong>Date:</strong> {$rideDetails['date']}</p>
                        <p style='margin:5px 0; color:#155724;'><strong>Time:</strong> {$rideDetails['time']}</p>
                        <p style='margin:5px 0; color:#155724;'><strong>Phone:</strong> {$rideDetails['driver_phone']}</p>
                        <p style='margin:5px 0; color:#155724;'><strong>Amount:</strong> ₹{$rideDetails['amount']} (Pay in Cash)</p>
                    </div>
                    <div style='background:#fff3cd; padding:15px; border-radius:5px; border:1px solid #ffeaa7; margin:20px 0;'>
                        <p style='margin:0; color:#856404; font-size:14px;'>
                            💡 <strong>Remember:</strong> Pay the driver in cash at the end of the ride. Contact the driver before the ride time.
                        </p>
                    </div>
                </div>
                <div style='background:#f8f9fa; padding:20px; text-align:center; border-top:1px solid #eee;'>
                    <p style='color:#666; font-size:14px; margin:0;'>
                        Have a safe and pleasant journey! 🌟
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getBookingRejectedTemplate($passengerName, $driverName, $rideDetails, $reason) {
        return "
        <html>
        <body style='font-family: Arial,sans-serif; margin:0; padding:20px; background-color:#f4f4f4;'>
            <div style='max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.1);'>
                <div style='background:linear-gradient(135deg,#dc3545 0%,#c82333 100%); padding:30px; text-align:center;'>
                    <h1 style='color:white; margin:0; font-size:28px;'>😔 Booking Not Confirmed</h1>
                </div>
                <div style='padding:40px 30px;'>
                    <h2 style='color:#333; margin-bottom:20px;'>Hi {$passengerName},</h2>
                    <p style='font-size:16px; color:#666; margin-bottom:20px; line-height:1.5;'>
                        Unfortunately, <strong>{$driverName}</strong> couldn't accept your booking request for this ride.
                    </p>
                    " . ($reason ? "<div style='background:#f8d7da; padding:15px; border-radius:5px; border:1px solid #f5c6cb; margin:20px 0;'>
                        <p style='margin:0; color:#721c24; font-size:14px;'>
                            <strong>Reason:</strong> {$reason}
                        </p>
                    </div>" : "") . "
                    <p style='font-size:16px; color:#666; line-height:1.5;'>
                        Don't worry! There are many other rides available. 
                    </p>
                    <div style='text-align:center; margin:30px 0;'>
                        <a href='https://carpoolindia.com/dashboard' style='background:#667eea; color:white; padding:15px 30px; text-decoration:none; border-radius:5px; font-weight:bold;'>
                            Search Other Rides 🔍
                        </a>
                    </div>
                </div>
                <div style='background:#f8f9fa; padding:20px; text-align:center; border-top:1px solid #eee;'>
                    <p style='color:#666; font-size:14px; margin:0;'>
                        Keep trying! Your perfect ride is just a search away! 🚗
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getRideStartedTemplate($name, $rideDetails, $isDriver) {
        $message = $isDriver ? "You have started your ride!" : "Your ride has started!";
        $instructions = $isDriver ? 
            "Drive safely and pick up all confirmed passengers. Don't forget to collect cash payments at the end." :
            "Your driver is on the way! Keep your cash ready for payment at the end of the ride.";

        return "
        <html>
        <body style='font-family: Arial,sans-serif; margin:0; padding:20px; background-color:#f4f4f4;'>
            <div style='max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.1);'>
                <div style='background:linear-gradient(135deg,#17a2b8 0%,#138496 100%); padding:30px; text-align:center;'>
                    <h1 style='color:white; margin:0; font-size:28px;'>🚀 Ride Started!</h1>
                </div>
                <div style='padding:40px 30px;'>
                    <h2 style='color:#333; margin-bottom:20px;'>Hello {$name}!</h2>
                    <p style='font-size:16px; color:#666; margin-bottom:20px; line-height:1.5;'>
                        {$message} 🚗
                    </p>
                    <div style='background:#d1ecf1; padding:20px; border-radius:10px; margin:20px 0; border:1px solid #bee5eb;'>
                        <h3 style='color:#0c5460; margin-top:0;'>Ride Details:</h3>
                        <p style='margin:5px 0; color:#0c5460;'><strong>From:</strong> {$rideDetails['source']}</p>
                        <p style='margin:5px 0; color:#0c5460;'><strong>To:</strong> {$rideDetails['destination']}</p>
                        <p style='margin:5px 0; color:#0c5460;'><strong>Date:</strong> {$rideDetails['date']}</p>
                        <p style='margin:5px 0; color:#0c5460;'><strong>Time:</strong> {$rideDetails['time']}</p>
                    </div>
                    <div style='background:#d4edda; padding:15px; border-radius:5px; border:1px solid #c3e6cb; margin:20px 0;'>
                        <p style='margin:0; color:#155724; font-size:14px;'>
                            💡 <strong>Note:</strong> {$instructions}
                        </p>
                    </div>
                </div>
                <div style='background:#f8f9fa; padding:20px; text-align:center; border-top:1px solid #eee;'>
                    <p style='color:#666; font-size:14px; margin:0;'>
                        Have a safe journey! 🛣️
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getRideCompletedTemplate($name, $rideDetails, $isDriver) {
        $message = $isDriver ? "Your ride has been completed successfully!" : "Your ride is complete!";
        $thanks = $isDriver ? 
            "Thank you for providing a safe ride! Your earnings will be updated shortly." :
            "Thank you for choosing Carpool India! Hope you had a pleasant journey.";

        return "
        <html>
        <body style='font-family: Arial,sans-serif; margin:0; padding:20px; background-color:#f4f4f4;'>
            <div style='max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.1);'>
                <div style='background:linear-gradient(135deg,#6f42c1 0%,#563d7c 100%); padding:30px; text-align:center;'>
                    <h1 style='color:white; margin:0; font-size:28px;'>🏁 Ride Completed!</h1>
                </div>
                <div style='padding:40px 30px;'>
                    <h2 style='color:#333; margin-bottom:20px;'>Hello {$name}!</h2>
                    <p style='font-size:16px; color:#666; margin-bottom:20px; line-height:1.5;'>
                        {$message} 🎉
                    </p>
                    <div style='background:#e2e3f1; padding:20px; border-radius:10px; margin:20px 0; border:1px solid #d1d9ff;'>
                        <h3 style='color:#4c4c4c; margin-top:0;'>Completed Ride:</h3>
                        <p style='margin:5px 0; color:#4c4c4c;'><strong>From:</strong> {$rideDetails['source']}</p>
                        <p style='margin:5px 0; color:#4c4c4c;'><strong>To:</strong> {$rideDetails['destination']}</p>
                        <p style='margin:5px 0; color:#4c4c4c;'><strong>Amount:</strong> ₹{$rideDetails['amount']}</p>
                    </div>
                    <p style='font-size:16px; color:#666; line-height:1.5;'>
                        {$thanks}
                    </p>
                    <div style='text-align:center; margin:30px 0;'>
                        <a href='https://carpoolindia.com/dashboard' style='background:#667eea; color:white; padding:15px 30px; text-decoration:none; border-radius:5px; font-weight:bold;'>
                            View Dashboard 📊
                        </a>
                    </div>
                </div>
                <div style='background:#f8f9fa; padding:20px; text-align:center; border-top:1px solid #eee;'>
                    <p style='color:#666; font-size:14px; margin:0;'>
                        Thanks for using Carpool India! 🌟
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getBookingCancelledTemplate($name, $rideDetails, $reason, $isDriver) {
        $message = $isDriver ? "A passenger has cancelled their booking." : "Your booking has been cancelled.";
        
        return "
        <html>
        <body style='font-family: Arial,sans-serif; margin:0; padding:20px; background-color:#f4f4f4;'>
            <div style='max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.1);'>
                <div style='background:linear-gradient(135deg,#ffc107 0%,#e0a800 100%); padding:30px; text-align:center;'>
                    <h1 style='color:white; margin:0; font-size:28px;'>⚠️ Booking Cancelled</h1>
                </div>
                <div style='padding:40px 30px;'>
                    <h2 style='color:#333; margin-bottom:20px;'>Hello {$name},</h2>
                    <p style='font-size:16px; color:#666; margin-bottom:20px; line-height:1.5;'>
                        {$message}
                    </p>
                    " . ($reason ? "<div style='background:#fff3cd; padding:15px; border-radius:5px; border:1px solid #ffeaa7; margin:20px 0;'>
                        <p style='margin:0; color:#856404; font-size:14px;'>
                            <strong>Reason:</strong> {$reason}
                        </p>
                    </div>" : "") . "
                    <div style='background:#f8f9fa; padding:20px; border-radius:10px; margin:20px 0;'>
                        <h3 style='color:#333; margin-top:0;'>Cancelled Ride:</h3>
                        <p style='margin:5px 0;'><strong>From:</strong> {$rideDetails['source']}</p>
                        <p style='margin:5px 0;'><strong>To:</strong> {$rideDetails['destination']}</p>
                        <p style='margin:5px 0;'><strong>Date:</strong> {$rideDetails['date']}</p>
                    </div>
                </div>
                <div style='background:#f8f9fa; padding:20px; text-align:center; border-top:1px solid #eee;'>
                    <p style='color:#666; font-size:14px; margin:0;'>
                        Sorry for the inconvenience. Please search for other available rides.
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }
}
?>
