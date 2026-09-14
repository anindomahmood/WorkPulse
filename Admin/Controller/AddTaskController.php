<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/TaskModel.php";
include "../Model/NotificationModel.php";

$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$due_date    = trim($_POST['due_date'] ?? '');
$assigned_to = trim($_POST['assigned_to'] ?? '0');

$title       = htmlspecialchars(stripslashes($title));
$description = htmlspecialchars(stripslashes($description));

$error = "";

if (!$title) {
    $error = "Title is required";
} else if (!$assigned_to || $assigned_to == '0') {
    $error = "Please select a user to assign this task to";
}

if ($error) {
    header("Location: ../View/create-task.php?error=" . urlencode($error));
    exit();
}

$database = new Database();
$conn = $database->connect();

$taskModel = new TaskModel();
$notificationModel = new NotificationModel();

$assigned_by = $_SESSION['id'];

$newTaskId = $taskModel->addTask($conn, $title, $description, $assigned_by, $assigned_to, $due_date ?: null);

if ($newTaskId) {
    $notificationModel->addNotification(
        $conn,
        "New task assigned: " . $title,
        $assigned_to,
        "New Task Assigned"
    );
    header("Location: ../View/tasks.php?success=" . urlencode("Task created successfully"));
} else {
    header("Location: ../View/create-task.php?error=" . urlencode("Failed to create task"));
}
exit();
?>
