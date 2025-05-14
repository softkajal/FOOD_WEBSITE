<?php
session_start();
require_once 'config.php';

$success_message = '';
$error_message = '';

// Process contact form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Validate input
    if(empty($name) || empty($email) || empty($message)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Insert message into database
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        
        if (mysqli_query($conn, $sql)) {
            $success_message = "Thank you for your message! We will get back to you soon.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Contact Us</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="contact.css">
        <link rel="stylesheet" href="custom.css">
    </head>
    
    <body>
        <div class="container">
            <form action="" method="POST" class="form">
                 <h2>Get in touch</h2>
                 <hr>  
                 
                 <?php if(!empty($success_message)): ?>
                    <div class="success-message"><?php echo $success_message; ?></div>
                 <?php endif; ?>
                
                 <?php if(!empty($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                 <?php endif; ?>
                 
                 <input type="text" name="name" placeholder="Your Name" class="inputs" required
                        value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
                 <input type="email" name="email" placeholder="Your Email" class="inputs" required
                        value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
                 <textarea name="message" placeholder="Your Message" class="inputs" required></textarea>
                 <button type="submit"> Submit <img src="arrow_icon.png" alt=""></button>
			</form>
            <div class="contact-right">
               <img src="right_img.png" alt="">
            </div>
        </div>
    </body>
</html> 