<?php
require_once('database.php');
session_start();
$errMsg = "";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty(trim($_POST['email'])))
    {
        $errMsg = "Please fill in all fields";
    }
    elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $errMsg= "Invalid email format";
    }
    else
    {
        $email = $_POST['email'];
        $query = "SELECT email FROM users WHERE email = :email";
        $statement = $db -> prepare($query);
        $statement->bindValue(':email', $email);
        $statement -> execute();
        $result = $statement -> fetch();
        if(empty($result))
        {
            $errMsg = "Invalid Email !";
        }
        else
        {
            $myemail = "D00217043@student.dkit.ie";
            $confirm = rand(10000,99999);
            $to = $email;
            $subject = "Confirmation Number";
            $body = "This is your 5 digits number : <br>";
            $body.= $confirm;
            $headers = "From: $myemail\n"; 
            $headers .= "Reply-To: $email";
            mail($to,$subject,$body,$headers);
            $_SESSION['number'] = $confirm;
            $_SESSION['email'] = $email;
            header("Location: confirmNumber.php");
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
			<h1>Please Enter Your Email Address</h1>
			<div class="social-container">
      <?php
      echo $errMsg;
      ?>
			</div>
			<input type="text" placeholder="Email Address" name="email"/>
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

</html> 