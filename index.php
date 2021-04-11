<?php

require_once('database.php');
session_start();
if(isset($_SESSION['isLoggedIn'])&&$_SESSION['isLoggedIn']===true)
{
    
    header("Location: home.php");
    exit();
}
$position = "";
$username = "";
$password="";
$errMsgP="";
$errMsgN="";
$errMsg="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(empty(trim($_POST['username']))||empty(trim($_POST['password'])))
        {
            $errMsg = "Please Fill In All Fields!";
        }
        else
        {
            $username = htmlspecialchars(trim($_POST['username']));
            $password = htmlspecialchars(trim($_POST['password']));
            $query = "SELECT userID,userName,password,position FROM users WHERE userName = (:username)";
            $statement = $db -> prepare($query);
            $statement -> bindValue(':username',$username);
            $statement -> execute();
            $userInfo = $statement -> fetch();
            $statement ->closeCursor();
            if(empty($userInfo))
            {
                $errMsg = "You have not registered yet!";
            }
            else
            {
                if($userInfo['password']===$password)
                {
                    session_start();
                    $_SESSION['isLoggedIn']=true;
                    $_SESSION['userID'] = $userInfo['userID'];
                    $_SESSION['userName'] = $username;
                    $_SESSION['position'] = $userInfo['position'];
                    $_SESSION['cart']=array();
                    $_SESSION['price']=array();
                    $_SESSION['productDetails'] = array();
                    $_SESSION['numOfItem']=0;
                    $_SESSION['category']=1;
                    header("Location: home.php");
                    exit();
                }
                else
                {
                    $errMsg = "Wrong credentials!";
                }
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<h1>CREATE ACCOUNT</h1>
			<div class="social-container" id="signUpErr">
            <?php
            echo $errMsg;
            ?>
			</div>
			<input type="text" placeholder="Username" name ="username"/>
			<input type="password" placeholder="Password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" />
            <input type="password" placeholder="Confirm Password" name="repassword"/>
			<button name="signUp">Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<h1>SIGN IN</h1>
			<div class="social-container">
            <?php
            echo $errMsg;
            ?>
			</div>
			<input type="text" placeholder="Username" name="username"/>
			<input type="password" placeholder="Password" name="password"/>
			<a href="forgotPass.php">Forgot your password?</a>
			<button name="signIn">Sign In</button>
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
				<h1>Hello, Friend!</h1>
				<p>Haven't Registered Yet?</p>
				<button class="ghost" id="signUp"><a href="register.php" style="color:white;">Sign Up</a></button>
			</div>
		</div>
	</div>
</div>
</html> 
