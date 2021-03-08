<?php
session_start();

$total=0;
foreach($_SESSION['price'] as $price)
{
    $total+=$price;
}
$prices = array_unique($_SESSION['price']);
$counts  = $_SESSION['numOfItem'];



?>
<div class="container" >
<?php
include('includes/header.php');
?>
<div id="checkout">
    <h1>Checkout List</h1>
    <p>You have ordered <?php echo $counts ?> items</p>
    <?php foreach($_SESSION['cart'] as $a=> $l): ?>
        <div id="item-list">
           <div id="item-name"><?php echo $a ?></div>
           <div id="quantity">x <?php echo $l ?></div>
        </div>

        <?php endforeach; ?>

        <div class="totalCost">
        <h1>Total Cost</h1>
        <h3><?php echo $total ?></h3>
        </div>
</div>
<div class="choice"><br><br>
    <a href="home.php">Continue Shopping</a><br><br><br>
    <?php if($total>0) {?>
    <a href="pay.php">PAY NOW!</a>
    <?php }?>
</div>
<?php
include('includes/footer.php');
?>
</div>