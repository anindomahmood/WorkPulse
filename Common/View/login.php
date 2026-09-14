<?php

session_start();


$usernameError = $_SESSION["usernameError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";

$usernameValue = $_SESSION["username"] ?? "";


unset($_SESSION["usernameError"]);
unset($_SESSION["passwordError"]);
unset($_SESSION["username"]);


?>


<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>


<body class="login-body">


<form 
    action="../Controller/LoginController.php" 
    method="post"
>


<fieldset>

<legend>Login</legend>


<table>


<tr>

<td>Username</td>

<td>
<input 
    type="text"
    name="username"
    class="login-input"
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
    name="password"
    class="login-input"
>
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
    value="Login"
    class="login-button"
>
</td>

</tr>



<tr>

<td></td>

<td>

<p>
Do not have an account?

<a href="registration.php">
Register
</a>

</p>

</td>

</tr>



</table>


</fieldset>


</form>


</body>

</html>
