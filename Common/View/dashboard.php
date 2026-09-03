<?php

session_start();


$user = $_SESSION["user"] ?? null;


if(!$user)
{
    header("Location: login.php");
}


?>


<html>

<head>

<title>Dashboard</title>

</head>


<body>


<h1>
Hello Welcome to WorkPlus
</h1>


<?php

if($user)
{
    echo "<h3>Welcome " . $user["full_name"] . "</h3>";
    echo "<p>Role: " . $user["role"] . "</p>";
}

?>


<a href="../Controller/LogoutController.php">
Logout
</a>


</body>


</html>