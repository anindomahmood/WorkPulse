<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);


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


    $teamLeaders = $task->getTeamLeaders($conn);


    $_SESSION["editTask"] = $taskData;


    $_SESSION["teamLeaders"] = $teamLeaders;


    header("Location: ../Mview/edit-task.php");

    exit;

}

if(isset($_GET["action"]) && $_GET["action"] == "profile")
{

    $user_id = $_SESSION["user"]["user_id"];


    $profile = $task->getProfile(
        $conn,
        $user_id
    );


    $_SESSION["profile"] = $profile;


    header("Location: ../Mview/edit-profile.php");

    exit;

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


    $title = trim($_POST["title"]);

    $description = trim($_POST["description"]);

    $assigned_to = $_POST["assigned_to"];

    $due_date = $_POST["due_date"];



    $hasError = false;



    if(!$title)
    {
        $_SESSION["titleError"] = "Task title is required";
        $hasError = true;
    }



    if(!$description)
    {
        $_SESSION["descriptionError"] = "Description is required";
        $hasError = true;
    }



    if(!$assigned_to)
    {
        $_SESSION["assignedError"] = "Please select team leader";
        $hasError = true;
    }



    if(!$due_date)
    {
        $_SESSION["dueDateError"] = "Due date is required";
        $hasError = true;
    }



    if($hasError)
    {

        header("Location: ../Mcontroller/TaskController.php?action=edit&id=".$task_id);
        exit;

    }



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

        exit;

    }
    else
    {

        echo "Update failed";

    }
    
}

if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["update"]) && !isset($_POST["updateProfile"]))
{


    $title = trim($_POST["title"]);

    $description = trim($_POST["description"]);

    $assigned_to = $_POST["assigned_to"];

    $due_date = $_POST["due_date"];



    $hasError = false;



    if(!$title)
    {
        $_SESSION["titleError"] = "Task title is required";
        $hasError = true;
    }



    if(!$description)
    {
        $_SESSION["descriptionError"] = "Description is required";
        $hasError = true;
    }



    if(!$assigned_to)
    {
        $_SESSION["assignedError"] = "Please select team leader";
        $hasError = true;
    }



    if(!$due_date)
    {
        $_SESSION["dueDateError"] = "Due date is required";
        $hasError = true;
    }



    if($hasError)
    {

        header("Location: ../Mview/create-task.php");
        exit;

    }



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

if(isset($_POST["updateProfile"]))
{

    $full_name = trim($_POST["full_name"]);

    $username = trim($_POST["username"]);

    $password = trim($_POST["password"]);



    $hasError = false;



    if(!$full_name)
    {
        $_SESSION["fullNameError"] = "Full Name is required";
        $hasError = true;
    }



    if(!$username)
    {
        $_SESSION["usernameError"] = "Username is required";
        $hasError = true;
    }



    if(!$password)
    {
        $_SESSION["passwordError"] = "Password is required";
        $hasError = true;
    }



    if($hasError)
    {

        header("Location: ../Mview/edit-profile.php");

        exit;

    }



    $user_id = $_SESSION["user"]["user_id"];



    $result = $task->updateProfile(
        $conn,
        $full_name,
        $username,
        $password,
        $user_id
    );

    

    if($result)
    {

        $_SESSION["user"]["full_name"] = $full_name;

        $_SESSION["user"]["username"] = $username;


        header("Location: DashboardController.php");

        exit;

    }


    else
    {

        echo "Profile update failed";

    }


}

?>