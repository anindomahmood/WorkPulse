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
	<header class="header">
		<h2 class="u-name">Work<b>Pulse</b>
			<label for="checkbox">
				<i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
			</label>
		</h2>
		<i class="fa fa-bell" aria-hidden="true"></i>
	</header>
	<div class="body">
		<nav class="side-bar">
			<div class="user-p">
				<img src="img/user.png">
				<h4>@user</h4>
			</div>

			<?php
				$user = "admin"; // TODO: replace with real session/auth value, e.g. $_SESSION['role']

				if ($user == "employee") {
			?>
				<!-- Employee -->
				<ul>
					<li>
						<a href="#">
							<i class="fa fa-tachometer" aria-hidden="true"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-tasks" aria-hidden="true"></i>
							<span>My Task</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-user" aria-hidden="true"></i>
							<span>Profile</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-bell" aria-hidden="true"></i>
							<span>Notification</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-sign-out" aria-hidden="true"></i>
							<span>Logout</span>
						</a>
					</li>
				</ul>
			<?php } else { ?>
				<!-- Admin -->
				<ul>
					<li>
						<a href="#">
							<i class="fa fa-tachometer" aria-hidden="true"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span>Manage Users</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-plus" aria-hidden="true"></i>
							<span>Create Task</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-tasks" aria-hidden="true"></i>
							<span>All Tasks</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-bell" aria-hidden="true"></i>
							<span>Notification</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-sign-out" aria-hidden="true"></i>
							<span>Logout</span>
						</a>
					</li>
				</ul>
			<?php } ?>

		</nav>
		<section class="section-1">
			<h1>WELCOME TO DASHBOARD</h1>
		</section>
	</div>

</body>
</html>