<?php
require_once 'app/helpers/Database.php';

class ContactModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function saveContact($data) {
        $contactData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => 'new',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('contacts', $contactData);
    }
    
    public function getContacts($status = 'all', $limit = 50) {
        if ($status === 'all') {
            $sql = "SELECT * FROM contacts ORDER BY created_at DESC LIMIT ?";
            return $this->db->fetchAll($sql, [$limit]);
        } else {
            $sql = "SELECT * FROM contacts WHERE status = ? ORDER BY created_at DESC LIMIT ?";
            return $this->db->fetchAll($sql, [$status, $limit]);
        }
    }
    
    public function getContactById($id) {
        return $this->db->fetchOne(
            "SELECT * FROM contacts WHERE id = ?",
            [$id]
        );
    }
    
    public function updateContactStatus($id, $status) {
        return $this->db->update('contacts',
            ['status' => $status],
            'id = ?',
            [$id]
        );
    }
    
    public function getTotalContacts() {
        $result = $this->db->fetchOne("SELECT COUNT(*) as count FROM contacts");
        return $result['count'] ?? 0;
    }
    
    public function getNewContactsCount() {
        $result = $this->db->fetchOne(
            "SELECT COUNT(*) as count FROM contacts WHERE status = 'new'"
        );
        return $result['count'] ?? 0;
    }
    
    public function deleteContact($id) {
        return $this->db->delete('contacts', 'id = ?', [$id]);
    }
    
    public function getRecentContacts($limit = 5) {
        return $this->db->fetchAll(
            "SELECT * FROM contacts ORDER BY created_at DESC LIMIT ?",
            [$limit]
        );
    }
}
?>
