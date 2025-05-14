<?php
session_start();
require_once 'config.php';

$success_message = '';
$error_message = '';

// Process donation form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['myname']);
    $email = mysqli_real_escape_string($conn, $_POST['myemail']);
    $phone = mysqli_real_escape_string($conn, $_POST['myphone']);
    $address = mysqli_real_escape_string($conn, $_POST['myaddr']);
    $food_type = mysqli_real_escape_string($conn, $_POST['myfood']);
    $quantity = intval($_POST['quantity']);
    
    // Validate input
    if(empty($name) || empty($email) || empty($phone) || empty($address) || empty($food_type) || $quantity < 1) {
        $error_message = "Please fill in all fields correctly.";
    } else {
        // Get user_id if logged in
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';
        
        // Insert donation into database
        $sql = "INSERT INTO donations (user_id, name, email, phone, address, food_type, quantity) 
                VALUES ($user_id, '$name', '$email', '$phone', '$address', '$food_type', $quantity)";
        
        if (mysqli_query($conn, $sql)) {
            $success_message = "Thank you for your donation! We will contact you soon.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Donate Food</title>
        <meta charset="UTF-8">
    	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <link rel="stylesheet" href="donate.css">
        <link rel="stylesheet" href="custom.css">
    </head>
    
    <body>
		<section class="register-body">
   			<div class="register-form">
        		<h1>Donate food</h1>
                
                <?php if(!empty($success_message)): ?>
                    <div class="success-message"><?php echo $success_message; ?></div>
                <?php endif; ?>
                
                <?php if(!empty($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
        		<form action="" method="POST" onsubmit="return validateform()">
        			<input type="text" name="myname" placeholder="Your Name" id="name" required
                           value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
        			<input type="email" name="myemail" placeholder="Your Email" required
                           value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
        			<input type="tel" name="myphone" placeholder="Your Phone No." id="phonenum" required>
        			<input type="text" name="myaddr" placeholder="Collection Address" required>
        			
        			<h4>Category</h4>
					<div class="option">
						<input type="radio" name="myfood" value="Veg" required>
						<label for="veg">Veg</label>
						<span class="check"></span>
					</div>
					<div class="option">
						<input type="radio" name="myfood" value="NonVeg">
						<label for="nonveg">Non-Veg</label>
						<span class="check"></span>
					</div>
					<div class="option" id="last-option">
						<input type="radio" name="myfood" value="Both"> 
						<label for="both">Both</label>
						<span class="check"></span>
					</div>
        
        			<h4>Quanity (in Kg)</h4>
        			<input type="number" name="quantity" min=1 value=1> <br>
					<div class="option">
						<input type="checkbox" name="t&c" id="terms" required>
						<label for="terms">I accept the Terms &amp; Conditions.</label>
						<span id="box"></span>
					</div>
        			<input type="submit" value="Submit" class="submitbtn">
				</form>
	
    		</div>
		</section>
		
		<section class="footer">
    		<div class="foot">
        		<div class="footer-content">
           		    <div class="footlinks">
                		<h4>Quick Links</h4>
                		<ul>
                    		<li><a href="index.php">Home</a></li>
                    		<li><a href="about.php">About Us</a></li>
                    		<li><a href="contact.php">Contact Us</a></li>
                		</ul>
            		</div>
            		<div class="footlinks">
                		<h4>Connect</h4>
                		<div class="social">
                    		<a href="" target="_blank"><i class='bx bxl-github'></i></a>
                    		<a href="" target="_blank"><i class='bx bxl-instagram' ></i></a>
                    		<a href="" target="_blank"><i class='bx bxl-twitter' ></i></a>
                    		<a href="" target="_blank"><i class='bx bxl-youtube' ></i></a>
                		</div>
            		</div>
        		</div>
    		</div>
    	</section>
	</body>

	<!-- Javascript -->
	<script>
		function validateform() { 
			let name = document.getElementById("name").value;
  		  	let tel = document.getElementById("phonenum").value;

			let regex = /[a-zA-Z]+$/;
			if (!regex.test(name)) {
				alert("Name should only consist of alphabets.");
				return false;
			}

   			if (tel.length < 10) {  
        		alert("Phone number must be of atleast 10 digits.");  
        		return false;  
    		}
			else if (isNaN(tel)) {
        		alert("Phone number should not include characters.");
        		return false;
    		}
    		return true;
		}  
	</script>
</html> 