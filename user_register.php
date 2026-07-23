<?php
session_start();
require_once 'models/GuestModel.php';

$guestModel = new GuestModel();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $date_of_birth = $_POST['date_of_birth'];
    $nationality = trim($_POST['nationality']);

    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($phone)) $errors[] = 'Phone number is required';
    if (empty($password) || strlen($password) < 6) $errors[] = 'Password must be at least 6 characters';
    if ($guestModel->emailExists($email)) $errors[] = 'Email already registered';

    if (empty($errors)) {
        $verification_token = bin2hex(random_bytes(32));
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'password_hash' => $password_hash,
            'verification_token' => $verification_token,
            'date_of_birth' => $date_of_birth,
            'nationality' => $nationality
        ];

        if ($guestModel->add($data)) {
            $_SESSION['success'] = 'Registration successful! Please check your email to verify your account.';
            header('Location: user_login.php');
            exit;
        } else {
            $error = 'Registration failed. Please try again.';
        }
    } else {
        $error = implode('<br>', $errors);
    }
}
include 'views/public/register.php';
?>
