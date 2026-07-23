<?php
require_once 'BaseModel.php';

class AdminModel extends BaseModel {
    protected $table = 'admins';

    public function __construct() {
        parent::__construct();
    }

    public function authenticate($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password_hash'])) {
            return $admin;
        }
        
        return false;
    }

    public function add($data) {
        $query = "INSERT INTO " . $this->table . " (username, password_hash, role, full_name, email) 
                  VALUES (:username, :password_hash, :role, :full_name, :email)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password_hash', $data['password_hash']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':email', $data['email']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET 
                  username = :username,
                  role = :role,
                  full_name = :full_name,
                  email = :email";
        
        if (!empty($data['password_hash'])) {
            $query .= ", password_hash = :password_hash";
        }
        
        $query .= " WHERE admin_id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        
        if (!empty($data['password_hash'])) {
            $stmt->bindParam(':password_hash', $data['password_hash']);
        }
        
        return $stmt->execute();
    }

    public function getTotalAdmins() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
