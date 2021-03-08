<!-- the head section -->
<?php
$currentUser = $_SESSION['userName'];

?>

<head>
<title>My Pen Shop</title>  
<link rel="stylesheet" type ="text/css" href = "css/mystyle.css">
</head>
<html>
<body>
<div class="title-head">
<div class="welcome" >HI, <?php echo $currentUser; ?>
<form action="logout.php" method="post"><br>
<button type="submit" id="logout">logout</button>
</form>
</div>
<h1>NEON Pen Shop</h1>

</div>