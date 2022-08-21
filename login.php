<?php
require_once ("includes/config.php");
require_once ("includes/classes/FormSanitizer.php");
require_once ("includes/classes/Account.php");

global $dbh;
$account = new Account($dbh);

if(isset($_POST['submit'])){
    $userName = FormSanitizer::sanitizeFormEmail($_POST['username']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
    $success = $account->login($userName,$password);
    if($success){
        $_SESSION['userLoggedIn'] = $userName;
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Welcome to Netflix Clone </title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
</head>
<body>
<div class="signInContainer">
    <div class="column">

        <div class="header">
            <img src="assets/images/logo.png">
            <h3>Sign In</h3>
            <span> to continue to Netflix </span>
        </div>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submit" placeholder="Submit" required>
        </form>
        <a href="register.php" class="signInMessage"> New an account? Sign Up here!</a>
    </div>
</div>
</body>
</html>