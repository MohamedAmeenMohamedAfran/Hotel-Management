<?php
require_once __DIR__ . '/../config/db.php';

class BaseModel {
    protected $db;
    protected $table;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Get all records
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get record by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->getPrimaryKey() . " = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Delete record by ID
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE " . $this->getPrimaryKey() . " = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get primary key column name
    protected function getPrimaryKey() {
        // Handles common plural table names like 'guests' => 'guest_id', 'rooms' => 'room_id', etc.
        if (substr($this->table, -1) === 's') {
            return substr($this->table, 0, -1) . '_id';
        }
        return $this->table . '_id';
    }
}
?>
