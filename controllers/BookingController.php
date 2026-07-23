<?php
require_once __DIR__ . '/../models/BookingModel.php';
require_once __DIR__ . '/../models/GuestModel.php';
require_once __DIR__ . '/../models/RoomModel.php';

class BookingController {
    private $bookingModel;
    private $guestModel;
    private $roomModel;

    public function __construct() {
        $this->bookingModel = new BookingModel();
        $this->guestModel = new GuestModel();
        $this->roomModel = new RoomModel();
    }

    public function list() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $status_filter = $_GET['status'] ?? '';
        $bookings = $this->bookingModel->getAllWithDetails();
        
        if (!empty($status_filter)) {
            $bookings = array_filter($bookings, function($booking) use ($status_filter) {
                return $booking['status'] === $status_filter;
            });
        }

        include '../views/bookings/list.php';
    }

    public function add() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $guests = $this->guestModel->getAll();
        $rooms = $this->roomModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            $room_id = $_POST['room_id'];
            
            // Check room availability
            if ($this->bookingModel->checkRoomAvailability($room_id, $check_in, $check_out)) {
                $total_amount = $this->bookingModel->calculateTotalAmount($room_id, $check_in, $check_out);
                
                $data = [
                    'guest_id' => $_POST['guest_id'],
                    'room_id' => $room_id,
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'total_amount' => $total_amount,
                    'special_requests' => $_POST['special_requests'],
                    'payment_status' => $_POST['payment_status']
                ];

                if ($this->bookingModel->add($data)) {
                    $_SESSION['success'] = 'Booking created successfully!';
                    header('Location: index.php?controller=booking&action=list');
                    exit;
                } else {
                    $error = 'Failed to create booking. Please try again.';
                }
            } else {
                $error = 'Room is not available for the selected dates.';
            }
        }

        include '../views/bookings/add.php';
    }

    public function edit() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $booking = $this->bookingModel->getByIdWithDetails($id);

        if (!$booking) {
            header('Location: index.php?controller=booking&action=list');
            exit;
        }

        $guests = $this->guestModel->getAll();
        $rooms = $this->roomModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            $room_id = $_POST['room_id'];
            
            // Check room availability (excluding current booking)
            if ($this->bookingModel->checkRoomAvailability($room_id, $check_in, $check_out, $id)) {
                $total_amount = $this->bookingModel->calculateTotalAmount($room_id, $check_in, $check_out);
                
                $data = [
                    'guest_id' => $_POST['guest_id'],
                    'room_id' => $room_id,
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'total_amount' => $total_amount,
                    'special_requests' => $_POST['special_requests'],
                    'payment_status' => $_POST['payment_status']
                ];

                if ($this->bookingModel->update($id, $data)) {
                    $_SESSION['success'] = 'Booking updated successfully!';
                    header('Location: index.php?controller=booking&action=list');
                    exit;
                } else {
                    $error = 'Failed to update booking. Please try again.';
                }
            } else {
                $error = 'Room is not available for the selected dates.';
            }
        }

        include '../views/bookings/edit.php';
    }

    public function cancel() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;

        if ($this->bookingModel->updateStatus($id, 'Cancelled')) {
            $_SESSION['success'] = 'Booking cancelled successfully!';
        } else {
            $_SESSION['error'] = 'Failed to cancel booking.';
        }

        header('Location: index.php?controller=booking&action=list');
        exit;
    }

    public function checkin() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $booking = $this->bookingModel->getByIdWithDetails($id);

        if (!$booking) {
            header('Location: index.php?controller=booking&action=list');
            exit;
        }

        $check_in_date = new DateTime($booking['check_in']);
        $today = new DateTime();

        // Check if it's a valid check-in date (can check in on or after check-in date)
        if ($today >= $check_in_date && $booking['status'] === 'Confirmed') {
            if ($this->bookingModel->updateStatus($id, 'Active')) {
                // Update room status to booked
                $this->roomModel->updateStatus($booking['room_id'], 'Booked');
                $_SESSION['success'] = 'Guest checked in successfully!';
            } else {
                $_SESSION['error'] = 'Failed to check in guest.';
            }
        } else {
            if ($today < $check_in_date) {
                $_SESSION['error'] = 'Cannot check in before the check-in date.';
            } else {
                $_SESSION['error'] = 'Invalid booking status for check-in.';
            }
        }

        header('Location: index.php?controller=booking&action=list');
        exit;
    }

    public function checkout() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $booking = $this->bookingModel->getByIdWithDetails($id);

        if (!$booking) {
            header('Location: index.php?controller=booking&action=list');
            exit;
        }

        if ($booking['status'] === 'Active') {
            if ($this->bookingModel->updateStatus($id, 'Completed')) {
                // Update room status to available
                $this->roomModel->updateStatus($booking['room_id'], 'Available');
                $_SESSION['success'] = 'Guest checked out successfully!';
            } else {
                $_SESSION['error'] = 'Failed to check out guest.';
            }
        } else {
            $_SESSION['error'] = 'Guest must be checked in before checking out.';
        }

        header('Location: index.php?controller=booking&action=list');
        exit;
    }

    public function checkAvailability() {
        $check_in = $_GET['check_in'] ?? '';
        $check_out = $_GET['check_out'] ?? '';
        
        if (!empty($check_in) && !empty($check_out)) {
            $available_rooms = $this->roomModel->getAvailableRooms($check_in, $check_out);
            
            header('Content-Type: application/json');
            echo json_encode($available_rooms);
            exit;
        }
        
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }
}
?>
