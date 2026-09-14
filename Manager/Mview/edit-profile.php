<?php

session_start();


$profile = $_SESSION["profile"] ?? [];


$fullNameError = $_SESSION["fullNameError"] ?? "";
$usernameError = $_SESSION["usernameError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";


unset($_SESSION["fullNameError"]);
unset($_SESSION["usernameError"]);
unset($_SESSION["passwordError"]);

?>


<html>

<head>

<link rel="stylesheet" href="style.css">

</head>


<body>


<form 
class="task-form"
action="../Mcontroller/TaskController.php"
method="post"
>


<fieldset class="task-fieldset">


<legend class="form-title">
Edit Profile
</legend>


<table class="task-table">


<tr>

<td class="label">
Full Name
</td>


<td>

<input

type="text"

name="full_name"

class="input-field"

value="<?php echo $profile["full_name"]; ?>"

/>

</td>


<td>

<p class="error">

<?php echo $fullNameError; ?>

</p>

</td>


</tr>



<tr>

<td class="label">
Username
</td>


<td>

<input

type="text"

name="username"

class="input-field"

value="<?php echo $profile["username"]; ?>"

/>

</td>


<td>

<p class="error">

<?php echo $usernameError; ?>

</p>

</td>


</tr>




<tr>

<td class="label">
Password
</td>


<td>

<input

type="password"

name="password"

class="input-field"

/>

</td>


<td>

<p class="error">

<?php echo $passwordError; ?>

</p>

</td>


</tr>




<tr>

<td></td>

<td>


<input

type="submit"

name="updateProfile"

value="Update Profile"

class="submit-button"

/>


</td>


</tr>


</table>


</fieldset>


</form>



</body>

</html>