<?php
require_once 'app/helpers/Database.php';

class ConnectionModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Send connection/ride request
    public function sendRequest($senderId, $receiverId, $rideId = null, $type = 'connection', $message = '') {
        try {
            error_log("ConnectionModel sendRequest called: senderId=$senderId, receiverId=$receiverId, rideId=$rideId, type=$type");
            
            // Check if request already exists
            $existingRequest = $this->db->fetchOne(
                "SELECT id FROM connection_requests 
                 WHERE sender_id = ? AND receiver_id = ? AND ride_id = ? AND status = 'pending'",
                [$senderId, $receiverId, $rideId]
            );
            
            if ($existingRequest) {
                throw new Exception('Request already sent');
            }
            
            $requestId = $this->db->insert('connection_requests', [
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'ride_id' => $rideId,
                'request_type' => $type,
                'message' => $message,
                'status' => 'pending'
            ]);
            
            error_log("Connection request created with ID: $requestId");
            return $requestId;
            
        } catch (Exception $e) {
            error_log("ConnectionModel sendRequest error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Get incoming requests for user
   // Update these methods in ConnectionModel.php to handle 'all' status
public function getIncomingRequests($userId, $status = 'pending') {
    try {
        $sql = "
            SELECT cr.*, 
                   u.name as sender_name, u.email as sender_email, u.phone as sender_phone,
                   r.source, r.destination, r.ride_date, r.ride_time, r.price_per_seat
            FROM connection_requests cr
            JOIN users u ON cr.sender_id = u.id
            LEFT JOIN rides r ON cr.ride_id = r.id
            WHERE cr.receiver_id = ?
        ";
        
        $params = [$userId];
        
        if ($status !== 'all') {
            $sql .= " AND cr.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY cr.created_at DESC";
        
        return $this->db->fetchAll($sql, $params);
        
    } catch (Exception $e) {
        error_log("ConnectionModel getIncomingRequests error: " . $e->getMessage());
        return [];
    }
}

public function getOutgoingRequests($userId, $status = 'pending') {
    try {
        $sql = "
            SELECT cr.*, 
                   u.name as receiver_name, u.email as receiver_email, u.phone as receiver_phone,
                   r.source, r.destination, r.ride_date, r.ride_time, r.price_per_seat
            FROM connection_requests cr
            JOIN users u ON cr.receiver_id = u.id
            LEFT JOIN rides r ON cr.ride_id = r.id
            WHERE cr.sender_id = ?
        ";
        
        $params = [$userId];
        
        if ($status !== 'all') {
            $sql .= " AND cr.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY cr.created_at DESC";
        
        return $this->db->fetchAll($sql, $params);
        
    } catch (Exception $e) {
        error_log("ConnectionModel getOutgoingRequests error: " . $e->getMessage());
        return [];
    }
}

    
    // Accept/Decline request
    public function updateRequestStatus($requestId, $userId, $status) {
        try {
            $request = $this->db->fetchOne(
                "SELECT * FROM connection_requests WHERE id = ? AND receiver_id = ?",
                [$requestId, $userId]
            );
            
            if (!$request) {
                throw new Exception('Request not found');
            }
            
            // Update request status
            $this->db->update('connection_requests',
                ['status' => $status],
                'id = ?',
                [$requestId]
            );
            
            // If accepted and it's a connection request, create connection
            if ($status === 'accepted' && $request['request_type'] === 'connection') {
                $this->createConnection($request['sender_id'], $request['receiver_id']);
            }
            
            return true;
            
        } catch (Exception $e) {
            error_log("ConnectionModel updateRequestStatus error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Create connection between users
    private function createConnection($user1Id, $user2Id) {
        try {
            // Ensure smaller ID comes first for consistency
            if ($user1Id > $user2Id) {
                $temp = $user1Id;
                $user1Id = $user2Id;
                $user2Id = $temp;
            }
            
            // Check if connection already exists
            $existing = $this->db->fetchOne(
                "SELECT id FROM user_connections WHERE user1_id = ? AND user2_id = ?",
                [$user1Id, $user2Id]
            );
            
            if (!$existing) {
                return $this->db->insert('user_connections', [
                    'user1_id' => $user1Id,
                    'user2_id' => $user2Id
                ]);
            }
            
            return true;
            
        } catch (Exception $e) {
            error_log("ConnectionModel createConnection error: " . $e->getMessage());
            return false;
        }
    }
    
    // Get user's connections
    public function getUserConnections($userId) {
        try {
            $sql = "
                SELECT u.id, u.name, u.email, u.phone, uc.connected_at,
                       0 as total_rides_shared
                FROM user_connections uc
                JOIN users u ON (uc.user1_id = u.id OR uc.user2_id = u.id)
                WHERE (uc.user1_id = ? OR uc.user2_id = ?) AND u.id != ?
                ORDER BY uc.connected_at DESC
            ";
            
            return $this->db->fetchAll($sql, [$userId, $userId, $userId]);
            
        } catch (Exception $e) {
            error_log("ConnectionModel getUserConnections error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get connection stats
    public function getConnectionStats($userId) {
        try {
            $stats = [];
            
            // Total connections
            $result = $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM user_connections 
                 WHERE user1_id = ? OR user2_id = ?",
                [$userId, $userId]
            );
            $stats['total_connections'] = $result['count'] ?? 0;
            
            // Pending incoming requests
            $result = $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM connection_requests 
                 WHERE receiver_id = ? AND status = 'pending'",
                [$userId]
            );
            $stats['pending_incoming'] = $result['count'] ?? 0;
            
            // Pending outgoing requests
            $result = $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM connection_requests 
                 WHERE sender_id = ? AND status = 'pending'",
                [$userId]
            );
            $stats['pending_outgoing'] = $result['count'] ?? 0;
            
            return $stats;
            
        } catch (Exception $e) {
            error_log("ConnectionModel getConnectionStats error: " . $e->getMessage());
            return [
                'total_connections' => 0,
                'pending_incoming' => 0,
                'pending_outgoing' => 0
            ];
        }
    }
    
    // Check if users are connected
    public function areUsersConnected($user1Id, $user2Id) {
        try {
            if ($user1Id > $user2Id) {
                $temp = $user1Id;
                $user1Id = $user2Id;
                $user2Id = $temp;
            }
            
            $result = $this->db->fetchOne(
                "SELECT id FROM user_connections WHERE user1_id = ? AND user2_id = ?",
                [$user1Id, $user2Id]
            );
            
            return !empty($result);
            
        } catch (Exception $e) {
            error_log("ConnectionModel areUsersConnected error: " . $e->getMessage());
            return false;
        }
    }
}
?>
