<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/UserModel.php";

$full_name = trim($_POST['full_name'] ?? '');
$username  = trim($_POST['user_name'] ?? '');

$full_name = htmlspecialchars(stripslashes($full_name));
$username  = htmlspecialchars(stripslashes($username));

$id = $_SESSION['id'];

$error = "";

if (!$full_name) {
    $error = "Full Name is required";
} else if (!preg_match("/^[a-zA-Z ]+$/", $full_name)) {
    $error = "Full Name cannot contain numbers or special characters";
} else if (!$username) {
    $error = "Username is required";
}

if ($error) {
    header("Location: ../View/edit-profile.php?error=" . urlencode($error));
    exit();
}

$database = new Database();
$conn = $database->connect();
$userModel = new UserModel();

$existing = $userModel->checkUsernameExists($conn, $username, $id);

if ($existing) {
    header("Location: ../View/edit-profile.php?error=" . urlencode("Username already taken"));
    exit();
}

$result = $userModel->updateProfile($conn, $id, $full_name, $username);

if ($result) {
    $_SESSION['username'] = $username;
    $_SESSION['full_name'] = $full_name;
    header("Location: ../View/profile.php?success=" . urlencode("Profile updated successfully"));
} else {
    header("Location: ../View/edit-profile.php?error=" . urlencode("Failed to update profile"));
}
exit();
?>
