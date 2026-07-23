<?php
require_once 'BaseModel.php';

class GuestModel extends BaseModel {
    protected $table = 'guests';

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        // Check if this is a guest registration (with password) or admin adding guest
        if (isset($data['password_hash'])) {
            $query = "INSERT INTO " . $this->table . " (name, email, phone, address, password_hash, date_of_birth, nationality) 
                      VALUES (:name, :email, :phone, :address, :password_hash, :date_of_birth, :nationality)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':address', $data['address']);
            $stmt->bindParam(':password_hash', $data['password_hash']);
            // REMOVE: verification_token and is_verified binding
            $stmt->bindParam(':date_of_birth', $data['date_of_birth']);
            $stmt->bindParam(':nationality', $data['nationality']);
        } else {
            $query = "INSERT INTO " . $this->table . " (name, email, phone, address) 
                      VALUES (:name, :email, :phone, :address)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':address', $data['address']);
        }
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET 
                  name = :name,
                  email = :email,
                  phone = :phone,
                  address = :address
                  WHERE guest_id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function getTotalGuests() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function search($search_term) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE name LIKE :search 
                  OR email LIKE :search 
                  OR phone LIKE :search 
                  ORDER BY name";
        
        $search_param = "%{$search_term}%";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $search_param);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function emailExists($email) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result['count'] > 0;
    }

    public function verifyEmail($token) {
        $query = "UPDATE " . $this->table . " SET is_verified = TRUE, verification_token = NULL 
                  WHERE verification_token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        
        return $stmt->execute();
    }

    public function updatePassword($guest_id, $password_hash) {
        $query = "UPDATE " . $this->table . " SET password_hash = :password_hash 
                  WHERE guest_id = :guest_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':guest_id', $guest_id);
        
        return $stmt->execute();
    }

    public function addLoyaltyPoints($guest_id, $points) {
        $query = "UPDATE " . $this->table . " SET loyalty_points = loyalty_points + :points 
                  WHERE guest_id = :guest_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':points', $points);
        $stmt->bindParam(':guest_id', $guest_id);
        
        return $stmt->execute();
    }

    public function updateProfile($guest_id, $data) {
        $query = "UPDATE " . $this->table . " SET 
                  name = :name,
                  phone = :phone,
                  address = :address,
                  date_of_birth = :date_of_birth,
                  nationality = :nationality,
                  preferences = :preferences
                  WHERE guest_id = :guest_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':date_of_birth', $data['date_of_birth']);
        $stmt->bindParam(':nationality', $data['nationality']);
        $stmt->bindParam(':preferences', $data['preferences']);
        $stmt->bindParam(':guest_id', $guest_id);
        
        return $stmt->execute();
    }
}
?>
