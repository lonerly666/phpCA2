<?php
session_start();
$status = $_SESSION['position'];
$total=0;
foreach($_SESSION['price'] as $price)
{
    $total+=(int)$price;
}
$prices = array_unique($_SESSION['price']);
$counts  = $_SESSION['numOfItem'];



?>
<link rel="stylesheet" type ="text/css" href = "css/mystyle.css">
<div class="container" >
    <div class="nav-bar">
        <h1>NEON Pen Shop</h1>
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
<div id="checkout">
    <div class="checkoutList">
    <h1>Checkout List</h1>
    <p>You have ordered <?php echo $counts ?> items</p><br>
    <?php foreach($_SESSION['cart'] as $a=> $l): ?>
        <div id="item-list">
           <div id="item-name"><?php echo $a ?></div>
           <div id="quantity">x <?php echo $l ?></div>
        </div>

        <?php endforeach; ?>
    </div>
        

<div class="choice"><br><br>
<div class="totalCost">
        <h1>Total Cost</h1>
        <h3>€ <?php echo $total ?></h3>
        </div><br>
    <a href="home.php">Continue Shopping</a><br><br>
    <?php if($total>0) {?>
    <a href="pay.php">PAY NOW!</a>
    <?php }?>
</div>
</div>
<?php
include('includes/footer.php');
?>