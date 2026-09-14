<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/UserModel.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../View/user.php?error=" . urlencode("Invalid user"));
    exit();
}

if ($id == $_SESSION['id']) {
    header("Location: ../View/user.php?error=" . urlencode("You cannot delete your own account"));
    exit();
}

$database = new Database();
$conn = $database->connect();
$userModel = new UserModel();

$result = $userModel->deleteUser($conn, $id);

if ($result) {
    header("Location: ../View/user.php?success=" . urlencode("User deleted successfully"));
} else {
    header("Location: ../View/user.php?error=" . urlencode("Failed to delete user. They may still have tasks assigned."));
}
exit();
?>
