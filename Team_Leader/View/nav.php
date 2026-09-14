<nav class="side-bar">
	<div class="user-p">
		<img src="img/user.png">
		<h4>@<?=htmlspecialchars($_SESSION['username'])?></h4>
	</div>

	<ul id="navList">
		<li>
			<a href="dashboard.php">
				<i class="fa fa-tachometer" aria-hidden="true"></i>
				<span>Dashboard</span>
			</a>
		</li>
		<li>
			<a href="../Controller/TaskController.php?action=list">
				<i class="fa fa-inbox" aria-hidden="true"></i>
				<span>Assigned Tasks</span>
			</a>
		</li>
		<li>
			<a href="../Controller/TaskController.php?action=team">
				<i class="fa fa-tasks" aria-hidden="true"></i>
				<span>My Team Tasks</span>
			</a>
		</li>
		<li>
			<a href="notifications.php">
				<i class="fa fa-bell" aria-hidden="true"></i>
				<span>Notifications</span>
			</a>
		</li>
		<li>
			<a href="profile.php">
				<i class="fa fa-user" aria-hidden="true"></i>
				<span>Profile</span>
			</a>
		</li>
		<li>
			<a href="../../Common/Controller/LogoutController.php">
				<i class="fa fa-sign-out" aria-hidden="true"></i>
				<span>Logout</span>
			</a>
		</li>
	</ul>
</nav>
