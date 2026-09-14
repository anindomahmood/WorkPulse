<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "employee") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/UserModel.php";

$full_name        = trim($_POST['full_name'] ?? '');
$current_password = trim($_POST['password'] ?? '');
$new_password      = trim($_POST['new_password'] ?? '');
$confirm_password  = trim($_POST['confirm_password'] ?? '');

$full_name = htmlspecialchars(stripslashes($full_name));

$id = $_SESSION['id'];

$error = "";

if (!$full_name) {
    $error = "Full Name is required";
} else if (!preg_match("/^[a-zA-Z ]+$/", $full_name)) {
    $error = "Full Name cannot contain numbers or special characters";
}

if ($error) {
    header("Location: ../View/edit_profile.php?error=" . urlencode($error));
    exit();
}

$database = new Database();
$conn = $database->connect();
$userModel = new UserModel();

$user = $userModel->getUserById($conn, $id);

// password change is optional: only validate/apply it if new_password was filled in
$wantsPasswordChange = ($new_password !== '' || $confirm_password !== '');

if ($wantsPasswordChange) {

    if (!$current_password) {
        header("Location: ../View/edit_profile.php?error=" . urlencode("Enter your current password to set a new one"));
        exit();
    }

    // NOTE: passwords are stored in plain text in this project (see Common/Model/User.php),
    // so we compare directly here to match that behavior.
    if (!$user || $user['password'] !== htmlspecialchars(stripslashes($current_password))) {
        header("Location: ../View/edit_profile.php?error=" . urlencode("Current password is incorrect"));
        exit();
    }

    if (strlen($new_password) < 4) {
        header("Location: ../View/edit_profile.php?error=" . urlencode("New password must be at least 4 characters"));
        exit();
    }

    if ($new_password != $confirm_password) {
        header("Location: ../View/edit_profile.php?error=" . urlencode("New password and confirmation do not match"));
        exit();
    }

    $userModel->updatePassword($conn, $id, htmlspecialchars(stripslashes($new_password)));
}

$userModel->updateFullName($conn, $id, $full_name);

$_SESSION['full_name'] = $full_name;

header("Location: ../View/profile.php?success=" . urlencode("Profile updated successfully"));
exit();
?>
