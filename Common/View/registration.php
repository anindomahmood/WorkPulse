<?php

session_start();

$fullNameError = $_SESSION["fullNameError"] ?? "";
$usernameError = $_SESSION["usernameError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";
$roleError = $_SESSION["roleError"] ?? "";

$fullNameValue = $_SESSION["fullName"] ?? "";
$usernameValue = $_SESSION["username"] ?? "";
$roleValue = $_SESSION["role"] ?? "";


unset($_SESSION["fullNameError"]);
unset($_SESSION["usernameError"]);
unset($_SESSION["passwordError"]);
unset($_SESSION["roleError"]);

unset($_SESSION["fullName"]);
unset($_SESSION["username"]);
unset($_SESSION["role"]);

?>


<html>

<head>
    <title>Registration</title>
</head>


<body>


    <form 
        id="registrationForm"
        action="../Controller/RegistrationController.php"
        method="post"
        onsubmit="return validateRegistration()"
    >

        <fieldset>

            <legend>Registration</legend>


            <table class="registration-table">


                <tr>
                    <td>Full Name</td>

                    <td>
                        <input 
                            type="text"
                            id="full_name"
                            name="full_name"
                            class="form-input"
                            value="<?php echo $fullNameValue; ?>"
                        >
                    </td>

                    <td>
                        <p class="error">
                            <?php echo $fullNameError; ?>
                        </p>
                    </td>

                </tr>



                <tr>

                    <td>Username</td>

                    <td>
                        <input 
                            type="text"
                            id="username"
                            name="username"
                            class="form-input"
                            value="<?php echo $usernameValue; ?>"
                        >
                    </td>


                    <td>
                        <p class="error">
                            <?php echo $usernameError; ?>
                        </p>
                    </td>

                </tr>




                <tr>

                    <td>Password</td>

                    <td>
                        <input 
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                        >
                    </td>


                    <td>
                        <p class="error">
                            <?php echo $passwordError; ?>
                        </p>
                    </td>

                </tr>




                <tr>

                    <td>Role</td>

                    <td>

                        <select 
                            id="role"
                            name="role"
                            class="form-input"
                        >

                            <option value="">
                                Select Role
                            </option>


                            <option value="manager"
                            <?php 
                            if($roleValue=="manager")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Manager
                            </option>


                            <option value="team_leader"
                            <?php 
                            if($roleValue=="team_leader")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Team Leader
                            </option>



                            <option value="employee"
                            <?php 
                            if($roleValue=="employee")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Employee
                            </option>


                        </select>

                    </td>


                    <td>
                        <p class="error">
                            <?php echo $roleError; ?>
                        </p>
                    </td>


                </tr>




                <tr>

                    <td></td>

                    <td>
                        <input 
                            type="submit"
                            value="Register"
                            class="submit-button"
                        >
                    </td>

                </tr>


            </table>


        </fieldset>


    </form>



<script src="reg.js"></script>


</body>


</html>