<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "../../Common/Model/Database.php";
    include "../Model/NotificationModel.php";

    $database = new Database();
    $conn = $database->connect();

    $notificationModel = new NotificationModel();
    $notifications = $notificationModel->getAllNotifications($conn);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Notifications</title>
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
			<h4 class="title">System Activity</h4>

			<?php if ($notifications) { ?>
			<table class="main-table">
				<tr>
					<th>#</th>
					<th>Message</th>
					<th>Recipient</th>
					<th>Type</th>
					<th>Status</th>
					<th>Date</th>
				</tr>
				<?php $i=0; foreach ($notifications as $n) { $i++; ?>
				<tr>
					<td><?=$i?></td>
					<td><?=htmlspecialchars($n['message'])?></td>
					<td><?=htmlspecialchars($n['recipient_name'] ?? '-')?></td>
					<td><?=htmlspecialchars($n['type'])?></td>
					<td><?=$n['is_read'] ? 'Read' : 'Unread'?></td>
					<td><?=$n['created_at']?></td>
				</tr>
				<?php } ?>
			</table>
			<?php } else { ?>
			<h3>No activity yet</h3>
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
