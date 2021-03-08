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
    else
    {
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));
        $rePassword = htmlspecialchars(trim($_POST['repassword']));

        $query = 'SELECT userName FROM users WHERE userName = (:username)';
        $statement = $db -> prepare($query);
        $statement -> bindValue(':username',$username);
        $statement -> execute();
        if($statement-> rowCount()==0)
        {
            $errMsg ="Name do not exist!";
        }
        else
        {
            $query = 'UPDATE users SET password = (:password) WHERE userName = (:username)';
            $statement = $db -> prepare($query);
            $statement -> bindValue(':username',$username);
            $statement -> bindValue(':password',$password);
            $statement -> execute();
            $statement -> closeCursor();
            header("Location: index.php");
            exit();
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
      <h2>RESET PASSWORD</h2>
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
      <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$">
     
     
     
      <br>

      <span class="input-item">
        <i class="fa fa-key"></i>
       </span>
      <!--   Password Input-->
      <input class="form-input" type="password" placeholder="Confirm Password" id="pwd"  name="repassword">
     
     
     
      <br>
<!--        buttons -->
<!--      button LogIn -->
      <button class="log-in" type="submit"> Change Password </button>
</form>
<div style="text-align:center;"><a href="index.php" style="text-decoration:none;">Back To Login</a></div>
   </div>
  

     
<!--   End Container  -->
  </div>
  
  <!-- End Form -->

</div>