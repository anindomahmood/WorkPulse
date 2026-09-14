<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {

	include "../../Common/Model/Database.php";
	include "../Model/UserModel.php";
	include "../Model/TaskModel.php";
	include "../Model/NotificationModel.php";

	$database = new Database();
	$conn = $database->connect();

	$userModel = new UserModel();
	$taskModel = new TaskModel();
	$notificationModel = new NotificationModel();

	$num_users        = $userModel->countUsers($conn);
	$num_task         = $taskModel->countTasks($conn);
	$overdue_task     = $taskModel->countOverdue($conn);
	$nodeadline_task  = $taskModel->countNoDeadline($conn);
	$todaydue_task    = $taskModel->countDueToday($conn);
	$pending          = $taskModel->countByStatus($conn, "pending");
	$in_progress      = $taskModel->countByStatus($conn, "in_progress");
	$completed        = $taskModel->countByStatus($conn, "completed");
	$num_notifications = $notificationModel->countUnread($conn);

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Courgette&family=Libre+Baskerville:ital,wght@0,400..700;1,400..700&family=Oswald:wght@200..700&family=Playwrite+GB+J:ital,wght@0,100..400;1,100..400&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>

<body>
	<input type="checkbox" id="checkbox">
	<?php include "header.php" ?>
	<div class="body">
		<?php include "nav.php" ?>
		<section class="section-1">
			<h4 class="title" style="margin-bottom:20px;">Welcome, <?=htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'])?></h4>
			<div class="dashboard">
				<a class="dashboard-item" href="user.php">
					<i class="fa fa-users"></i>
					<span><?=$num_users?> Users</span>
				</a>
				<a class="dashboard-item" href="tasks.php">
					<i class="fa fa-tasks"></i>
					<span><?=$num_task?> All Tasks</span>
				</a>
				<a class="dashboard-item" href="tasks.php?due_date=Overdue">
					<i class="fa fa-window-close-o"></i>
					<span><?=$overdue_task?> Overdue</span>
				</a>
				<a class="dashboard-item" href="tasks.php?due_date=No Deadline">
					<i class="fa fa-clock-o"></i>
					<span><?=$nodeadline_task?> No Deadline</span>
				</a>
				<a class="dashboard-item" href="tasks.php?due_date=Due Today">
					<i class="fa fa-exclamation-triangle"></i>
					<span><?=$todaydue_task?> Due Today</span>
				</a>
				<a class="dashboard-item" href="notifications.php">
					<i class="fa fa-bell"></i>
					<span><?=$num_notifications?> Notifications</span>
				</a>
				<div class="dashboard-item">
					<i class="fa fa-square-o"></i>
					<span><?=$pending?> Pending</span>
				</div>
				<div class="dashboard-item">
					<i class="fa fa-spinner"></i>
					<span><?=$in_progress?> In progress</span>
				</div>
				<div class="dashboard-item">
					<i class="fa fa-check-square-o"></i>
					<span><?=$completed?> Completed</span>
				</div>
			</div>
		</section>
	</div>

</body>
</html>

<?php }else{
   $em = "First login";
   header("Location: ../../Common/View/login.php?error=$em");
   exit();
}
 ?>
