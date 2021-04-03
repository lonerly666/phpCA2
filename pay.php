<?php

session_start();

unset($_SESSION['cart']);
unset($_SESSION['price']);
$_SESSION['numOfItem']=0;
$_SESSION['cart']=array();
$_SESSION['price']=array();

?>
<html>
    <head>
    <meta http-equiv = "refresh" content="3; url= home.php">
    </head>
    <div style="text-align:center; background:pink; height:100vh; padding:0; margin:0;  ">
        <h1>
          Thanks for buying from us <br>
          Please shop with us again!
        </h1>
    </div>
</html>