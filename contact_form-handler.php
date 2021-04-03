<?php
	$to = $email_address; 
	$email_subject = "Inquiries Form: $name";
	$email_body = "This is a bot mail please do not reply. ".
	" Here are the details:\n Name: $name \n Email: $email_address \n Message \n $message"; 
	
	$headers = "From: $myemail\n"; 
	$headers .= "Reply-To: $email_address";
	
	mail($to,$email_subject,$email_body,$headers);
	//redirect to the 'thank you' page
    echo "<script>
    alert('We will contact you soon,Thanks!');
    window.location.href='home.php';
    </script>";
    exit();
?>