<?php
require_once __DIR__ . '/../models/GuestModel.php';

class GuestController {
    private $guestModel;

    public function __construct() {
        $this->guestModel = new GuestModel();
    }

    public function list() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $search = $_GET['search'] ?? '';
        
        if (!empty($search)) {
            $guests = $this->guestModel->search($search);
        } else {
            $guests = $this->guestModel->getAll();
        }

        include '../views/guests/list.php';
    }

    public function add() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];

            if ($this->guestModel->add($data)) {
                $_SESSION['success'] = 'Guest added successfully!';
                header('Location: index.php?controller=guest&action=list');
                exit;
            } else {
                $error = 'Failed to add guest. Please try again.';
            }
        }

        include '../views/guests/add.php';
    }

    public function edit() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $guest = $this->guestModel->getById($id);

        if (!$guest) {
            header('Location: index.php?controller=guest&action=list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];

            if ($this->guestModel->update($id, $data)) {
                $_SESSION['success'] = 'Guest updated successfully!';
                header('Location: index.php?controller=guest&action=list');
                exit;
            } else {
                $error = 'Failed to update guest. Please try again.';
            }
        }

        include '../views/guests/edit.php';
    }

    public function delete() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'] ?? 0;

        if ($this->guestModel->delete($id)) {
            $_SESSION['success'] = 'Guest deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete guest.';
        }

        header('Location: index.php?controller=guest&action=list');
        exit;
    }
}
?>
