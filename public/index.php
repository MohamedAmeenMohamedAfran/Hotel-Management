<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Simple routing - Fix default controller logic
$action = $_GET['action'] ?? 'home';
$controller = $_GET['controller'] ?? 'guest-portal';

// Include controllers
switch($controller) {
    case 'admin':
        include_once __DIR__ . '/../controllers/AdminController.php';
        $adminController = new AdminController();
        
        switch($action) {
            case 'login':
                $adminController->login();
                break;
            case 'logout':
                $adminController->logout();
                break;
            case 'dashboard':
                $adminController->dashboard();
                break;
            default:
                $adminController->dashboard();
        }
        break;
        
    case 'room':
        include_once __DIR__ . '/../controllers/RoomController.php';
        $roomController = new RoomController();
        
        switch($action) {
            case 'list':
                $roomController->list();
                break;
            case 'add':
                $roomController->add();
                break;
            case 'edit':
                $roomController->edit();
                break;
            case 'delete':
                $roomController->delete();
                break;
            default:
                $roomController->list();
        }
        break;
        
    case 'guest':
        include_once __DIR__ . '/../controllers/GuestController.php';
        $guestController = new GuestController();
        
        switch($action) {
            case 'list':
                $guestController->list();
                break;
            case 'add':
                $guestController->add();
                break;
            case 'edit':
                $guestController->edit();
                break;
            case 'delete':
                $guestController->delete();
                break;
            default:
                $guestController->list();
        }
        break;
        
    case 'booking':
        include_once __DIR__ . '/../controllers/BookingController.php';
        $bookingController = new BookingController();
        
        switch($action) {
            case 'list':
                $bookingController->list();
                break;
            case 'add':
                $bookingController->add();
                break;
            case 'edit':
                $bookingController->edit();
                break;
            case 'cancel':
                $bookingController->cancel();
                break;
            case 'checkin':
                $bookingController->checkin();
                break;
            case 'checkout':
                $bookingController->checkout();
                break;
            case 'availability':
                $bookingController->checkAvailability();
                break;
            default:
                $bookingController->list();
        }
        break;
        
    case 'guest-portal':
        include_once __DIR__ . '/../controllers/GuestPortalController.php';
        $guestPortalController = new GuestPortalController();
        
        switch($action) {
            case 'home':
                $guestPortalController->home();
                break;
            case 'register':
                $guestPortalController->register();
                break;
            case 'login':
                $guestPortalController->login();
                break;
            case 'logout':
                $guestPortalController->logout();
                break;
            case 'dashboard':
                $guestPortalController->dashboard();
                break;
            case 'searchRooms':
                $guestPortalController->searchRooms();
                break;
            case 'bookRoom':
                $guestPortalController->bookRoom();
                break;
            case 'viewBooking':
                $guestPortalController->viewBooking();
                break;
            case 'cancelBooking':
                $guestPortalController->cancelBooking();
                break;
            case 'digitalCheckIn':
                $guestPortalController->digitalCheckIn();
                break;
            case 'digitalCheckOut':
                $guestPortalController->digitalCheckOut();
                break;
            case 'submitReview':
                $guestPortalController->submitReview();
                break;
            default:
                $guestPortalController->home();
        }
        break;
        
    default:
        // Default to admin dashboard for admin users, guest portal for guests
        if (isset($_SESSION['admin_id'])) {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?controller=admin&action=dashboard');
        } else {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?controller=guest-portal&action=home');
        }
        exit;
}
?>
