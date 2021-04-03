<?php
    require_once('database.php');
    session_start();
$currentUser  = $_SESSION['userName'];
    // Get all categories
    $query = 'SELECT * FROM categories
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
<div class="categoryTable">
    <h1>Category List</h1>
    <table class="catList">
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?php echo $category['categoryName']; ?></td>
            <td>
                <form action="delete_category.php" method="post"
                      id="delete_product_form">
                    <input type="hidden" name="category_id"
                           value="<?php echo $category['categoryID']; ?>">
                    <input type="submit" value="-">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <div class="action">
    <h2>Add Category</h2>
    <form action="add_category.php" method="post"
          id="add_category_form">

        <label style="color:white;">Name:</label>
        <input type="input" name="name" id="name" class="name_input" autocomplete="off">
        
        <input id="add_category_button" type="submit" value="+" onclick="checkCategory()" class="addCategory"><br><br>
        <span id="nameErr" style="color:white;"></span>
    </form>
        </div>
    <br>
        </div>
    <?php
include('includes/footer.php');
?>