<?php

session_start();


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


        <form class="task-form" action="../Mcontroller/TaskController.php" method="post"  onsubmit="return validateCreateTask()">


            <fieldset class="task-fieldset">


                <legend class="form-title">Create Task</legend>

                <table class="task-table">


                    <tr>

                        <td class="label">Task Title</td>

                        <td>
                            <input 
                                type="text" 
                                name="title"
                                class="input-field"
                                id="task-title"
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
                                class="input-field"
                                id="task-description"
                            ></textarea>
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
                                class="input-field"
                                id="task-date"
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
                                class="input-field"
                                id="team-leader"
                            >


                            <option value="">
                                Select Team Leader
                            </option>



                            <?php

                            foreach($teamLeaders as $leader)
                            {

                            ?>


                            <option value="<?php echo $leader["user_id"];?>">

                                <?php echo $leader["full_name"];?>

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
                                type="submit" 
                                value="Create Task"
                                class="submit-button"
                                id="create-task-button"
                            />
                        </td>

                    </tr>



                </table>


            </fieldset>


        </form>


    </body>

</html>