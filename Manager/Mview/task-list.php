<?php

session_start();

$tasks = $_SESSION["managerTasks"] ?? [];


?>


<html>

    <head>

        <title>Task List</title>
        <link rel="stylesheet" href="style.css">

    </head>


    <body>


        <div class="task-container">


            <h2 class="page-title">My Tasks</h2>
                
                



            <table class="task-table">


                <tr>

                    <th>Task Title</th>

                    <th>Description</th>

                    <th>Assigned To</th>

                    <th>Due Date</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>



                <?php

                foreach($tasks as $task)
                {

                ?>


                <tr>

                    <td>
                        <?php echo $task["title"]; ?>
                    </td>


                    <td>
                        <?php echo $task["description"]; ?>
                    </td>


                    <td>
                        <?php echo $task["full_name"]; ?>
                    </td>


                    <td>
                        <?php echo $task["due_date"]; ?>
                    </td>


                    <td>
                        <?php echo $task["status"]; ?>
                    </td>


                    <td>

                        <a 
                        class="edit-button"
                        href="../Mcontroller/TaskController.php?action=edit&id=<?php echo $task["task_id"];?>">
                        Edit
                        </a>


                        <a 
                        class="delete-button"
                        href="../Mcontroller/TaskController.php?action=delete&id=<?php echo $task["task_id"];?>">
                        Delete
                        </a>

                    </td>


                </tr>



                <?php

                }

                ?>


            </table>


        </div>


    </body>


</html>