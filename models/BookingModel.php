<?php
require_once 'BaseModel.php';

class BookingModel extends BaseModel {
    protected $table = 'bookings';

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (guest_id, room_id, check_in, check_out, status, total_amount, discount_amount, final_amount, 
                   special_requests, payment_status, booking_source) 
                  VALUES (:guest_id, :room_id, :check_in, :check_out, :status, :total_amount, :discount_amount, 
                          :final_amount, :special_requests, :payment_status, :booking_source)";
        
        $stmt = $this->db->prepare($query);
    
        $guest_id = $data['guest_id'];
        $room_id = $data['room_id'];
        $check_in = $data['check_in'];
        $check_out = $data['check_out'];
        $status = $data['status'] ?? 'Confirmed'; // Add this
        $total_amount = $data['total_amount'];
        $discount_amount = $data['discount_amount'] ?? 0;
        $final_amount = isset($data['final_amount']) ? $data['final_amount'] : ($total_amount - $discount_amount);
        $special_requests = $data['special_requests'];
        $payment_status = $data['payment_status'] ?? 'Pending';
        $booking_source = $data['booking_source'] ?? 'Online';
    
        $stmt->bindParam(':guest_id', $guest_id);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':check_out', $check_out);
        $stmt->bindParam(':status', $status); // Add this binding
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':discount_amount', $discount_amount);
        $stmt->bindParam(':final_amount', $final_amount);
        $stmt->bindParam(':special_requests', $special_requests);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':booking_source', $booking_source);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET 
                  guest_id = :guest_id,
                  room_id = :room_id,
                  check_in = :check_in,
                  check_out = :check_out,
                  total_amount = :total_amount,
                  special_requests = :special_requests,
                  payment_status = :payment_status
                  WHERE booking_id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guest_id', $data['guest_id']);
        $stmt->bindParam(':room_id', $data['room_id']);
        $stmt->bindParam(':check_in', $data['check_in']);
        $stmt->bindParam(':check_out', $data['check_out']);
        $stmt->bindParam(':total_amount', $data['total_amount']);
        $stmt->bindParam(':special_requests', $data['special_requests']);
        $stmt->bindParam(':payment_status', $data['payment_status']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function getAllWithDetails() {
        $query = "SELECT b.*, g.name as guest_name, g.email, g.phone, 
                         r.room_number, r.room_type, r.price
                  FROM " . $this->table . " b
                  JOIN guests g ON b.guest_id = g.guest_id
                  JOIN rooms r ON b.room_id = r.room_id
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByIdWithDetails($id) {
        $query = "SELECT b.*, g.name as guest_name, g.email, g.phone, g.address,
                         r.room_number, r.room_type, r.price, r.amenities
                  FROM " . $this->table . " b
                  JOIN guests g ON b.guest_id = g.guest_id
                  JOIN rooms r ON b.room_id = r.room_id
                  WHERE b.booking_id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE booking_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function checkRoomAvailability($room_id, $check_in, $check_out, $exclude_booking_id = null) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                  WHERE room_id = :room_id 
                  AND status IN ('Confirmed', 'Active') 
                  AND booking_id != :exclude_id
                  AND (
                      (check_in <= :check_in AND check_out > :check_in) OR
                      (check_in < :check_out AND check_out >= :check_out) OR
                      (check_in >= :check_in AND check_out <= :check_out)
                  )";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':check_out', $check_out);
        $exclude_id = $exclude_booking_id ?? 0;
        $stmt->bindParam(':exclude_id', $exclude_id);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['count'] == 0;
    }

    public function getDashboardStats() {
        $query = "SELECT 
                    COUNT(*) as total_bookings,
                    SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) as active_bookings,
                    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_bookings,
                    SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_bookings,
                    SUM(CASE WHEN payment_status = 'Paid' THEN total_amount ELSE 0 END) as total_revenue
                  FROM " . $this->table;
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getRecentBookings($limit = 10) {
        $query = "SELECT b.*, g.name as guest_name, r.room_number
                  FROM " . $this->table . " b
                  JOIN guests g ON b.guest_id = g.guest_id
                  JOIN rooms r ON b.room_id = r.room_id
                  ORDER BY b.created_at DESC
                  LIMIT :limit";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function calculateTotalAmount($room_id, $check_in, $check_out) {
        // Get room price
        $roomQuery = "SELECT price FROM rooms WHERE room_id = :room_id";
        $roomStmt = $this->db->prepare($roomQuery);
        $roomStmt->bindParam(':room_id', $room_id);
        $roomStmt->execute();
        $room = $roomStmt->fetch();
        
        if (!$room) return 0;
        
        // Calculate number of nights
        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);
        $nights = $check_out_date->diff($check_in_date)->days;
        
        return $room['price'] * $nights;
    }

    public function getByGuestId($guest_id) {
        $query = "SELECT b.*, r.room_number, r.room_type, r.price 
                  FROM " . $this->table . " b
                  JOIN rooms r ON b.room_id = r.room_id
                  WHERE b.guest_id = :guest_id
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guest_id', $guest_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getUpcomingBookings($guest_id) {
        $query = "SELECT b.*, r.room_number, r.room_type, r.price 
                  FROM " . $this->table . " b
                  JOIN rooms r ON b.room_id = r.room_id
                  WHERE b.guest_id = :guest_id
                  AND b.check_in >= CURDATE()
                  AND b.status IN ('Confirmed', 'Active')
                  ORDER BY b.check_in ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guest_id', $guest_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getBookingHistory($guest_id) {
        $query = "SELECT b.*, r.room_number, r.room_type, r.price 
                  FROM " . $this->table . " b
                  JOIN rooms r ON b.room_id = r.room_id
                  WHERE b.guest_id = :guest_id
                  AND b.check_in < CURDATE()
                  ORDER BY b.check_in DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guest_id', $guest_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function cancelBooking($booking_id, $reason, $cancellation_fee = 0) {
        $query = "UPDATE " . $this->table . " SET 
                  status = 'Cancelled',
                  cancellation_reason = :reason,
                  cancellation_fee = :fee,
                  cancelled_at = NOW()
                  WHERE booking_id = :booking_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':fee', $cancellation_fee);
        $stmt->bindParam(':booking_id', $booking_id);
        
        return $stmt->execute();
    }

    public function calculateCancellationFee($booking_id) {
        $booking = $this->getById($booking_id);
        if (!$booking) return 0;
        
        $check_in = new DateTime($booking['check_in']);
        $now = new DateTime();
        $days_before = $now->diff($check_in)->days;
        
        // Cancellation policy: 50% if cancelled within 24 hours, 25% if within 48 hours
        if ($days_before < 1) {
            return $booking['final_amount'] * 0.5;
        } elseif ($days_before < 2) {
            return $booking['final_amount'] * 0.25;
        }
        
        return 0; // No fee if cancelled more than 48 hours before
    }

    public function digitalCheckIn($booking_id, $arrival_time, $vehicle_info, $emergency_contact) {
        $query = "UPDATE " . $this->table . " SET 
                  status = 'Active',
                  check_in_time = NOW(),
                  special_requests = CONCAT(COALESCE(special_requests, ''), 
                                          ' | Arrival Time: ', :arrival_time,
                                          ' | Vehicle: ', :vehicle_info,
                                          ' | Emergency Contact: ', :emergency_contact)
                  WHERE booking_id = :booking_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':arrival_time', $arrival_time);
        $stmt->bindParam(':vehicle_info', $vehicle_info);
        $stmt->bindParam(':emergency_contact', $emergency_contact);
        $stmt->bindParam(':booking_id', $booking_id);
        
        return $stmt->execute();
    }

    public function digitalCheckOut($booking_id, $departure_time, $feedback) {
        $query = "UPDATE " . $this->table . " SET 
                  status = 'Completed',
                  check_out_time = NOW(),
                  special_requests = CONCAT(COALESCE(special_requests, ''), 
                                          ' | Departure Time: ', :departure_time,
                                          ' | Feedback: ', :feedback)
                  WHERE booking_id = :booking_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':departure_time', $departure_time);
        $stmt->bindParam(':feedback', $feedback);
        $stmt->bindParam(':booking_id', $booking_id);
        
        return $stmt->execute();
    }

    public function submitReview($data) {
        $query = "INSERT INTO guest_reviews 
                  (booking_id, guest_id, room_id, rating, review_text, service_rating, 
                   cleanliness_rating, value_rating, is_verified) 
                  VALUES (:booking_id, :guest_id, :room_id, :rating, :review_text, 
                          :service_rating, :cleanliness_rating, :value_rating, TRUE)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':booking_id', $data['booking_id']);
        $stmt->bindParam(':guest_id', $data['guest_id']);
        $stmt->bindParam(':room_id', $data['room_id']);
        $stmt->bindParam(':rating', $data['rating']);
        $stmt->bindParam(':review_text', $data['review_text']);
        $stmt->bindParam(':service_rating', $data['service_rating']);
        $stmt->bindParam(':cleanliness_rating', $data['cleanliness_rating']);
        $stmt->bindParam(':value_rating', $data['value_rating']);
        
        return $stmt->execute();
    }
}
?>
