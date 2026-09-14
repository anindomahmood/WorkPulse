<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "team_leader") {

$task = $_SESSION["editSubtask"] ?? [];
$employees = $_SESSION["employees"] ?? [];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Task</title>
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
			<h4 class="title">Edit Task</h4>

			<?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert"><?php echo stripcslashes($_GET['error']); ?></div>
      	  <?php } ?>

			<form class="form-1" action="../Controller/TaskController.php" method="post">

				<div class="input-holder">
					<label>Task Title</label>
					<input type="text" name="title" class="input-1" value="<?php echo htmlspecialchars($task["title"]); ?>">
				</div>

				<div class="input-holder">
					<label>Description</label>
					<textarea name="description" class="input-1"><?php echo htmlspecialchars($task["description"]); ?></textarea>
				</div>

				<div class="input-holder">
					<label>Due Date</label>
					<input type="date" name="due_date" class="input-1" value="<?php echo $task["due_date"]; ?>">
				</div>

				<div class="input-holder">
					<label>Assign Employee</label>
					<select name="assigned_to" class="input-1">
						<?php foreach($employees as $emp) { ?>
						<option value="<?php echo $emp["user_id"]; ?>"
							<?php if($task["assigned_to"] == $emp["user_id"]) { echo "selected"; } ?>>
							<?php echo htmlspecialchars($emp["full_name"]); ?>
						</option>
						<?php } ?>
					</select>
				</div>

				<input type="hidden" name="task_id" value="<?php echo $task["task_id"]; ?>">
				<button type="submit" name="update" class="edit-btn">Update Task</button>

			</form>

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
