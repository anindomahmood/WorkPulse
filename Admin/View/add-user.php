<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {

	// keep old input after a validation error
	$old = $_SESSION['old_add_user'] ?? [];
	unset($_SESSION['old_add_user']);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
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
			<h4 class="title">Add Users <a href="user.php">Users</a></h4>
			<form class="form-1"
			      method="POST"
			      action="../Controller/AddUserController.php">
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
					<label>Full Name</label>
					<input type="text" name="full_name" class="input-1" placeholder="Full Name" value="<?=htmlspecialchars($old['full_name'] ?? '')?>"><br>
				</div>
				<div class="input-holder">
					<label>Username</label>
					<input type="text" name="user_name" class="input-1" placeholder="Username" value="<?=htmlspecialchars($old['username'] ?? '')?>"><br>
				</div>
				<div class="input-holder">
					<label>Password</label>
					<input type="text" name="password" class="input-1" placeholder="Password"><br>
				</div>
				<div class="input-holder">
					<label>Role</label>
					<select name="role" class="input-1">
						<option value="">Select Role</option>
						<option value="admin" <?=($old['role'] ?? '')=='admin' ? 'selected' : ''?>>Admin</option>
						<option value="manager" <?=($old['role'] ?? '')=='manager' ? 'selected' : ''?>>Manager</option>
						<option value="team_leader" <?=($old['role'] ?? '')=='team_leader' ? 'selected' : ''?>>Team Leader</option>
						<option value="employee" <?=($old['role'] ?? '')=='employee' ? 'selected' : ''?>>Employee</option>
					</select><br>
				</div>

				<button class="edit-btn">Add</button>
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
