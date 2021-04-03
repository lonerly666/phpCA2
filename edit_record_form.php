<?php
require('database.php');
session_start();
$currentUser  = $_SESSION['userName'];
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM records
          WHERE recordID = :record_id';
$statement = $db->prepare($query);
$statement->bindValue(':record_id', $record_id);
$statement->execute();
$records = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>
<!-- the head section -->
 <div class="container">
<?php
include('includes/header.php');
?>
<script src="addRecordValidation.js"></script>
<div class="recordDiv">
        <h1 style="color:white;">Edit Product</h1>
        <form action="edit_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">
            <input type="hidden" name="original_image" value="<?php echo $records['image']; ?>" />
            <input type="hidden" name="record_id"
                   value="<?php echo $records['recordID']; ?>">
            <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <br>
            <div class="recordAction">
            <div class="recDet">
            <label>Name</label><br>
            <input type="input" name="name" id="name"
                   value="<?php echo $records['name']; ?>" class="recN">
                   <span id="nameErr"></span>
            </div>
            <br>
            <div class="recDet">
            <br><label>List Price</label><br>
            <input type="input" name="price" id="price" pattern="[0-9]{1,5}"
                   value="<?php echo $records['price']; ?>" class="recN">
                   <span id="priceErr"></span>
            </div>
            <br>
            <br>
            <div class="recDet">
            <label>Image</label><br>
            <input type="file" name="image" accept="image/*" />
            <br>            
            <?php if ($records['image'] != "") { ?>
            <p><img src="image_uploads/<?php echo $records['image']; ?>" height="150" /></p>
            </div>
            <?php } ?>
            
            <label>&nbsp;</label>
            <input type="submit" value="Save" onclick="checkValidation()" id="saveChange">
            <br>
        </form>
            </div>
            </div>
    <?php
include('includes/footer.php');
?>