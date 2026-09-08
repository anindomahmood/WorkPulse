<?php

session_start();


include "../../Common/Model/Database.php";
include "../Mmodel/Task.php";



$database = new Database();

$conn = $database->connect();



$task = new Task();





if(isset($_GET["action"]) && $_GET["action"] == "create")
{

    $teamLeaders = $task->getTeamLeaders($conn);


    $_SESSION["teamLeaders"] = $teamLeaders;


    header("Location: ../Mview/create-task.php");

}





if(isset($_GET["action"]) && $_GET["action"] == "list")
{

    $manager_id = $_SESSION["user"]["user_id"];


    $tasks = $task->getManagerTasks(
        $conn,
        $manager_id
    );


    $_SESSION["managerTasks"] = $tasks;


    header("Location: ../Mview/task-list.php");

}

if(isset($_GET["action"]) && $_GET["action"] == "edit")
{

    $task_id = $_GET["id"];


    $manager_id = $_SESSION["user"]["user_id"];


    $taskData = $task->getTaskById(
        $conn,
        $task_id,
        $manager_id
    );


    $_SESSION["editTask"] = $taskData;


    header("Location: ../Mview/edit-task.php");

}

if(isset($_GET["action"]) && $_GET["action"] == "delete")
{

    $task_id = $_GET["id"];


    $manager_id = $_SESSION["user"]["user_id"];



    $result = $task->deleteTask(
        $conn,
        $task_id,
        $manager_id
    );



    if($result)
    {

        header("Location: TaskController.php?action=list");

    }

    else
    {

        echo "Delete failed";

    }

}

if(isset($_POST["update"]))
{

    $task_id = $_POST["task_id"];

    $title = $_POST["title"];
    $description = $_POST["description"];
    $assigned_to = $_POST["assigned_to"];
    $due_date = $_POST["due_date"];


    $manager_id = $_SESSION["user"]["user_id"];



    $result = $task->updateTask(
        $conn,
        $title,
        $description,
        $assigned_to,
        $due_date,
        $task_id,
        $manager_id
    );


    if($result)
    {

        header("Location: TaskController.php?action=list");

    }

    else
    {

        echo "Update failed";

    }

}

if($_SERVER["REQUEST_METHOD"] == "POST")
{


    $title = $_POST["title"];
    $description = $_POST["description"];
    $assigned_to = $_POST["assigned_to"];
    $due_date = $_POST["due_date"];



    $manager_id = $_SESSION["user"]["user_id"];



    $result = $task->createTask(
        $conn,
        $title,
        $description,
        $manager_id,
        $assigned_to,
        $due_date
    );



    if($result)
    {

        header("Location: TaskController.php?action=list");

    }

    else
    {

        echo "Task creation failed";

    }


}


?>