<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "employee") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/TaskModel.php";
include "../Model/NotificationModel.php";

$id     = $_POST['id'] ?? null;
$status = trim($_POST['status'] ?? '');

$employeeId = $_SESSION['id'];

$allowedStatuses = ['pending', 'in_progress', 'completed'];

if (!$id) {
    header("Location: ../View/my_task.php?error=" . urlencode("Invalid task"));
    exit();
}

if (!in_array($status, $allowedStatuses)) {
    header("Location: ../View/edit-task-employee.php?id=$id&error=" . urlencode("Please select a valid status"));
    exit();
}

$database = new Database();
$conn = $database->connect();

$taskModel = new TaskModel();
$notificationModel = new NotificationModel();

// re-check ownership before touching anything
$task = $taskModel->getMyTaskById($conn, $id, $employeeId);

if (!$task) {
    header("Location: ../View/my_task.php?error=" . urlencode("Task not found or not assigned to you"));
    exit();
}

$result = $taskModel->updateStatus($conn, $id, $employeeId, $status);

if ($result) {

    // let whoever assigned this task know the status changed
    if ($task['status'] != $status) {
        $notificationModel->addNotification(
            $conn,
            "Task status updated: \"" . $task['title'] . "\" is now " . str_replace('_', ' ', $status),
            $task['assigned_by'],
            "Task Update"
        );
    }

    header("Location: ../View/my_task.php?success=" . urlencode("Task status updated successfully"));
} else {
    header("Location: ../View/edit-task-employee.php?id=$id&error=" . urlencode("Failed to update task status"));
}
exit();
?>
