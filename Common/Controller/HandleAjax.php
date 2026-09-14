<?php

include "../Model/Database.php";
include "../Model/User.php";


$username = $_POST["username"];


if(!$username)
{

    echo "Please provide your username";

}

else
{

    $database = new Database();

    $conn = $database->connect();

    $user = new User();

    $result = $user->checkExistingUserByUsername( $conn, $username);

    if($result)
    {

        echo "Username already taken";

    }

    else
    {

        echo "Username is available";

    }

}


?>
