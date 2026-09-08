<?php

session_start();


$task = $_SESSION["editTask"] ?? [];

$teamLeaders = $_SESSION["teamLeaders"] ?? [];


?>


<html>

    <body>


        <form class="task-form" action="../Mcontroller/TaskController.php" method="post">


            <fieldset class="task-fieldset">


                <legend class="form-title">Edit Task</legend>





                <table class="task-table">



                    <tr>

                        <td class="label">Task Title</td>

                        <td>
                            <input 
                            type="text" 
                            name="title"
                            class="input-field"
                            value="<?php echo $task["title"]; ?>"
                            />
                        </td>

                    </tr>




                    <tr>

                        <td class="label">Description</td>

                        <td>
                            <textarea 
                            name="description"
                            class="input-field"
                            ><?php echo $task["description"]; ?></textarea>
                        </td>

                    </tr>




                    <tr>

                        <td class="label">Due Date</td>

                        <td>
                            <input 
                            type="date"
                            name="due_date"
                            class="input-field"
                            value="<?php echo $task["due_date"]; ?>"
                            />
                        </td>

                    </tr>




                    <tr>

                        <td class="label">Assign Team Leader</td>


                        <td>


                        <select 
                        name="assigned_to"
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