<?php
require_once 'BaseModel.php';

class RoomModel extends BaseModel {
    protected $table = 'rooms';

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $query = "INSERT INTO " . $this->table . " (room_number, room_type, price, status, amenities, max_occupancy) 
                  VALUES (:room_number, :room_type, :price, :status, :amenities, :max_occupancy)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':room_number', $data['room_number']);
        $stmt->bindParam(':room_type', $data['room_type']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':amenities', $data['amenities']);
        $stmt->bindParam(':max_occupancy', $data['max_occupancy']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET 
                  room_number = :room_number,
                  room_type = :room_type,
                  price = :price,
                  status = :status,
                  amenities = :amenities,
                  max_occupancy = :max_occupancy
                  WHERE room_id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':room_number', $data['room_number']);
        $stmt->bindParam(':room_type', $data['room_type']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':amenities', $data['amenities']);
        $stmt->bindParam(':max_occupancy', $data['max_occupancy']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function getAvailableRooms($check_in = null, $check_out = null) {
        if ($check_in && $check_out) {
            // Use existing availability logic for specific dates
            return $this->searchAvailableRooms([
                'check_in' => $check_in,
                'check_out' => $check_out,
                'guests' => 1,
                'room_type' => '',
                'max_price' => '',
                'amenities' => []
            ]);
        } else {
            // Return all rooms marked as 'Available' when no dates specified
            $query = "SELECT * FROM " . $this->table . " WHERE status = 'Available' ORDER BY price ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    public function updateStatus($room_id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE room_id = :room_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':room_id', $room_id);
        return $stmt->execute();
    }

    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total_rooms,
                    SUM(CASE WHEN status = 'Available' THEN 1 ELSE 0 END) as available_rooms,
                    SUM(CASE WHEN status = 'Booked' THEN 1 ELSE 0 END) as booked_rooms,
                    SUM(CASE WHEN status = 'Maintenance' THEN 1 ELSE 0 END) as maintenance_rooms,
                    SUM(CASE WHEN status = 'Housekeeping' THEN 1 ELSE 0 END) as housekeeping_rooms
                  FROM " . $this->table;
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function searchAvailableRooms($filters) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE room_id NOT IN (
                      SELECT DISTINCT room_id FROM bookings 
                      WHERE status IN ('Confirmed', 'Active') 
                      AND (
                          (check_in <= :check_in AND check_out > :check_in) OR
                          (check_in < :check_out AND check_out >= :check_out) OR
                          (check_in >= :check_in AND check_out <= :check_out)
                      )
                  ) AND status = 'Available'";

        $conditions = [];
        $params = [
            ':check_in' => $filters['check_in'],
            ':check_out' => $filters['check_out']
        ];

        // Add filters
        if (!empty($filters['guests'])) {
            $conditions[] = "max_occupancy >= :guests";
            $params[':guests'] = $filters['guests'];
        }

        if (!empty($filters['room_type'])) {
            $conditions[] = "room_type = :room_type";
            $params[':room_type'] = $filters['room_type'];
        }

        if (!empty($filters['max_price'])) {
            $conditions[] = "COALESCE(discounted_price, price) <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }

        if (!empty($filters['amenities'])) {
            foreach ($filters['amenities'] as $index => $amenity) {
                $conditions[] = "amenities LIKE :amenity_$index";
                $params[":amenity_$index"] = "%$amenity%";
            }
        }

        if (!empty($conditions)) {
            $query .= " AND " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY COALESCE(discounted_price, price) ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }

    public function getFeaturedRooms() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE is_promotional = TRUE 
                  AND status = 'Available'
                  ORDER BY price ASC 
                  LIMIT 6";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $featuredRooms = $stmt->fetchAll();
        
        // If no promotional rooms found, show some available rooms as featured
        if (empty($featuredRooms)) {
            $query = "SELECT * FROM " . $this->table . " 
                      WHERE status = 'Available'
                      ORDER BY price ASC 
                      LIMIT 6";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $featuredRooms = $stmt->fetchAll();
        }
        
        return $featuredRooms;
    }

    public function getDiscountAmount($room_id, $check_in, $check_out) {
        $query = "SELECT discounted_price, price FROM " . $this->table . " 
                  WHERE room_id = :room_id 
                  AND is_promotional = TRUE 
                  AND promotion_start_date <= :check_in 
                  AND promotion_end_date >= :check_out";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':check_out', $check_out);
        $stmt->execute();
        
        $room = $stmt->fetch();
        
        if ($room && $room['discounted_price']) {
            $nights = (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24);
            return ($room['price'] - $room['discounted_price']) * $nights;
        }
        
        return 0;
    }

    public function updatePromotion($room_id, $promotion_data) {
        $query = "UPDATE " . $this->table . " SET 
                  is_promotional = :is_promotional,
                  discounted_price = :discounted_price,
                  promotion_description = :promotion_description,
                  promotion_start_date = :promotion_start_date,
                  promotion_end_date = :promotion_end_date
                  WHERE room_id = :room_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':is_promotional', $promotion_data['is_promotional']);
        $stmt->bindParam(':discounted_price', $promotion_data['discounted_price']);
        $stmt->bindParam(':promotion_description', $promotion_data['promotion_description']);
        $stmt->bindParam(':promotion_start_date', $promotion_data['promotion_start_date']);
        $stmt->bindParam(':promotion_end_date', $promotion_data['promotion_end_date']);
        $stmt->bindParam(':room_id', $room_id);
        
        return $stmt->execute();
    }

    public function updateHousekeepingStatus($room_id, $status) {
        $query = "UPDATE " . $this->table . " SET 
                  housekeeping_status = :status,
                  last_cleaned = CASE WHEN :status = 'Clean' THEN NOW() ELSE last_cleaned END
                  WHERE room_id = :room_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':room_id', $room_id);
        
        return $stmt->execute();
    }
}
?>
