<?php
require_once __DIR__ . '/../models/GuestModel.php';
require_once __DIR__ . '/../models/BookingModel.php';
require_once __DIR__ . '/../models/RoomModel.php';

class GuestPortalController {
    private $guestModel;
    private $bookingModel;
    private $roomModel;

    public function __construct() {
        $this->guestModel = new GuestModel();
        $this->bookingModel = new BookingModel();
        $this->roomModel = new RoomModel();
    }

    public function home() {
        // Public home page with room showcase and booking search
        $rooms = $this->roomModel->getAll();
        $featuredRooms = $this->roomModel->getFeaturedRooms();
        
        include __DIR__ . '/../views/public/home.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $password = $_POST['password'];
            $date_of_birth = $_POST['date_of_birth'];
            $nationality = trim($_POST['nationality']);

            // Validation
            $errors = [];
            if (empty($name)) $errors[] = 'Name is required';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
            if (empty($phone)) $errors[] = 'Phone number is required';
            if (empty($password) || strlen($password) < 6) $errors[] = 'Password must be at least 6 characters';
            if ($this->guestModel->emailExists($email)) $errors[] = 'Email already registered';

            if (empty($errors)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'password_hash' => $password_hash,
                    'date_of_birth' => $date_of_birth,
                    'nationality' => $nationality
                ];

                if ($this->guestModel->add($data)) {
                    $_SESSION['success'] = 'Registration successful! Welcome to Hotel Inshaf!';
                    // Fix redirect path
                    header('Location: index.php?controller=guest-portal&action=login');
                    exit;
                } else {
                    $error = 'Registration failed. Please try again.';
                }
            } else {
                $error = implode('<br>', $errors);
            }
        }

        include __DIR__ . '/../views/users/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $guest = $this->guestModel->getByEmail($email);
            
            if ($guest && password_verify($password, $guest['password_hash'])) {
                $_SESSION['guest_id'] = $guest['guest_id'];
                $_SESSION['guest_name'] = $guest['name'];
                $_SESSION['guest_email'] = $guest['email'];
                
                $_SESSION['success'] = 'Welcome back, ' . $guest['name'] . '!';
                // Fix redirect path
                header('Location: index.php?controller=guest-portal&action=dashboard');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        }

        include __DIR__ . '/../views/users/login.php';
    }

    public function logout() {
        session_destroy();
        // Fix redirect path
        header('Location: ../public/index.php?controller=guest-portal&action=home');
        exit;
    }

    public function dashboard() {
        // Check if guest is logged in
        if (!isset($_SESSION['guest_id'])) {
            header('Location: index.php?controller=guest-portal&action=login');
            exit;
        }

        $guest_id = $_SESSION['guest_id'];
        $guest = $this->guestModel->getById($guest_id);
        $bookings = $this->bookingModel->getByGuestId($guest_id);
        $upcomingBookings = $this->bookingModel->getUpcomingBookings($guest_id);
        $bookingHistory = $this->bookingModel->getBookingHistory($guest_id);

        include __DIR__ . '/../views/users/dashboard.php';
    }

    public function searchRooms() {
        $check_in = $_GET['check_in'] ?? '';
        $check_out = $_GET['check_out'] ?? '';
        $guests = $_GET['guests'] ?? 1;
        $room_type = $_GET['room_type'] ?? '';
        $max_price = $_GET['max_price'] ?? '';
        $amenities = $_GET['amenities'] ?? [];

        $availableRooms = [];
        
        // If dates are provided, search for available rooms with filters
        if (!empty($check_in) && !empty($check_out)) {
            $availableRooms = $this->roomModel->searchAvailableRooms([
                'check_in' => $check_in,
                'check_out' => $check_out,
                'guests' => $guests,
                'room_type' => $room_type,
                'max_price' => $max_price,
                'amenities' => $amenities
            ]);
        } else {
            // If no dates provided, get all available rooms and apply filters
            $allRooms = $this->roomModel->getAvailableRooms();
            
            // Apply filters to all available rooms
            if (!empty($room_type) || !empty($max_price) || !empty($amenities) || !empty($guests)) {
                $availableRooms = array_filter($allRooms, function($room) use ($room_type, $max_price, $amenities, $guests) {
                    if (!empty($room_type) && $room['room_type'] !== $room_type) {
                        return false;
                    }
                    if (!empty($max_price)) {
                        $price = $room['discounted_price'] ?? $room['price'];
                        if ($price > $max_price) {
                            return false;
                        }
                    }
                    if (!empty($amenities)) {
                        foreach ($amenities as $amenity) {
                            if (strpos(strtolower($room['amenities']), strtolower($amenity)) === false) {
                                return false;
                            }
                        }
                    }
                    if (!empty($guests) && $room['max_occupancy'] < $guests) {
                        return false;
                    }
                    return true;
                });
            } else {
                $availableRooms = $allRooms;
            }
        }

        // Check if user is logged in for booking functionality
        $isLoggedIn = isset($_SESSION['guest_id']);
        
        include __DIR__ . '/../views/public/search_results.php';
    }

    public function bookRoom() {
        // Check if guest is logged in
        if (!isset($_SESSION['guest_id'])) {
            $_SESSION['redirect_after_login'] = 'book-room';
            header('Location: index.php?controller=guest-portal&action=login');
            exit;
        }
    
        $room_id = $_GET['room_id'] ?? null;
    
        // Only require room_id, not dates
        if (!$room_id) {
            $_SESSION['error'] = 'Room ID is required.';
            header('Location: ../public/index.php?controller=guest-portal&action=searchRooms');
            exit;
        }
    
        $room = $this->roomModel->getById($room_id);
        $guest_id = $_SESSION['guest_id'];
    
        // Set default dates if not provided
        $check_in = $_GET['check_in'] ?? date('Y-m-d');
        $check_out = $_GET['check_out'] ?? date('Y-m-d', strtotime('+1 day'));
    
        // Remove availability check or make it optional
        // if (!$this->bookingModel->checkRoomAvailability($room_id, $check_in, $check_out)) {
        //     $_SESSION['error'] = 'Room is no longer available for the selected dates.';
        //     header('Location: ../public/index.php?controller=guest-portal&action=searchRooms');
        //     exit;
        // }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $special_requests = $_POST['special_requests'] ?? '';
            $check_in = $_POST['check_in'] ?? $check_in;
            $check_out = $_POST['check_out'] ?? $check_out;
            
            $total_amount = $this->bookingModel->calculateTotalAmount($room_id, $check_in, $check_out);
            $discount_amount = $this->roomModel->getDiscountAmount($room_id, $check_in, $check_out);
            $final_amount = $total_amount - $discount_amount;
    
            $data = [
                'guest_id' => $guest_id,
                'room_id' => $room_id,
                'check_in' => $check_in,
                'check_out' => $check_out,
                'status' => 'Confirmed', // ADD THIS LINE
                'total_amount' => $total_amount,
                'discount_amount' => $discount_amount,
                'final_amount' => $final_amount,
                'special_requests' => $special_requests,
                'payment_status' => 'Pending',
                'booking_source' => 'Online'
            ];
    
            if ($this->bookingModel->add($data)) {
                $_SESSION['success'] = 'Booking confirmed! You will receive a confirmation email shortly.';
                header('Location: index.php?controller=guest-portal&action=dashboard');
                exit;
            } else {
                $error = 'Booking failed. Please try again.';
            }
        }
    
        // Pass variables to the view
        $view_data = [
            'room' => $room,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'guest_id' => $guest_id,
            'error' => $error ?? null
        ];
        
        extract($view_data);
        
        include __DIR__ . '/../views/users/booking.php';
    }

    public function viewBooking() {
        // Check if guest is logged in
        if (!isset($_SESSION['guest_id'])) {
            header('Location: index.php?controller=guest-portal&action=login');
            exit;
        }

        $booking_id = $_GET['id'] ?? null;
        if (!$booking_id) {
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        $booking = $this->bookingModel->getById($booking_id);
        
        // Check if booking belongs to logged-in guest
        if (!$booking || $booking['guest_id'] != $_SESSION['guest_id']) {
            $_SESSION['error'] = 'Booking not found.';
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        $room = $this->roomModel->getById($booking['room_id']);
        $guest = $this->guestModel->getById($booking['guest_id']);

        include __DIR__ . '/../views/public/view_booking.php';
    }

    public function cancelBooking() {
        // Check if guest is logged in
        if (!isset($_SESSION['guest_id'])) {
            header('Location: index.php?controller=guest-portal&action=login');
            exit;
        }

        $booking_id = $_GET['id'] ?? null;
        if (!$booking_id) {
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        $booking = $this->bookingModel->getById($booking_id);
        
        // Check if booking belongs to logged-in guest
        if (!$booking || $booking['guest_id'] != $_SESSION['guest_id']) {
            $_SESSION['error'] = 'Booking not found.';
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        // Check if booking can be cancelled
        if (!in_array($booking['status'], ['Pending', 'Confirmed'])) {
            $_SESSION['error'] = 'This booking cannot be cancelled.';
            header('Location: index.php?controller=guest-portal&action=viewBooking&id=' . $booking_id);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cancellation_reason = $_POST['cancellation_reason'] ?? '';
            $cancellation_fee = $this->bookingModel->calculateCancellationFee($booking_id);
            
            if ($this->bookingModel->cancelBooking($booking_id, $cancellation_reason, $cancellation_fee)) {
                $_SESSION['success'] = 'Booking cancelled successfully.';
                header('Location: index.php?controller=guest-portal&action=dashboard');
                exit;
            } else {
                $error = 'Failed to cancel booking. Please try again.';
            }
        }

        include __DIR__ . '/../views/public/cancel_booking.php';
    }

    public function digitalCheckIn() {
        // Check if guest is logged in
        if (!isset($_SESSION['guest_id'])) {
            header('Location: index.php?controller=guest-portal&action=login');
            exit;
        }

        $booking_id = $_GET['id'] ?? null;
        if (!$booking_id) {
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        $booking = $this->bookingModel->getById($booking_id);
        
        // Check if booking belongs to logged-in guest
        if (!$booking || $booking['guest_id'] != $_SESSION['guest_id']) {
            $_SESSION['error'] = 'Booking not found.';
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        // Check if check-in is allowed
        if ($booking['status'] !== 'Confirmed' || $booking['check_in'] > date('Y-m-d')) {
            $_SESSION['error'] = 'Check-in is not available for this booking.';
            header('Location: index.php?controller=guest-portal&action=viewBooking&id=' . $booking_id);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $arrival_time = $_POST['arrival_time'] ?? '';
            $vehicle_info = $_POST['vehicle_info'] ?? '';
            $emergency_contact = $_POST['emergency_contact'] ?? '';
            
            if ($this->bookingModel->digitalCheckIn($booking_id, $arrival_time, $vehicle_info, $emergency_contact)) {
                $_SESSION['success'] = 'Check-in completed successfully! Welcome to Hotel Inshaf.';
                header('Location: index.php?controller=guest-portal&action=dashboard');
                exit;
            } else {
                $error = 'Check-in failed. Please contact reception.';
            }
        }

        include __DIR__ . '/../views/public/digital_checkin.php';
    }

    public function digitalCheckOut() {
        // Check if guest is logged in
        if (!isset($_SESSION['guest_id'])) {
            header('Location: index.php?controller=guest-portal&action=login');
            exit;
        }

        $booking_id = $_GET['id'] ?? null;
        if (!$booking_id) {
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        $booking = $this->bookingModel->getById($booking_id);
        
        // Check if booking belongs to logged-in guest
        if (!$booking || $booking['guest_id'] != $_SESSION['guest_id']) {
            $_SESSION['error'] = 'Booking not found.';
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        // Check if check-out is allowed
        if ($booking['status'] !== 'Active') {
            $_SESSION['error'] = 'Check-out is not available for this booking.';
            header('Location: index.php?controller=guest-portal&action=viewBooking&id=' . $booking_id);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $departure_time = $_POST['departure_time'] ?? '';
            $feedback = $_POST['feedback'] ?? '';
            
            if ($this->bookingModel->digitalCheckOut($booking_id, $departure_time, $feedback)) {
                $_SESSION['success'] = 'Check-out completed successfully! Thank you for staying with us.';
                header('Location: index.php?controller=guest-portal&action=dashboard');
                exit;
            } else {
                $error = 'Check-out failed. Please contact reception.';
            }
        }

        include __DIR__ . '/../views/public/digital_checkout.php';
    }

    public function submitReview() {
        // Check if guest is logged in
        if (!isset($_SESSION['guest_id'])) {
            header('Location: index.php?controller=guest-portal&action=login');
            exit;
        }

        $booking_id = $_GET['booking_id'] ?? null;
        if (!$booking_id) {
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        $booking = $this->bookingModel->getById($booking_id);
        
        // Check if booking belongs to logged-in guest
        if (!$booking || $booking['guest_id'] != $_SESSION['guest_id']) {
            $_SESSION['error'] = 'Booking not found.';
            header('Location: index.php?controller=guest-portal&action=dashboard');
            exit;
        }

        // Check if booking is completed
        if ($booking['status'] !== 'Completed') {
            $_SESSION['error'] = 'Reviews can only be submitted for completed stays.';
            header('Location: index.php?controller=guest-portal&action=viewBooking&id=' . $booking_id);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = $_POST['rating'];
            $review_text = $_POST['review_text'];
            $service_rating = $_POST['service_rating'];
            $cleanliness_rating = $_POST['cleanliness_rating'];
            $value_rating = $_POST['value_rating'];
            
            $data = [
                'booking_id' => $booking_id,
                'guest_id' => $booking['guest_id'],
                'room_id' => $booking['room_id'],
                'rating' => $rating,
                'review_text' => $review_text,
                'service_rating' => $service_rating,
                'cleanliness_rating' => $cleanliness_rating,
                'value_rating' => $value_rating
            ];

            if ($this->bookingModel->submitReview($data)) {
                $_SESSION['success'] = 'Thank you for your review!';
                header('Location: index.php?controller=guest-portal&action=dashboard');
                exit;
            } else {
                $error = 'Failed to submit review. Please try again.';
            }
        }

        include __DIR__ . '/../views/public/submit_review.php';
    }
}
?>
