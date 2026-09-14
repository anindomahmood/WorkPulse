<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "../../Common/Model/Database.php";
    include "../Model/TaskModel.php";

    if (!isset($_GET['id'])) {
    	 header("Location: my_task.php?error=" . urlencode("No task selected"));
    	 exit();
    }

    $database = new Database();
    $conn = $database->connect();

    $taskModel = new TaskModel();
    $id = $_GET['id'];

    // ownership check happens inside the model query itself
    $task = $taskModel->getMyTaskById($conn, $id, $_SESSION['id']);

    if (!$task) {
    	 header("Location: my_task.php?error=" . urlencode("Task not found"));
    	 exit();
    }
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
			<h4 class="title">Edit Task <a href="my_task.php" class="task-badge">Tasks</a></h4>
			<form class="form-1"
			      method="POST"
			      action="../Controller/UpdateTaskStatusController.php">
			      <?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert">
			  <?php echo stripcslashes($_GET['error']); ?>
			</div>
      	  <?php } ?>

      	  <?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
      	  <?php } ?>
				<div class="input-holder">
					<p><b>Title: </b><?=htmlspecialchars($task['title'])?></p>
				</div>
				<div class="input-holder">
					<p><b>Description: </b><?=htmlspecialchars($task['description'])?></p>
				</div>
				<div class="input-holder">
					<p><b>Due Date: </b><?=$task['due_date'] ? $task['due_date'] : 'No Deadline'?></p>
				</div><br>
            <div class="input-holder">
					<label>Status</label>
					<select name="status" class="input-1">
						<option value="pending" <?php if( $task['status'] == "pending") echo"selected"; ?>>Pending</option>
						<option value="in_progress" <?php if( $task['status'] == "in_progress") echo"selected"; ?>>In Progress</option>
						<option value="completed" <?php if( $task['status'] == "completed") echo"selected"; ?>>Completed</option>
					</select><br>
				</div>
				<input type="text" name="id" value="<?=$task['task_id']?>" hidden>

				<button class="edit-btn">Update</button>
			</form>

		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	if (active) active.classList.add("active");
</script>
</body>
</html>
<?php }else{
   $em = "First login";
   header("Location: ../../Common/View/login.php?error=$em");
   exit();
}
 ?>
