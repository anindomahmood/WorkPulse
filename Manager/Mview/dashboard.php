<?php

session_start();

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

        <body>


            <div class="dashboard-container">

                <header class="top-header">

                    <div class="logo-section">

                        <img src="" class="logo-image"/>

                        <h2>WorkPulse</h2>

                    </div>

                    <div class="notification-section">

                        <a href="">Notification</a>

                    </div>

                </header>

                <div class="sidebar">


                    <div class="profile-section">


                        <img src="" class="profile-image"/>

                        <p>@<?php echo $usernameFromCookie;?></p>


                    </div>

                    <ul>

                        <li>
                            <a href="">Dashboard</a>
                        </li>

                        <li>
                            <a href="../Mcontroller/TaskController.php?action=create">Create Task</a>
                        </li>

                        <li>
                            <a href="../Mcontroller/TaskController.php?action=list">All Tasks</a>
                        </li>

                        <li>
                            <a href="">Logout</a>
                        </li>

                    </ul>

                </div>

                <div class="main-content">


                    <div class="card-container">

                        <div class="dashboard-card">

                            <h3>Total Employees</h3>

                            <p>0</p>

                        </div>

                        <div class="dashboard-card">

                            <h3>All Tasks</h3>

                            <p>0</p>

                        </div>

                        <div class="dashboard-card">

                            <h3>Overdue Tasks</h3>
                            <p>0</p>

                        </div>

                        <div class="dashboard-card">

                            <h3>No Deadline</h3>

                            <p>0</p>

                        </div>

                        <div class="dashboard-card">

                            <h3>Due Today</h3>
                            <p>0</p>
                        </div>

                        <div class="dashboard-card">

                            <h3>Notifications</h3>
                            <p>0</p>

                        </div>

                        <div class="dashboard-card">

                            <h3> Pending</h3>

                            <p>0</p>
                        </div>

                        <div class="dashboard-card">

                            <h3>In Progress</h3>

                            <p>0</p>

                        </div>

                        <div class="dashboard-card">

                        <h3>Completed</h3>

                        <p>0</p>

                        </div>

                    </div>

                </div>

            </div>


        </body>

    </html>