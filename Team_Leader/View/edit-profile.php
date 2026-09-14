<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "team_leader") {
    include "../../Common/Model/Database.php";
    include "../Model/User.php";

    $database = new Database();
    $conn = $database->connect();

    $user = new User();
    $u = $user->getUserById($conn, $_SESSION['id']);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
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
			<h4 class="title">Edit Profile <a href="profile.php">Profile</a></h4>

			<?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert"><?php echo stripcslashes($_GET['error']); ?></div>
      	  <?php } ?>
			<?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert"><?php echo stripcslashes($_GET['success']); ?></div>
      	  <?php } ?>

			<form class="form-1" method="POST" action="../Controller/ProfileController.php">
				<div class="input-holder">
					<label>Full Name</label>
					<input type="text" name="full_name" class="input-1" value="<?=htmlspecialchars($u['full_name'])?>">
				</div>
				<div class="input-holder">
					<label>Old Password</label>
					<input type="password" name="password" class="input-1" placeholder="Old Password">
				</div>
				<div class="input-holder">
					<label>New Password</label>
					<input type="password" name="new_password" class="input-1" placeholder="New Password (leave blank to keep current)">
				</div>
				<div class="input-holder">
					<label>Confirm Password</label>
					<input type="password" name="confirm_password" class="input-1" placeholder="Confirm Password">
				</div>
				<button class="edit-btn">Change</button>
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
