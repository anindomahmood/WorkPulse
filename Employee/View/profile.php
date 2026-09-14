<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "../../Common/Model/Database.php";
    include "../Model/UserModel.php";

    $database = new Database();
    $conn = $database->connect();

    $userModel = new UserModel();
    $user = $userModel->getUserById($conn, $_SESSION['id']);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
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
			<h4 class="title">Profile <a href="edit_profile.php">Edit Profile</a></h4>
         <table class="main-table profile-table" style="max-width: 300px;">
				<tr>
					<td>Full Name</td>
					<td><?=htmlspecialchars($user['full_name'])?></td>
				</tr>
				<tr>
					<td>User name</td>
					<td><?=htmlspecialchars($user['username'])?></td>
				</tr>
				<tr>
					<td>Role</td>
					<td><?=htmlspecialchars(ucwords(str_replace('_',' ',$user['role'])))?></td>
				</tr>
				<tr>
					<td>Joined At</td>
					<td><?=$user['created_at']?></td>
				</tr>
			</table>

		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(3)");
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
