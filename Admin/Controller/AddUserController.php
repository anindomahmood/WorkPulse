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
$password  = trim($_POST['password'] ?? '');
$role      = trim($_POST['role'] ?? '');

$full_name = htmlspecialchars(stripslashes($full_name));
$username  = htmlspecialchars(stripslashes($username));
$password  = htmlspecialchars(stripslashes($password));
$role      = htmlspecialchars(stripslashes($role));

$_SESSION['old_add_user'] = [
    'full_name' => $full_name,
    'username'  => $username,
    'role'      => $role
];

$allowedRoles = ['admin', 'manager', 'team_leader', 'employee'];

$error = "";

if (!$full_name) {
    $error = "Full Name is required";
} else if (!preg_match("/^[a-zA-Z ]+$/", $full_name)) {
    $error = "Full Name cannot contain numbers or special characters";
} else if (!$username) {
    $error = "Username is required";
} else if (!$password) {
    $error = "Password is required";
} else if (strlen($password) < 4) {
    $error = "Password must be at least 4 characters";
} else if (!in_array($role, $allowedRoles)) {
    $error = "Please select a valid role";
}

if ($error) {
    header("Location: ../View/add-user.php?error=" . urlencode($error));
    exit();
}

$database = new Database();
$conn = $database->connect();

$userModel = new UserModel();

$existing = $userModel->checkUsernameExists($conn, $username);

if ($existing) {
    header("Location: ../View/add-user.php?error=" . urlencode("Username already taken"));
    exit();
}

$result = $userModel->addUser($conn, $full_name, $username, $password, $role);

if ($result) {
    unset($_SESSION['old_add_user']);
    header("Location: ../View/user.php?success=" . urlencode("User added successfully"));
} else {
    header("Location: ../View/add-user.php?error=" . urlencode("Failed to add user"));
}
exit();
?>
