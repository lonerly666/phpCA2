<?php
session_start();

$total=0;
foreach($_SESSION['price'] as $price)
{
    $total+=$price;
}

?>
<div>
<h1><?php echo $total ?></h1>
</div>