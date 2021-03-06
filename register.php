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
        if($statement-> rowCount()==1)
        {
            $errMsg ="This name has been taken!";
        }
        else
        {
            $query = 'INSERT INTO users (userName,password,position) VALUES (:username,:password,"Customer")';
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

<div>
<div><h1>REGISTER</h1></div>
<div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label>Username:</label>
<input type="text" name="username"/>
<label>Password:</label>
<input type="password" name="password"/>
<label>Confirm Password</label>
<input type="password" name="repassword"/>
<div><h3><?php echo $errMsg; ?></h3></div>
<button type="submit">Register</button>
</form>
</div>
</div>