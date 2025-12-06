<?php
namespace App\Models;

use Core\Database;
use PDO;

class ContactModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Save contact form submission
     * @param array $data
     * @return bool
     */
    public function saveContact(array $data): bool {
        $sql = "INSERT INTO contacts (name, email, subject, message, ip_address, user_agent, status) 
                VALUES (:name, :email, :subject, :message, :ip_address, :user_agent, 'new')";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'] ?? 'Contact Form Submission',
                'message' => $data['message'],
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);
        } catch (\PDOException $e) {
            error_log("Contact save error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all contacts
     * @param string $status
     * @return array
     */
    public function getContacts(string $status = null): array {
        $sql = "SELECT * FROM contacts";
        if ($status) {
            $sql .= " WHERE status = :status";
        }
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        if ($status) {
            $stmt->execute(['status' => $status]);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll();
    }

    /**
     * Update contact status
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $id, string $status): bool {
        $sql = "UPDATE contacts SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }
}
?>
