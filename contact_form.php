<?php 
require_once('database.php');
session_start();
$status = $_SESSION['position'];
$errors = '';
if($_SERVER["REQUEST_METHOD"]==="POST")
{ 
    $myemail = 'D00217043@student.dkit.ie';//<-----Put your DkIT email address here.
    
    if(empty($_POST['name'])  || 
    empty($_POST['email']) || 
    empty($_POST['message']))
    {
        $errors = "\n All fields are required";
    }
    else
    {
    $name = $_POST['name']; 
    $email_address = $_POST['email']; 
    $message = $_POST['message']; 

    if (!preg_match(
    "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", 
    $email_address))
    {
        $errors = "\n Invalid email address";
    }
    if(empty($errors))
    {
        $to = $email_address; 
        $email_subject = "Inquiries Form: $name";
        $email_body = "This is a bot mail please do not reply. ".
        " Here are the details:\n Name: $name \n Email: $email_address \n Message \n $message"; 
        
        $headers = "From: $myemail\n"; 
        $headers .= "Reply-To: $email_address";
        
        mail($to,$email_subject,$email_body,$headers);//send to users to confirm

        $subject = "Inquiry from $name";
        $content = "Message: $message";
        $head = "From : $email_address";
        $head .="Reply-To: $myemail";
        mail($myemail,$subject,$content,$head);
        header('Location: home.php');
        exit();
    }
}
}
?>
<link rel="stylesheet" type ="text/css" href = "css/mystyle.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">
    <div class="nav-bar">   
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
    <div class="contact-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="toggleAlert()">
    <h1>INQUIRIES</h1>
        <div class="details">
        <h2 id="err"><?php echo $errors;  ?></h2>
        <div class="detail-input">
        <label for='name'>Your Name:</label> <br>
        <input type="text" name="name" class="inputDet" id="name">
        </div>
        <div class="detail-input"> 
        <label for='email'>Email Address:</label> <br>
        <input type="text" name="email" class="inputDet" id="email" style="width:300px;color:white;"> <br>
        </div>
        <div class="detail-input"> 
        <label for='message'>Message:</label> <br>
        <textarea name="message" class="inputDet" id="msg"></textarea>
        </div>
        <input type="submit" value="Submit" class = "submitContact"><br>
    </form>
    </div>
 </div>
 <script>
 function toggleAlert()
 {
     const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     let name = document.getElementById("name").value;
     let email = document.getElementById("email").value;
     let message = document.getElementById("msg").value;
     if(name===""||email===""||message==="")
     {
         document.getElementById("err").innerHTML = "Please fill in all fields";
         event.preventDefault();
     }
     else if(re.test(email))
     {
     alert("Thank you! We will contact you soon.");
     }
 }
 </script>
    <?php
    include('includes/footer.php');
    ?>