<?php
require_once __DIR__ . '/../models/RoomModel.php';

class RoomController {
    private $roomModel;

    public function __construct() {
        $this->roomModel = new RoomModel();
    }

    public function list() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $search = $_GET['search'] ?? '';
        $status_filter = $_GET['status'] ?? '';
        
        if (!empty($search) || !empty($status_filter)) {
            $rooms = $this->roomModel->getAll();
            
            // Apply filters
            if (!empty($search)) {
                $rooms = array_filter($rooms, function($room) use ($search) {
                    return stripos($room['room_number'], $search) !== false || 
                           stripos($room['room_type'], $search) !== false ||
                           stripos($room['amenities'], $search) !== false;
                });
            }
            
            if (!empty($status_filter)) {
                $rooms = array_filter($rooms, function($room) use ($status_filter) {
                    return $room['status'] === $status_filter;
                });
            }
        } else {
            $rooms = $this->roomModel->getAll();
        }

        include '../views/rooms/list.php';
    }

    public function add() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'room_number' => $_POST['room_number'],
                'room_type' => $_POST['room_type'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
                'amenities' => $_POST['amenities'],
                'max_occupancy' => $_POST['max_occupancy']
            ];

            if ($this->roomModel->add($data)) {
                $_SESSION['success'] = 'Room added successfully!';
                header('Location: index.php?controller=room&action=list');
                exit;
            } else {
                $error = 'Failed to add room. Please try again.';
            }
        }

        include '../views/rooms/add.php';
    }

    public function edit() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $room = $this->roomModel->getById($id);

        if (!$room) {
            header('Location: index.php?controller=room&action=list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'room_number' => $_POST['room_number'],
                'room_type' => $_POST['room_type'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
                'amenities' => $_POST['amenities'],
                'max_occupancy' => $_POST['max_occupancy']
            ];

            if ($this->roomModel->update($id, $data)) {
                $_SESSION['success'] = 'Room updated successfully!';
                header('Location: index.php?controller=room&action=list');
                exit;
            } else {
                $error = 'Failed to update room. Please try again.';
            }
        }

        include '../views/rooms/edit.php';
    }

    public function delete() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;

        if ($this->roomModel->delete($id)) {
            $_SESSION['success'] = 'Room deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete room.';
        }

        header('Location: index.php?controller=room&action=list');
        exit;
    }
}
?>
