<?php
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../models/GuestModel.php';
require_once __DIR__ . '/../models/BookingModel.php';

class AdminController {
    private $adminModel;
    private $roomModel;
    private $guestModel;
    private $bookingModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
        $this->roomModel = new RoomModel();
        $this->guestModel = new GuestModel();
        $this->bookingModel = new BookingModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $admin = $this->adminModel->authenticate($username, $password);
            
            if ($admin) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_role'] = $admin['role'];
                $_SESSION['admin_name'] = $admin['full_name'];
                
                header('Location: index.php?controller=admin&action=dashboard');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        }
        
        include '../views/admin/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?controller=admin&action=login');
        exit;
    }

    public function dashboard() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        // Get dashboard statistics
        $roomStats = $this->roomModel->getStats();
        $bookingStats = $this->bookingModel->getDashboardStats();
        $totalGuests = $this->guestModel->getTotalGuests();
        $totalAdmins = $this->adminModel->getTotalAdmins();
        
        // Get recent bookings
        $recentBookings = $this->bookingModel->getRecentBookings(5);

        include '../views/admin/dashboard.php';
    }
}
?>
