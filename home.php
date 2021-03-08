<?php
require_once('database.php');
session_start();

$currentUser  = $_SESSION['userName'];
$status = $_SESSION['position'];


if($_SERVER["REQUEST_METHOD"]==="POST")
{   
    
    $price= trim($_POST['recordPrice']);
    $item = trim($_POST['recordName']);
    array_push($_SESSION['price'],$price);
    if(empty($_SESSION['cart']))
    {
       $_SESSION['cart']+=[$item=>1];
    }
    else
    {
        foreach($_SESSION['cart'] as $a=>$f)
        {
            if($a==$item)
            {
                $_SESSION['cart'][$item]++;
            }
            else
            {
                $_SESSION['cart']+=[$item=>1];
            }
        }
    }

    
    $_SESSION['numOfItem']+=1;
}




// Get category ID
if (!isset($category_id)) {
$category_id = filter_input(INPUT_GET, 'category_id', 
FILTER_VALIDATE_INT);
if ($category_id == NULL || $category_id == FALSE) {
$category_id = 1;
}
}

// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE categoryID = :category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['categoryName'];

// Get all categories
$queryAllCategories = 'SELECT * FROM categories
ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

// Get records for selected category
$queryRecords = "SELECT * FROM records
WHERE categoryID = :category_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();

?>



<div class="container" >
<?php
include('includes/header.php');
?>

<aside>
<!-- display a list of categories -->
<label id="labels">Categories</label><br>
<form>
<select name='category_id'>
<?php foreach ($categories as $category) : ?>

<option value="<?php echo $category['categoryID'] ?>">
<?php echo $category['categoryName']; ?>
</option>

<?php endforeach; ?>
</select>

<input type="submit" id="filter"/>
</form>
</aside>

<section>
<!-- display a table of records -->
<h2 id="itemBrand"><?php echo $category_name; ?></h2>
<div id="lists">
<?php foreach ($records as $record) : ?>

<div id="items">
    <div id="image-border">
        <img src="image_uploads/<?php echo $record['image']; ?>" width="100px" height="100px" id="photo"/>
    </div>
    <div id="desc">
    <h1>Name</h1>
         <div id="name">
             
         <?php echo $record['name']; ?>
         </div><br>
         <h1>Price</h1>
         <div id="price">
             
         <?php echo $record['price']; ?>
         </div>
    </div>
    
    <div class="buttons addCart">
    <h1>Add To Cart</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="recordName"
    value="<?php echo $record['name']; ?>">
    <input type="hidden" name="recordPrice"
    value="<?php echo $record['price']; ?>">
    <button type="submit">+</button>
    </form>
    </div>
    
    <?php if($status==="Admin"){ ?>
        <div id="adminBut">
    <div class="buttons delete">
        <form action="delete_record.php" method="post"
        id="delete_record_form">
        <input type="hidden" name="record_id"
        value="<?php echo $record['recordID']; ?>">
        <input type="hidden" name="category_id"
        value="<?php echo $record['categoryID']; ?>">
        <input type="submit" value="Delete">
        </form>
    </div>

    <div class="buttons edit">
        <form action="edit_record_form.php" method="post"
        id="delete_record_form">
        <input type="hidden" name="record_id"
        value="<?php echo $record['recordID']; ?>">
        <input type="hidden" name="category_id"
        value="<?php echo $record['categoryID']; ?>">
        <input type="submit" value="Edit">
        </form>
        </div>
    </div>
    <?php } ?>
</div>




<?php endforeach; ?>
    </div>
<?php  if($status==="Admin"){ ?>
<div class="manager">
<p><a href="add_record_form.php">Add Record</a></p>
<p><a href="category_list.php">Manage Categories</a></p>
</div>
<?php };?>
</section>
<div class="checkout">
<form action="checkout.php" method="post">
<button type="submit">checkout</button>
<span class="numOfItem"><?php echo $_SESSION['numOfItem'] ?></span>
</form>
</div>
<?php
include('includes/footer.php');
?>

