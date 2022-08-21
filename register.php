<?php
   require_once ("includes/config.php");
   require_once ("includes/classes/FormSanitizer.php");
   require_once ("includes/classes/Account.php");

   global $dbh;
   $account = new Account($dbh);

   if(isset($_POST['submit'])){

       $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
       $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
       $userName = FormSanitizer::sanitizeFormUsername($_POST['username']);
       $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
       $userEmail = FormSanitizer::sanitizeFormEmail($_POST['email']);
       $confirmEmail = FormSanitizer::sanitizeFormEmail($_POST['confirmEmail']);
       $confirmPassword = FormSanitizer::sanitizeFormPassword($_POST['confirmPassword']);

       $success = $account->registerNewUser($firstName,$lastName,$userName,$userEmail,$confirmEmail,$password,$confirmPassword);
       if($success)
       {
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
                   <h3>Sign Up</h3>
                   <span> to continue to Netflix </span>
               </div>
               <form method="POST">
                   <input type="text" name="firstName" placeholder="First Name" required>
                   <input type="text" name="lastName" placeholder="Last Name" required>
                   <input type="text" name="username" placeholder="Username" required>
                   <input type="email" name="email" placeholder="Email" required>
                   <input type="email" name="confirmEmail" placeholder="Confirm Email" required>
                   <input type="password" name="password" placeholder="Password" required>
                   <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
                   <input type="submit" name="submit" placeholder="Submit" required>
               </form>
               <a href="login.php" class="signInMessage">Already have an account? Sign In here!</a>
           </div>
         </div>
     </body>
</html>