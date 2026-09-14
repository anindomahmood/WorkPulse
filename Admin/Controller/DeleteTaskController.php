<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/TaskModel.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../View/tasks.php?error=" . urlencode("Invalid task"));
    exit();
}

$database = new Database();
$conn = $database->connect();
$taskModel = new TaskModel();

if ($taskModel->hasChildTasks($conn, $id)) {
    header("Location: ../View/tasks.php?error=" . urlencode("Cannot delete: this task has subtasks. Delete or reassign them first."));
    exit();
}

$result = $taskModel->deleteTask($conn, $id);

if ($result) {
    header("Location: ../View/tasks.php?success=" . urlencode("Task deleted successfully"));
} else {
    header("Location: ../View/tasks.php?error=" . urlencode("Failed to delete task"));
}
exit();
?>
