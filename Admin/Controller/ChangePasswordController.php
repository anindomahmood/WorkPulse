<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/UserModel.php";

$current_password = trim($_POST['current_password'] ?? '');
$new_password      = trim($_POST['new_password'] ?? '');
$confirm_password  = trim($_POST['confirm_password'] ?? '');

$id = $_SESSION['id'];

$error = "";

if (!$current_password || !$new_password || !$confirm_password) {
    $error = "All password fields are required";
} else if (strlen($new_password) < 4) {
    $error = "New password must be at least 4 characters";
} else if ($new_password != $confirm_password) {
    $error = "New password and confirmation do not match";
}

if ($error) {
    header("Location: ../View/edit-profile.php?error=" . urlencode($error));
    exit();
}

$database = new Database();
$conn = $database->connect();
$userModel = new UserModel();

$user = $userModel->getUserById($conn, $id);

// NOTE: passwords are stored in plain text in this project (see Common/Model/User.php),
// so we compare directly here to match that behavior.
if (!$user || $user['password'] !== htmlspecialchars(stripslashes($current_password))) {
    header("Location: ../View/edit-profile.php?error=" . urlencode("Current password is incorrect"));
    exit();
}

$new_password = htmlspecialchars(stripslashes($new_password));

$result = $userModel->updatePassword($conn, $id, $new_password);

if ($result) {
    header("Location: ../View/profile.php?success=" . urlencode("Password changed successfully"));
} else {
    header("Location: ../View/edit-profile.php?error=" . urlencode("Failed to change password"));
}
exit();
?>
