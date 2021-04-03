<!-- the head section -->
<?php
$currentUser = $_SESSION['userName'];
$status = $_SESSION['position'];






$queryAllCategories = 'SELECT * FROM categories
ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();
?>



<head>
<title>My Pen Shop</title>  
<link rel="stylesheet" type ="text/css" href = "css/mystyle.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<html>
<body>
<div class="nav-bar">
<div class="dropdown">
  <form action = "" >
    <button class="dropbtn">Categories</button>
    <div class="dropdown-content">
    <?php foreach ($categories as $category) : ?>
    <button type="submit" value="<?php echo $category['categoryID'];?>" name="category_id">
    <?php echo $category['categoryName']; ?></button>
    <?php endforeach; ?>
    </div> 
    </form>
  </div>
    <h1>NEON Pen Shop</h1>
    <div class="cartDiv">
    <form action="checkout.php" method="post">
    <button class="fa fa-shopping-cart" id="cart"></button>
    <?php if($_SESSION['numOfItem']>0){ ?>
    <div class="numOfItems"><p><?php echo $_SESSION['numOfItem']?></p></div>
    <?php }; ?>
    </form> 
    </div>
    <div class="r_header">
 <input class="menu-btn" type="checkbox" id="menu-btn" />
  <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
  <ul class="dropdown-content">
    <li><a href="home.php">Home</a></li><br />
    <li><a href="contact_form.php">Contact Us</a></li><br />
    <?php if($status==="Admin"){ ?>
    <li><a href="category_list.php">Manage Categories</a></li><br />
    <li><a href="add_record_form.php">Add Records</a></li><br />
    <?php }; ?>
    <li><a href="logout.php">Logout</a></li><br />
  </ul>
</div>

</div>