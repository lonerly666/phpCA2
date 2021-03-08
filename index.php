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
        $errMsgP=" Invalid Input! ";
        $errMsgN=" Invalid Input! ";
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
                $_SESSION['numOfItem']=0;
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

<link rel="stylesheet" type ="text/css" href = "template.css">
<div class="overlay">
<!-- LOGN IN FORM by Omar Dsoky -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
   <!--   con = Container  for items in the form-->
   <div class="con">
   <!--     Start  header Content  -->
   <header class="head-form">
      <h2>Log In</h2>
      <!--     A welcome message or an explanation of the login form -->
      <p>login here using your username and password</p>
   </header>
   <!--     End  header Content  -->
   <br>
   <div><h3><?php echo $errMsg; ?></h3></div>
   <div class="field-set">
      <!--   user name -->
         <span class="input-item">
           <i class="fa fa-user-circle"></i>
         </span>
        <!--   user name Input-->
         <input class="form-input" id="txt-input" type="text" placeholder="@UserName" name="username">
     
      <br>
     
           <!--   Password -->
     
      <span class="input-item">
        <i class="fa fa-key"></i>
       </span>
      <!--   Password Input-->
      <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password" name="password">
     
     
     
      <br>
<!--        buttons -->
<!--      button LogIn -->
      <button class="log-in" type="submit"> Log In </button>
</form>
   </div>
  
<!--   other buttons -->
   <div class="other">
<!--      Forgot Password button-->
      <button class="btn submits frgt-pass"><a href="forgotPass.php" style="text-decoration:none;color:black">Forgot Password</a></button>
<!--     Sign Up button -->
    <button class="btn submits sign-up" onClick="window.location='register.php';" ><a href="register.php" style="text-decoration:none;color:black">Sign Up</a>
<!--         Sign Up font icon -->
      <i class="fa fa-user-plus" aria-hidden="true"></i>
      </button>
<!--      End Other the Division -->
   </div>
     
<!--   End Conrainer  -->
  </div>
  
  <!-- End Form -->

</div>
 
