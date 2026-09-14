<?php

$username = $_SESSION["loggedInUsername"] ?? "";
$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;

if(!$isLoggedIn)
{
    header("Location: ../../Common/View/login.php");
    exit;
}

$isSetCookie = isset($_COOKIE["username"]);

$usernameFromCookie = $_COOKIE["username"] ?? "";


?>


    <html>
        <head>
             <link rel="stylesheet" href="../Mview/style.css">
             
        </head>

        <body>


            <div class="dashboard-container">

                <header class="top-header">

                    <div class="logo-section">

                        <img src="" class="logo-image"/>

                        <h2>WorkPulse</h2>

                    </div>


                </header>

                <div class="sidebar">


                    <div class="profile-section">


                        <img src="../Image/user.png" class="profile-image"/>

                        <p>@<?php echo $usernameFromCookie;?></p>


                    </div>

                    <ul>

                        <li>
                            <a href="../Mcontroller/DashboardController.php">Dashboard</a>
                        </li>

                        <li>
                            <a href="../Mcontroller/TaskController.php?action=create">Create Task</a>
                        </li>

                        <li>
                            <a href="../Mcontroller/TaskController.php?action=list">All Tasks</a>
                        </li>
                        <li>
                            <a href="../Mcontroller/TaskController.php?action=profile">Profile</a>
                        </li>

                        <li>
                            <a href="../../Common/Controller/LogoutController.php">Logout</a>
                        </li>

                    </ul>

                </div>

                <div class="main-content">


                    <div class="card-container">


                        <div class="dashboard-card">

                            <h3>All Tasks</h3>

                            <p><?php echo $totalTasks; ?></p>

                        </div>

                        <div class="dashboard-card">

                            <h3>Overdue Tasks</h3>
                            <p><?php echo $overdueTasks; ?></p>

                        </div>


                        <div class="dashboard-card">

                            <h3>Due Today</h3>
                            <p><?php echo $dueTodayTasks; ?></p>
                        </div>


                        <div class="dashboard-card">

                            <h3> Pending</h3>

                            <p><?php echo $pendingTasks; ?></p>
                        </div>

                        <div class="dashboard-card">

                            <h3>In Progress</h3>

                            <p><?php echo $inProgressTasks; ?></p>

                        </div>

                        <div class="dashboard-card">

                        <h3>Completed</h3>

                        <p><?php echo $completedTasks; ?></p>

                        </div>

                    </div>

                </div>

            </div>


        </body>

    </html>