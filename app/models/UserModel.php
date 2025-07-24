<?php
require_once 'app/helpers/Database.php';

class UserModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function createUser($data) {
        $userData = [
            'email' => $data['email'],
            'password' => Security::hashPassword($data['password']),
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'is_verified' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('users', $userData);
    }
    
    public function getUserByEmail($email) {
        return $this->db->fetchOne(
            "SELECT * FROM users WHERE email = ?", 
            [$email]
        );
    }
    
    public function getUserById($id) {
        return $this->db->fetchOne(
            "SELECT * FROM users WHERE id = ?", 
            [$id]
        );
    }
    
    public function emailExists($email) {
        $user = $this->db->fetchOne(
            "SELECT id FROM users WHERE email = ?", 
            [$email]
        );
        return !empty($user);
    }
    
    public function updateUser($userId, $data) {
        return $this->db->update('users', $data, 'id = ?', [$userId]);
    }
    
    public function storeOtp($email, $otp) {
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        // Delete any existing OTP for this email
        $this->db->delete('otps', 'email = ?', [$email]);
        
        // Insert new OTP
        return $this->db->insert('otps', [
            'email' => $email,
            'otp' => $otp,
            'expires_at' => $expiry,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function verifyOtp($email, $otp) {
        $record = $this->db->fetchOne(
            "SELECT * FROM otps WHERE email = ? AND otp = ? AND expires_at > NOW()",
            [$email, $otp]
        );
        
        if ($record) {
            // Delete the used OTP
            $this->db->delete('otps', 'email = ?', [$email]);
            return true;
        }
        
        return false;
    }
    
    public function getActiveUsersCount() {
        $result = $this->db->fetchOne(
            "SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"
        );
        return $result['count'] ?? 0;
    }
    
    public function getTotalUsersCount() {
        $result = $this->db->fetchOne("SELECT COUNT(*) as count FROM users");
        return $result['count'] ?? 0;
    }
    
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = Security::hashPassword($newPassword);
        return $this->db->update('users', 
            ['password' => $hashedPassword], 
            'id = ?', 
            [$userId]
        );
    }
    
    public function updateProfilePicture($userId, $filename) {
        return $this->db->update('users', 
            ['profile_picture' => $filename], 
            'id = ?', 
            [$userId]
        );
    }
    
    public function getRecentUsers($limit = 10) {
        return $this->db->fetchAll(
            "SELECT id, name, email, created_at FROM users ORDER BY created_at DESC LIMIT ?",
            [$limit]
        );
    }
}
?>
