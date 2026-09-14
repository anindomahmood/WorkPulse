<?php

session_start();


include "../Model/Database.php";
include "../Model/User.php";



$username = $_POST["username"];
$password = $_POST["password"];

$_SESSION["username"] = $username;

// remove extra spaces and unwanted characters

$username = trim($username);
$username = stripslashes($username);
$username = htmlspecialchars($username);



$password = trim($password);
$password = stripslashes($password);
$password = htmlspecialchars($password);



$hasError = false;



$_SESSION["username"] = $username;



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

    header("Location: ../View/login.php");

}

else
{

    $database = new Database();

    $conn = $database->connect();



    $user = new User();



    $result = $user->login( $conn,$username,$password);



    if($result)
    {


        setcookie("username",$username,time() + 3600,"/");


        $_SESSION["loggedInUsername"] = $result["username"];


        $_SESSION["isLoggedIn"] = true;



        $_SESSION["user"] = $result;

        // used by Admin/View pages ($_SESSION['role'] / $_SESSION['id'] / $_SESSION['username'])
        $_SESSION["role"] = $result["role"];
        $_SESSION["id"] = $result["user_id"];
        $_SESSION["username"] = $result["username"];
        $_SESSION["full_name"] = $result["full_name"];




        if($result["role"] == "admin")
        {

            header("Location: ../../Admin/View/dashboard.php");

        }


        else if($result["role"] == "manager")
        {

            header("Location: ../../Manager/Mcontroller/DashboardController.php");

        }


        else if($result["role"] == "team_leader")
        {

            header("Location: ../../Team_Leader/View/dashboard.php");

        }


        else if($result["role"] == "employee")
        {

            header("Location: ../../Employee/View/dashboard.php");

        }


    }

    else
    {

        $_SESSION["usernameError"] = "Invalid username or password";


        header("Location: ../View/login.php");

    }


}

?>
