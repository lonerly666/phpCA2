<?php
require_once("database.php");
session_start();
$password = "";
$rePassword = "";
$errMsg = "";
$errMsgRP="";
$email  = $_SESSION['email'];
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty(trim($_POST['password']))||empty(trim($_POST['repassword'])))
    {
        $errMsg = "Please fill in all fields";
    }
    else if(htmlspecialchars(trim($_POST['password']))!== htmlspecialchars(trim($_POST['repassword'])))
    {
        $errMsg = "Passwords do not match !";
    }
    else
    {
        $password = htmlspecialchars(trim($_POST['password']));
        $rePassword = htmlspecialchars(trim($_POST['repassword']));
            $hash = password_hash($password, 
             PASSWORD_DEFAULT);
            $query = 'UPDATE users SET password = (:password) WHERE email = :email';
            $statement = $db -> prepare($query);
            $statement -> bindValue(':email',$email);
            $statement -> bindValue(':password',$hash);
            $statement -> execute();
            $statement -> closeCursor();
            header("Location: index.php");
            exit();
    }
}
?>
<html>
<head>
<link rel="stylesheet" type ="text/css" href = "template.css">

</head>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="#">
			<h1>Create Account</h1>
			<div class="social-container">

			</div>
			<input type="text" placeholder="Username" />
			<input type="password" placeholder="Password" />
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<h1>RESET PASSWORD</h1>
			<div class="social-container">
      <?php
      echo $errMsg;
      ?>
			</div>
			<input type="password" placeholder="Password" name="password"  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])([-+=_!@#$%^&*.,;:'\<>/?`~]).{8,12}$" id="password"/>
      <input type="password" placeholder="Confirm Password" name="repassword"/>
			<button>Reset</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
                <h1>Back To Login</h1>
				<p>Already Registered?</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h3>Back To Login</h3>
				<button class="ghost" id="signUp"><a href = "index.php" style="color:white;">Sign In</a></button>
			</div>
		</div>
	</div>
</div>
<div class="centered" id="centered">
<ul>
  <li class="lowercase-char">At least one lowercase character</li>
  <li class="uppercase-char">At least one uppercase character</li>
  <li class="number-char">At least one number</li>
  <li class="special-char">At least one special character [-+=_!@#$%^&*.,;:'\<>/?`~]</li>
  <li class="8-char">At least 8 characters</li>
  <li class="success hide">All Set! Good To Go!</li>
</ul>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"></script>
<script src="register.js"></script>
</html> 