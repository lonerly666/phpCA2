<?php 
require_once("database.php");
$username = "";
$password = "";
$rePassword = "";
$errMsg = "";
$errMsgRP="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty(trim($_POST['username']))||empty(trim($_POST['password']))||empty(trim($_POST['repassword'])))
    {
        $errMsg = "Please fill in all fields";
    }
    else if(htmlspecialchars(trim($_POST['password']))!== htmlspecialchars(trim($_POST['repassword'])))
    {
        $errMsg = "Passwords do not match !";
    }
    elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $errMsg = "Invalid Email Format!";
    }
    else
    {
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));
        $rePassword = htmlspecialchars(trim($_POST['repassword']));
        $email = htmlspecialchars(trim($_POST['email']));
        $query = 'SELECT userName FROM users WHERE userName = (:username)';
        $statement = $db -> prepare($query);
        $statement -> bindValue(':username',$username);
        $statement -> execute();
        if($statement-> rowCount()==1)
        {
            $errMsg ="This name has been taken!";
        }
        else
        {
            $hash = password_hash($password, 
             PASSWORD_DEFAULT);
            $query = 'INSERT INTO users (userName,password,position,email) VALUES (:username,:password,"Customer",:email)';
            $statement = $db -> prepare($query);
            $statement -> bindValue(':username',$username);
            $statement -> bindValue(':password',$hash);
            $statement -> bindValue(':email',$email);
            $statement -> execute();
            $statement -> closeCursor();
            header("Location: index.php");
            exit();
        }
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
			<h1>Sign Up</h1>
			<div class="social-container">
      <?php
      echo $errMsg;
      ?>
			</div>
			<input type="text" placeholder="Username" name="username"/>
            <input type="text" placeholder="Email Address" name="email"/>
			<input type="password" placeholder="Password" name="password"  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" />
      <input type="password" placeholder="Confirm Password" name="repassword"/>
			<button>Sign Up</button>
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

</html> 