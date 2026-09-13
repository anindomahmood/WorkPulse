<?php

session_start();


include "../Mmodel/Monitor.php";
include "../../Common/Model/Database.php";


$database = new Database();

$conn = $database->connect();



$monitor = new Monitor();



$manager_id = $_SESSION["user"]["user_id"];


$totalTasks = $monitor->countTotalTasks($conn, $manager_id);


$pendingTasks = $monitor->countPendingTasks($conn, $manager_id);

$inProgressTasks = $monitor->countInProgressTasks($conn, $manager_id);


$completedTasks = $monitor->countCompletedTasks($conn, $manager_id);


$overdueTasks = $monitor->countOverdueTasks($conn, $manager_id);


$dueTodayTasks = $monitor->countDueTodayTasks($conn, $manager_id);


include "../Mview/dashboard.php";


?>