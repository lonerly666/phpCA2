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
?>
<!-- the head section -->
 <div class="container">
<?php
include('includes/header.php');
?>
    <script src="addRecordValidation.js"></script>
    <div class="recordDiv">
        <h1>Add Record</h1>
        <form action="add_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">
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
            <input type="input" name="name" id="name" class="recN">
            <br>
            <span id="nameErr"></span>
            </div>
            <br>
            <div class="recDet">
            <br><label>List Price</label><br>
            <input type="input" name="price" id="price" pattern="[0-9]{1,5}" class="recN">
            <br>
            <span id="priceErr"></span>
            </div>
            <br>        
            <div class="recDet">
            <br><label>Image</label><br>
            <input type="file" name="image" accept="image/*" / class="imageUp">
            <br>
            </div>
            <label>&nbsp;</label><br>
            <input type="submit" value="+" onclick="checkValidation()" id="addR">
            <br>
            </div>
            </div>
        </form>
    <?php
include('includes/footer.php');
?>