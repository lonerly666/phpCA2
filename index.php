<?php
require_once('database.php');
session_start();
if($_SESSION['isLoggedIn']===true)
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

<div>
    <div>
    <h1>LOGIN</h1>
    </div>
    <div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label class="login-form">Username</label>
    <input type="text" id="username" name="username"/>
    <span class="errMsg">
    <?php echo $errMsgN; ?>
    </span>
    <label class="login-form">Password</label>
    <input type="password" id="password" name="password"/>
    <span>
    <?php echo $errMsgP; ?>
    </span>
    <button type="submit">Login</button>
    <span><?php echo $errMsg ?></span>
    </form>
    <p>Haven't Registered Yet? Click <a href="register.php">here</a></p>
    </div>

</div>  
