<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "../../Common/Model/Database.php";
    include "../Model/TaskModel.php";
    include "../Model/UserModel.php";

    if (!isset($_GET['id'])) {
        header("Location: tasks.php?error=" . urlencode("No task selected"));
        exit();
    }

    $database = new Database();
    $conn = $database->connect();

    $taskModel = new TaskModel();
    $userModel = new UserModel();

    $task = $taskModel->getTaskById($conn, $_GET['id']);
    $users = $userModel->getAllUsers($conn);

    if (!$task) {
        header("Location: tasks.php?error=" . urlencode("Task not found"));
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
			<h4 class="title">Edit Task <a href="tasks.php">All Tasks</a></h4>
		   <form class="form-1"
			      method="POST"
			      action="../Controller/UpdateTaskController.php">
			      <?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert">
			  <?php echo stripcslashes($_GET['error']); ?>
			</div>
      	  <?php } ?>

				<div class="input-holder">
					<label>Title</label>
					<input type="text" name="title" class="input-1" value="<?=htmlspecialchars($task['title'])?>"><br>
				</div>
				<div class="input-holder">
					<label>Description</label>
					<textarea name="description" class="input-1"><?=htmlspecialchars($task['description'])?></textarea><br>
				</div>
				<div class="input-holder">
					<label>Due Date</label>
					<input type="date" name="due_date" class="input-1" value="<?=$task['due_date']?>"><br>
				</div>
				<div class="input-holder">
					<label>Assigned to</label>
					<select name="assigned_to" class="input-1">
						<?php foreach ($users as $u) { ?>
                  <option value="<?=$u['user_id']?>" <?=$u['user_id']==$task['assigned_to']?'selected':''?>><?=htmlspecialchars($u['full_name'])?> (<?=htmlspecialchars(ucwords(str_replace('_',' ',$u['role'])))?>)</option>
						<?php } ?>
					</select><br>
				</div>
				<div class="input-holder">
					<label>Status</label>
					<select name="status" class="input-1">
						<option value="pending" <?=$task['status']=='pending'?'selected':''?>>Pending</option>
						<option value="in_progress" <?=$task['status']=='in_progress'?'selected':''?>>In Progress</option>
						<option value="completed" <?=$task['status']=='completed'?'selected':''?>>Completed</option>
					</select><br>
				</div>
				<input type="text" name="id" value="<?=$task['task_id']?>" hidden>

				<button class="edit-btn">Update</button>
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
