<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "../../Common/Model/Database.php";
    include "../Model/TaskModel.php";

    $database = new Database();
    $conn = $database->connect();

    $taskModel = new TaskModel();

    $text = "All Tasks";

    if (isset($_GET['due_date']) && $_GET['due_date'] == "Due Today") {
        $text = "Due Today";
        $tasks = $taskModel->getTasksDueToday($conn);
    } else if (isset($_GET['due_date']) && $_GET['due_date'] == "Overdue") {
        $text = "Overdue";
        $tasks = $taskModel->getOverdueTasks($conn);
    } else if (isset($_GET['due_date']) && $_GET['due_date'] == "No Deadline") {
        $text = "No Deadline";
        $tasks = $taskModel->getTasksNoDeadline($conn);
    } else {
        $tasks = $taskModel->getAllTasks($conn);
    }

    $num_task = count($tasks);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>All Tasks</title>
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
			<h4 class="title-2">
				<a href="create-task.php" class="btn">Create Task</a>
				<a href="tasks.php?due_date=Due Today" class="<?=$text=='Due Today'?'active':''?>">Due Today</a>
				<a href="tasks.php?due_date=Overdue" class="<?=$text=='Overdue'?'active':''?>">Overdue</a>
				<a href="tasks.php?due_date=No Deadline" class="<?=$text=='No Deadline'?'active':''?>">No Deadline</a>
				<a href="tasks.php" class="<?=$text=='All Tasks'?'active':''?>">All Tasks</a>
			</h4>
			<h4 class="title-2"><?=$text?> (<?=$num_task?>)</h4>

			<?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert"><?php echo stripcslashes($_GET['success']); ?></div>
			<?php } ?>
			<?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert"><?php echo stripcslashes($_GET['error']); ?></div>
			<?php } ?>

			<?php if ($tasks) { ?>
			<table class="main-table">
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Description</th>
					<th>Assigned By</th>
					<th>Assigned To</th>
					<th>Due Date</th>
					<th>Status</th>
					<th>Action</th>
				</tr>

                <?php $i=0; foreach ($tasks as $task) { $i++; ?>
				<tr>
					<td><?=$i?></td>
					<td><?=htmlspecialchars($task['title'])?></td>
					<td><?=htmlspecialchars($task['description'])?></td>
					<td><?=htmlspecialchars($task['assigned_by_name'] ?? '-')?></td>
					<td><?=htmlspecialchars($task['assigned_to_name'] ?? '-')?></td>
	            <td><?php echo $task['due_date'] ? $task['due_date'] : "No Deadline"; ?></td>
	            <td><?=htmlspecialchars(ucwords(str_replace('_',' ',$task['status'])))?></td>
					<td>
						<a href="edit-task.php?id=<?=$task['task_id']?>" class="edit-btn">Edit</a>
						<a href="../Controller/DeleteTaskController.php?id=<?=$task['task_id']?>"
						   class="delete-btn"
						   onclick="return confirm('Delete this task?')">Delete</a>
					</td>
				</tr>
			   <?php	} ?>
			</table>
		<?php }else { ?>
			<h3>Empty</h3>
		<?php  }?>

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
