<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "team_leader") {

	include "../../Common/Model/Database.php";
	include "../Model/Task.php";
	include "../Model/Notification.php";

	$database = new Database();
	$conn = $database->connect();

	$task = new Task();
	$notification = new Notification();

	$id = $_SESSION['id'];

	$num_assigned    = $task->countAssignedTasks($conn, $id);
	$num_employees   = $task->countEmployees($conn);
	$num_subtasks    = $task->countMySubtasks($conn, $id);
	$overdue_task    = $task->countOverdue($conn, $id);
	$nodeadline_task = $task->countNoDeadline($conn, $id);
	$todaydue_task   = $task->countDueToday($conn, $id);
	$pending         = $task->countByStatus($conn, $id, "pending");
	$in_progress     = $task->countByStatus($conn, $id, "in_progress");
	$completed       = $task->countByStatus($conn, $id, "completed");
	$num_notifications = $notification->countUnread($conn, $id);

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
			<h4 class="title" style="background:none;">Welcome, <?=htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'])?></h4>
			<div class="dashboard">
				<a class="dashboard-item" href="../Controller/TaskController.php?action=list">
					<i class="fa fa-inbox"></i>
					<span><?=$num_assigned?> Assigned to Me</span>
				</a>
				<div class="dashboard-item">
					<i class="fa fa-users"></i>
					<span><?=$num_employees?> Employees</span>
				</div>
				<a class="dashboard-item" href="../Controller/TaskController.php?action=team">
					<i class="fa fa-tasks"></i>
					<span><?=$num_subtasks?> Tasks Assigned Out</span>
				</a>
				<a class="dashboard-item" href="../Controller/TaskController.php?action=team&due_date=Overdue">
					<i class="fa fa-window-close-o"></i>
					<span><?=$overdue_task?> Overdue</span>
				</a>
				<a class="dashboard-item" href="../Controller/TaskController.php?action=team&due_date=No Deadline">
					<i class="fa fa-clock-o"></i>
					<span><?=$nodeadline_task?> No Deadline</span>
				</a>
				<a class="dashboard-item" href="../Controller/TaskController.php?action=team&due_date=Due Today">
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
