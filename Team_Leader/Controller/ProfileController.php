<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "team_leader") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/User.php";

$full_name        = trim($_POST['full_name'] ?? '');
$current_password = trim($_POST['password'] ?? '');
$new_password      = trim($_POST['new_password'] ?? '');
$confirm_password  = trim($_POST['confirm_password'] ?? '');

$full_name = htmlspecialchars(stripslashes($full_name));

$id = $_SESSION['id'];

if (!$full_name) {
    header("Location: ../View/edit-profile.php?error=" . urlencode("Full Name is required"));
    exit();
} else if (!preg_match("/^[a-zA-Z ]+$/", $full_name)) {
    header("Location: ../View/edit-profile.php?error=" . urlencode("Full Name cannot contain numbers or special characters"));
    exit();
}

$database = new Database();
$conn = $database->connect();
$user = new User();

$u = $user->getUserById($conn, $id);

$wantsPasswordChange = ($new_password !== '' || $confirm_password !== '');

if ($wantsPasswordChange) {

    if (!$current_password) {
        header("Location: ../View/edit-profile.php?error=" . urlencode("Enter your current password to set a new one"));
        exit();
    }

    // NOTE: passwords are stored in plain text in this project (see Common/Model/User.php)
    if (!$u || $u['password'] !== htmlspecialchars(stripslashes($current_password))) {
        header("Location: ../View/edit-profile.php?error=" . urlencode("Current password is incorrect"));
        exit();
    }

    if (strlen($new_password) < 4) {
        header("Location: ../View/edit-profile.php?error=" . urlencode("New password must be at least 4 characters"));
        exit();
    }

    if ($new_password != $confirm_password) {
        header("Location: ../View/edit-profile.php?error=" . urlencode("New password and confirmation do not match"));
        exit();
    }

    $user->updatePassword($conn, $id, htmlspecialchars(stripslashes($new_password)));
}

$user->updateFullName($conn, $id, $full_name);

$_SESSION['full_name'] = $full_name;

header("Location: ../View/profile.php?success=" . urlencode("Profile updated successfully"));
exit();
?>
