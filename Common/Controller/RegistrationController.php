<?php

session_start();

include "../Model/Database.php";
include "../Model/User.php";


$full_name = $_POST["full_name"];
$username = $_POST["username"];
$password = $_POST["password"];
$role = $_POST["role"];



// remove unwanted characters

$full_name = trim($full_name);
$full_name = stripslashes($full_name);
$full_name = htmlspecialchars($full_name);


$username = trim($username);
$username = stripslashes($username);
$username = htmlspecialchars($username);


$password = trim($password);
$password = stripslashes($password);
$password = htmlspecialchars($password);


$role = trim($role);
$role = stripslashes($role);
$role = htmlspecialchars($role);



$hasError = false;



// keep old value

$_SESSION["fullName"] = $full_name;
$_SESSION["username"] = $username;
$_SESSION["role"] = $role;



// Full Name validation

if(!$full_name)
{
    $_SESSION["fullNameError"] = "Full Name is required";
    $hasError = true;
}
else if(!preg_match("/^[a-zA-Z ]+$/", $full_name))
{
    $_SESSION["fullNameError"] = "Full Name cannot contain numbers or special characters";
    $hasError = true;
}



// Username validation

if(!$username)
{
    $_SESSION["usernameError"] = "Username is required";
    $hasError = true;
}



// Password validation

if(!$password)
{
    $_SESSION["passwordError"] = "Password is required";
    $hasError = true;
}
else if(strlen($password) < 4)
{
    $_SESSION["passwordError"] = "Password must be at least 4 characters";
    $hasError = true;
}



// Role validation

if(!$role)
{
    $_SESSION["roleError"] = "Role is required";
    $hasError = true;
}



// error hole back

if($hasError)
{
    header("Location: ../View/registration.php");
}

else
{

    $database = new Database();

    $conn = $database->connect();



    $user = new User();


    $result = $user->register(
        $conn,
        $full_name,
        $username,
        $password,
        $role
    );



    if($result)
    {
        unset($_SESSION["fullName"]);
        unset($_SESSION["username"]);
        unset($_SESSION["role"]);

        header("Location: ../View/login.php");
    }

    else
    {
        echo "Registration Failed";
    }

}


?>