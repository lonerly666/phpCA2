<?php
require_once('database.php');
session_start();
if($_SESSION['isLoggedIn']==false)
{
    header("Location: index.php");
    exit();
}
$currentUser  = $_SESSION['userName'];
$status = $_SESSION['position'];
$categoryId;

if($_SERVER["REQUEST_METHOD"]==="POST")
{   
    
    $price= trim($_POST['recordPrice']);
    $item = trim($_POST['recordName']);
    array_push($_SESSION['price'],$price);
    if(empty($_SESSION['cart']))
    {
       $_SESSION['cart']+=[$item=>1];
       $_SESSION['productDetails']+=[$item=>$price];
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
        foreach($_SESSION['productDetails'] as $p => $c)
        {
            if($p != $item)
            {
                $_SESSION['productDetails']+=[$item => $price];
            }
        }
    }

    
    $_SESSION['numOfItem']+=1;
}
if (isset($_GET['category_id'])) {
    $_SESSION['category'] = filter_input(INPUT_GET, 'category_id', 
FILTER_VALIDATE_INT);
}



// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE categoryID = :category_id";
$statement1 = $db->prepare($queryCategory); 
$statement1->bindValue(':category_id', $_SESSION['category']);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['categoryName'];

// Get all categories


// Get records for selected category
$queryRecords = "SELECT * FROM records
WHERE categoryID = :category_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $_SESSION['category']);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();

?>



<div class="container" >
<?php
include('includes/header.php');
?>

<h1 id="itemBrand" style="color:black;"><?php echo $category_name; ?></h1>


<?php foreach ($records as $record) : ?>
<div class="productPost">
    <?php if($status==="Admin") { ?>
        <div class="admin">
        <button class="adminBtn">&bull; &bull; &bull;</button>
            <div class="adminEdit">
                    <form action="edit_record_form.php" method="post"
                    id="delete_record_form">
                    <input type="hidden" name="record_id"
                    value="<?php echo $record['recordID']; ?>">
                    <input type="hidden" name="category_id"
                    value="<?php echo $record['categoryID']; ?>">
                    <input type="submit" value="Edit" class="editBtn">
                    </form>
        <form action="delete_record.php" method="post"
            id="delete_record_form">
            <input type="hidden" name="record_id"
            value="<?php echo $record['recordID']; ?>">
            <input type="hidden" name="category_id"
            value="<?php echo $record['categoryID']; ?>">
            <input type="submit" value="Delete" class="editBtn">
            </form>
    </div> 
    </div>
    <?php }; ?>
    

    <div class="image-border">
        <img src="image_uploads/<?php echo $record['image']; ?>" width="100px" height="100px" id="photo"/>
    </div>
    
    <div id="desc">
    <h1>Name</h1>
         <div id="name">    
        <p><?php echo $record['name']; ?></p>
        </div>
         <h1>Price</h1>
         <div id="price">
        <p>€ <?php echo $record['price']; ?></p>
         </div>
    <?php if($_SESSION['position']=="Customer"){ ?>
    <div class="addCart">
    <h1>Add To Cart</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="recordName"
    value="<?php echo $record['name']; ?>">
    <input type="hidden" name="recordPrice" 
    value="<?php echo $record['price']; ?>">
    <button type="submit" class="buyBtn">+</button>
    </form>
    </div>
    <?php }; ?>
    </div>
</div>  
<?php endforeach; ?>
<?php
include('includes/footer.php');
?>

