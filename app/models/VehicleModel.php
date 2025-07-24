<?php
require_once 'app/helpers/Database.php';

class VehicleModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function addVehicle($data) {
        $vehicleData = [
            'user_id' => $data['user_id'],
            'model' => $data['model'],
            'number_plate' => strtoupper($data['number_plate']),
            'color' => $data['color'] ?? null,
            'seats' => $data['seats'] ?? 4,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('vehicles', $vehicleData);
    }
    
    public function updateVehicle($userId, $data) {
        $vehicleData = [
            'model' => $data['model'],
            'number_plate' => strtoupper($data['number_plate']),
            'color' => $data['color'] ?? null,
            'seats' => $data['seats'] ?? 4
        ];
        
        // Check if vehicle exists
        $existing = $this->getUserVehicle($userId);
        
        if ($existing) {
            return $this->db->update('vehicles', $vehicleData, 'user_id = ?', [$userId]);
        } else {
            $vehicleData['user_id'] = $userId;
            $vehicleData['created_at'] = date('Y-m-d H:i:s');
            return $this->db->insert('vehicles', $vehicleData);
        }
    }
    
    public function getUserVehicle($userId) {
        return $this->db->fetchOne(
            "SELECT * FROM vehicles WHERE user_id = ?",
            [$userId]
        );
    }
    
    public function deleteVehicle($userId) {
        return $this->db->delete('vehicles', 'user_id = ?', [$userId]);
    }
    
    public function isNumberPlateExists($numberPlate, $excludeUserId = null) {
        $sql = "SELECT id FROM vehicles WHERE number_plate = ?";
        $params = [strtoupper($numberPlate)];
        
        if ($excludeUserId) {
            $sql .= " AND user_id != ?";
            $params[] = $excludeUserId;
        }
        
        $result = $this->db->fetchOne($sql, $params);
        return !empty($result);
    }
    
    public function getVehiclesByUser($userId) {
        return $this->db->fetchAll(
            "SELECT * FROM vehicles WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
    }
    
    public function getTotalVehicles() {
        $result = $this->db->fetchOne("SELECT COUNT(*) as count FROM vehicles");
        return $result['count'] ?? 0;
    }
    
    public function getPopularVehicleModels($limit = 10) {
        return $this->db->fetchAll(
            "SELECT model, COUNT(*) as count FROM vehicles GROUP BY model ORDER BY count DESC LIMIT ?",
            [$limit]
        );
    }
}
?>
