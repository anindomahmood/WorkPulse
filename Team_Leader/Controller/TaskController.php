<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "team_leader") {
    header("Location: ../../Common/View/login.php?error=First login");
    exit();
}

include "../../Common/Model/Database.php";
include "../Model/Task.php";
include "../Model/Notification.php";

$database = new Database();
$conn = $database->connect();

$task = new Task();
$notification = new Notification();

$team_leader_id = $_SESSION["id"];




// ---- View Manager Assigned Tasks ----

if(isset($_GET["action"]) && $_GET["action"] == "list")
{

    $tasks = $task->getAssignedTasks($conn, $team_leader_id);

    $_SESSION["assignedTasks"] = $tasks;

    header("Location: ../View/tasks.php");
    exit();

}




// ---- start assigning a subtask under one of the manager's tasks ----

if(isset($_GET["action"]) && $_GET["action"] == "create")
{

    if(!isset($_GET["parent_id"]))
    {
        header("Location: TaskController.php?action=list");
        exit();
    }

    $parent_id = $_GET["parent_id"];

    // ownership check: this manager-task must actually be assigned to me
    $parentTask = $task->getAssignedTaskById($conn, $parent_id, $team_leader_id);

    if(!$parentTask)
    {
        header("Location: TaskController.php?action=list&error=" . urlencode("Task not found or not assigned to you"));
        exit();
    }

    $employees = $task->getEmployees($conn);

    $_SESSION["employees"] = $employees;
    $_SESSION["parentTask"] = $parentTask;

    header("Location: ../View/create-subtask.php");
    exit();

}




// ---- Monitor Employee Progress: my subtasks, with optional filter ----

if(isset($_GET["action"]) && $_GET["action"] == "team")
{

    if(isset($_GET["due_date"]) && $_GET["due_date"] == "Due Today")
    {
        $_SESSION["mySubtasksLabel"] = "Due Today";
        $tasks = $task->getMySubtasksDueToday($conn, $team_leader_id);
    }
    else if(isset($_GET["due_date"]) && $_GET["due_date"] == "Overdue")
    {
        $_SESSION["mySubtasksLabel"] = "Overdue";
        $tasks = $task->getMySubtasksOverdue($conn, $team_leader_id);
    }
    else if(isset($_GET["due_date"]) && $_GET["due_date"] == "No Deadline")
    {
        $_SESSION["mySubtasksLabel"] = "No Deadline";
        $tasks = $task->getMySubtasksNoDeadline($conn, $team_leader_id);
    }
    else
    {
        $_SESSION["mySubtasksLabel"] = "All Tasks";
        $tasks = $task->getMySubtasks($conn, $team_leader_id);
    }

    $_SESSION["mySubtasks"] = $tasks;

    header("Location: ../View/team-tasks.php");
    exit();

}




// ---- edit one of my subtasks ----

if(isset($_GET["action"]) && $_GET["action"] == "edit")
{

    $task_id = $_GET["id"];

    $taskData = $task->getSubtaskById($conn, $task_id, $team_leader_id);

    if(!$taskData)
    {
        header("Location: TaskController.php?action=team&error=" . urlencode("Task not found"));
        exit();
    }

    $employees = $task->getEmployees($conn);

    $_SESSION["editSubtask"] = $taskData;
    $_SESSION["employees"] = $employees;

    header("Location: ../View/edit-subtask.php");
    exit();

}




// ---- delete one of my subtasks ----

if(isset($_GET["action"]) && $_GET["action"] == "delete")
{

    $task_id = $_GET["id"];

    $result = $task->deleteSubtask($conn, $task_id, $team_leader_id);

    if($result)
    {
        header("Location: TaskController.php?action=team&success=" . urlencode("Task deleted successfully"));
    }
    else
    {
        header("Location: TaskController.php?action=team&error=" . urlencode("Delete failed"));
    }
    exit();

}




// ---- update an existing subtask ----

if(isset($_POST["update"]))
{

    $task_id = $_POST["task_id"];

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $assigned_to = $_POST["assigned_to"];
    $due_date = trim($_POST["due_date"]);

    $title = htmlspecialchars(stripslashes($title));
    $description = htmlspecialchars(stripslashes($description));

    if(!$title)
    {
        header("Location: ../View/edit-subtask.php?error=" . urlencode("Title is required"));
        exit();
    }

    $oldTask = $task->getSubtaskById($conn, $task_id, $team_leader_id);

    $result = $task->updateSubtask(
        $conn,
        $title,
        $description,
        $assigned_to,
        $due_date,
        $task_id,
        $team_leader_id
    );

    if($result)
    {

        if($oldTask && $oldTask["assigned_to"] != $assigned_to)
        {
            $notification->addNotification(
                $conn,
                "Task reassigned to you: " . $title,
                $assigned_to,
                "New Task Assigned"
            );
        }

        header("Location: TaskController.php?action=team&success=" . urlencode("Task updated successfully"));

    }
    else
    {
        header("Location: TaskController.php?action=team&error=" . urlencode("Update failed"));
    }
    exit();

}




// ---- create a new subtask (Assign Tasks to Employees) ----

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $assigned_to = $_POST["assigned_to"];
    $due_date = trim($_POST["due_date"]);
    $parent_task_id = $_POST["parent_task_id"];

    $title = htmlspecialchars(stripslashes($title));
    $description = htmlspecialchars(stripslashes($description));

    if(!$title)
    {
        header("Location: TaskController.php?action=create&parent_id=$parent_task_id&error=" . urlencode("Title is required"));
        exit();
    }

    if(!$assigned_to)
    {
        header("Location: TaskController.php?action=create&parent_id=$parent_task_id&error=" . urlencode("Please select an Employee"));
        exit();
    }

    // re-verify ownership of the parent task before attaching a subtask to it
    $parentTask = $task->getAssignedTaskById($conn, $parent_task_id, $team_leader_id);

    if(!$parentTask)
    {
        header("Location: TaskController.php?action=list&error=" . urlencode("Parent task not found or not assigned to you"));
        exit();
    }

    $newTaskId = $task->createSubtask(
        $conn,
        $title,
        $description,
        $team_leader_id,
        $assigned_to,
        $parent_task_id,
        $due_date
    );

    if($newTaskId)
    {

        $notification->addNotification(
            $conn,
            "New task assigned: " . $title,
            $assigned_to,
            "New Task Assigned"
        );

        header("Location: TaskController.php?action=team&success=" . urlencode("Task assigned successfully"));

    }
    else
    {
        header("Location: TaskController.php?action=create&parent_id=$parent_task_id&error=" . urlencode("Task creation failed"));
    }
    exit();

}


// no matching action/method - fall back to the dashboard
header("Location: ../View/dashboard.php");
exit();

?>
