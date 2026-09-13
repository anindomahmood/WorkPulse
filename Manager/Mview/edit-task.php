<?php

session_start();


$task = $_SESSION["editTask"] ?? [];

$teamLeaders = $_SESSION["teamLeaders"] ?? [];




$titleError = $_SESSION["titleError"] ?? "";

$descriptionError = $_SESSION["descriptionError"] ?? "";

$assignedError = $_SESSION["assignedError"] ?? "";

$dueDateError = $_SESSION["dueDateError"] ?? "";




unset($_SESSION["titleError"]);

unset($_SESSION["descriptionError"]);

unset($_SESSION["assignedError"]);

unset($_SESSION["dueDateError"]);

?>


<html>
    <head>
        <script src="../Mcontroller/taskValidation.js"></script>

         <link rel="stylesheet" href="style.css">
    </head>

    <body>


        <form class="task-form" action="../Mcontroller/TaskController.php" method="post" onsubmit="return validateEditTask()">


            <fieldset class="task-fieldset">


                <legend class="form-title">Edit Task</legend>





                <table class="task-table">



                    <tr>

                        <td class="label">Task Title</td>

                        <td>
                            <input 
                            type="text" 
                            name="title"
                            id="task-title"
                            class="input-field"
                            value="<?php echo $task["title"]; ?>"
                            />
                        </td>
                        <td>

                            <p class="error">
                                <?php echo $titleError; ?>
                            </p>

                        </td>
                        <td><p class="error" id="titleError"></p></td>
                    </tr>




                    <tr>

                        <td class="label">Description</td>

                        <td>
                            <textarea 
                            name="description"
                            id="task-description"
                            class="input-field"
                            ><?php echo $task["description"]; ?></textarea>
                        </td>
                        <td>

                            <p class="error">
                                <?php echo $descriptionError; ?>
                            </p>

                        </td>
                        <td><p class="error" id="descriptionError"></p></td>
                    </tr>




                    <tr>

                        <td class="label">Due Date</td>

                        <td>
                            <input 
                            type="date"
                            name="due_date"
                            id="task-date"
                            class="input-field"
                            value="<?php echo $task["due_date"]; ?>"
                            />
                        </td>
                        <td>

                            <p class="error">
                                <?php echo $dueDateError; ?>
                            </p>

                        </td>
                        <td><p class="error" id="dueDateError"></p></td>
                    </tr>




                    <tr>

                        <td class="label">Assign Team Leader</td>


                        <td>


                        <select 
                        name="assigned_to"
                        id="team-leader"
                        class="input-field"
                        >



                        <?php

                        foreach($teamLeaders as $leader)
                        {

                        ?>


                        <option 
                        value="<?php echo $leader["user_id"]; ?>"
                        
                        <?php
                        
                        if($task["assigned_to"] == $leader["user_id"])
                        {
                            echo "selected";
                        }

                        ?>
                        
                        >

                        <?php echo $leader["full_name"]; ?>

                        </option>



                        <?php

                        }

                        ?>


                        </select>


                        </td>
                        <td>

                            <p class="error">
                                <?php echo $assignedError; ?>
                            </p>

                        </td>
                        <td><p class="error" id="assignedError"></p></td>
                    </tr>




                    <tr>

                        <td></td>

                        <td>

                            <input 
                            type="hidden"
                            name="task_id"
                            value="<?php echo $task["task_id"]; ?>"
                            />


                            <input 
                            type="submit"
                            name="update"
                            value="Update Task"
                            class="submit-button"
                            />

                        </td>


                    </tr>




                </table>


            </fieldset>


        </form>


    </body>

</html>