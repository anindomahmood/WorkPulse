<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "team_leader") {

$tasks = $_SESSION["assignedTasks"] ?? [];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Assigned Tasks</title>
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
			<h4 class="title" style="background:none;">Tasks Assigned To Me By Managers</h4>

			<?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert"><?php echo stripcslashes($_GET['error']); ?></div>
			<?php } ?>

			<?php if ($tasks) { ?>
			<table class="main-table">
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Assigned By</th>
					<th>Due Date</th>
					<th>Status</th>
					<th>Subtasks</th>
					<th>Action</th>
				</tr>
				<?php foreach ($tasks as $t) { ?>
				<tr>
					<td><?=htmlspecialchars($t['title'])?></td>
					<td><?=htmlspecialchars($t['description'])?></td>
					<td><?=htmlspecialchars($t['manager_name'] ?? '-')?></td>
					<td><?php echo $t['due_date'] ? $t['due_date'] : "No Deadline"; ?></td>
					<td><?=htmlspecialchars(ucwords(str_replace('_',' ',$t['status'])))?></td>
					<td><?=$t['subtask_count']?></td>
					<td>
						<a href="../Controller/TaskController.php?action=create&parent_id=<?=$t['task_id']?>" class="edit-btn">Assign to Employee</a>
					</td>
				</tr>
				<?php } ?>
			</table>
			<?php } else { ?>
			<h3>No tasks assigned to you yet</h3>
			<?php } ?>

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
