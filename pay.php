<?php

session_start();

unset($_SESSION['cart']);
unset($_SESSION['price']);
$_SESSION['numOfItem']=0;
$_SESSION['cart']=array();
$_SESSION['price']=array();
header("Location: index.php");
exit();

?>