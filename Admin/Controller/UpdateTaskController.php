<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/TaskModel.php";
include "../Model/NotificationModel.php";

$id          = $_POST['id'] ?? null;
$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$due_date    = trim($_POST['due_date'] ?? '');
$assigned_to = trim($_POST['assigned_to'] ?? '');
$status      = trim($_POST['status'] ?? 'pending');

$title       = htmlspecialchars(stripslashes($title));
$description = htmlspecialchars(stripslashes($description));

if (!$id) {
    header("Location: ../View/tasks.php?error=" . urlencode("Invalid task"));
    exit();
}

if (!$title) {
    header("Location: ../View/edit-task.php?id=$id&error=" . urlencode("Title is required"));
    exit();
}

$database = new Database();
$conn = $database->connect();

$taskModel = new TaskModel();
$notificationModel = new NotificationModel();

$oldTask = $taskModel->getTaskById($conn, $id);

$result = $taskModel->updateTask($conn, $id, $title, $description, $assigned_to, $due_date ?: null, $status);

if ($result) {
    // notify on status change
    if ($oldTask && $oldTask['status'] != $status) {
        $notificationModel->addNotification(
            $conn,
            "Task status updated: " . $title . " is now " . str_replace('_', ' ', $status),
            $assigned_to,
            "Task Update"
        );
    }

    // notify on reassignment
    if ($oldTask && $oldTask['assigned_to'] != $assigned_to) {
        $notificationModel->addNotification(
            $conn,
            "Task reassigned to you: " . $title,
            $assigned_to,
            "New Task Assigned"
        );
    }

    header("Location: ../View/tasks.php?success=" . urlencode("Task updated successfully"));
} else {
    header("Location: ../View/edit-task.php?id=$id&error=" . urlencode("Failed to update task"));
}
exit();
?>
