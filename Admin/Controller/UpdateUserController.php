<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/UserModel.php";

$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: ../View/user.php?error=" . urlencode("Invalid user"));
    exit();
}

$database = new Database();
$conn = $database->connect();
$userModel = new UserModel();

// --- Password reset form ---
if (isset($_POST['reset_password'])) {

    $newPassword = trim($_POST['new_password'] ?? '');
    $newPassword = htmlspecialchars(stripslashes($newPassword));

    if (!$newPassword || strlen($newPassword) < 4) {
        header("Location: ../View/edit-user.php?id=$id&error=" . urlencode("New password must be at least 4 characters"));
        exit();
    }

    $userModel->updatePassword($conn, $id, $newPassword);
    header("Location: ../View/user.php?success=" . urlencode("Password reset successfully"));
    exit();
}

// --- Full name / username / role update ---
$full_name = trim($_POST['full_name'] ?? '');
$username  = trim($_POST['user_name'] ?? '');
$role      = trim($_POST['role'] ?? '');

$full_name = htmlspecialchars(stripslashes($full_name));
$username  = htmlspecialchars(stripslashes($username));
$role      = htmlspecialchars(stripslashes($role));

$allowedRoles = ['admin', 'manager', 'team_leader', 'employee'];

$error = "";

if (!$full_name) {
    $error = "Full Name is required";
} else if (!preg_match("/^[a-zA-Z ]+$/", $full_name)) {
    $error = "Full Name cannot contain numbers or special characters";
} else if (!$username) {
    $error = "Username is required";
} else if (!in_array($role, $allowedRoles)) {
    $error = "Please select a valid role";
}

if ($error) {
    header("Location: ../View/edit-user.php?id=$id&error=" . urlencode($error));
    exit();
}

$existing = $userModel->checkUsernameExists($conn, $username, $id);

if ($existing) {
    header("Location: ../View/edit-user.php?id=$id&error=" . urlencode("Username already taken"));
    exit();
}

// prevent an admin demoting/locking themselves out by mistake is a product decision;
// here we just require at least one admin to remain in the system.
if ($id == $_SESSION['id'] && $role != 'admin') {
    header("Location: ../View/edit-user.php?id=$id&error=" . urlencode("You cannot remove your own admin role"));
    exit();
}

$result = $userModel->updateUser($conn, $id, $full_name, $username, $role);

if ($result) {
    header("Location: ../View/user.php?success=" . urlencode("User updated successfully"));
} else {
    header("Location: ../View/edit-user.php?id=$id&error=" . urlencode("Failed to update user"));
}
exit();
?>
