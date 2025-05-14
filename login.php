<?php
session_start();
require_once 'config.php';

// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

$error = '';

// Process login form
if(isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = mysqli_real_escape_string($conn, $_POST['useremail']);
    $password = $_POST['userpwd'];
    
    // Validate input
    if(empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        // Check if email exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify password
            if(password_verify($password, $user['password'])) {
                // Password is correct, create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                
                // Redirect based on user type
                if($user['user_type'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } elseif($user['user_type'] == 'agent') {
                    header("Location: agent.php");
                } else {
                    header("Location: profile.php");
                }
                exit;
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
        }
    }
}

// Process registration form
if(isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['useremail']);
    $password = $_POST['userpwd'];
    $confirm_password = $_POST['confirmpwd'];
    
    // Validate input
    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill in all fields";
    } elseif($password != $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            $error = "Email already exists";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            
            if(mysqli_query($conn, $sql)) {
                // Registration successful, auto-login
                $user_id = mysqli_insert_id($conn);
                
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = 'user';
                
                header("Location: profile.php");
                exit;
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>Login</title>
        <meta name="viewpoint" content="width=device-width, initial-scale=1.0" >
        <link rel="stylesheet" href="login.css">
        <link rel="stylesheet" href="custom.css">
    </head>
    
    <body>
        <div class="form-box">
            <h1 id="title">Register</h1>
            <?php if(!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" onsubmit="return verifyPassword()">
                <div class="input-group">
                    <input type="text" name="username" class="input-field" id="nameField" placeholder="Name" required>
                    <input type="email" name="useremail" class="input-field" placeholder="Email" required>
                   	<input type="password" name="userpwd" class="input-field" id="passField" placeholder="Password" required>
                   	<input type="password" name="confirmpwd" class="input-field" id="confirmPass" placeholder="Confirm Password" required>
                </div>
                
                <div class="button-group">
                    <button type="submit" id="registerbtn" name="action" value="register">
						<span id="regMain">Register</span>
						<span id="regLink" class="link-text"></span>
					</button>
					<br>
                    <button type="button" id="signinbtn" class="disable" onclick="toggleForm()">
						<span id="signMain">Already have an account?</span>
						<span id="signLink" class="link-text">Sign In</span>
					</button>
                </div>
            </form>
        </div>    
    </body>
    
    <script>
		let title = document.getElementById("title");
		let nameField = document.getElementById("nameField");
		let passField = document.getElementById("passField");
		let confirmPass = document.getElementById("confirmPass");
		
		let regMain = document.getElementById("regMain");
		let regLink = document.getElementById("regLink");
		let signMain = document.getElementById("signMain");
		let signLink = document.getElementById("signLink");
		
		let registerbtn = document.getElementById("registerbtn");
		let signinbtn = document.getElementById("signinbtn");
        
        let isLoginForm = false;

        function toggleForm() {
            isLoginForm = !isLoginForm;
            
            if(isLoginForm) {
                title.innerHTML = "Sign In";
                nameField.style.display = "none";
                confirmPass.style.display = "none";
                nameField.required = false;
                confirmPass.required = false;
                
                regMain.innerHTML = "Don't have an account?";
                regLink.innerHTML = "Register";
                signMain.innerHTML = "Sign In";
                signLink.innerHTML = "";
                
                registerbtn.classList.add("disable");
                signinbtn.classList.remove("disable");
                
                registerbtn.type = "button";
                signinbtn.type = "submit";
                signinbtn.name = "action";
                signinbtn.value = "login";
                registerbtn.removeAttribute("name");
                registerbtn.removeAttribute("value");
                registerbtn.setAttribute("onclick", "toggleForm()");
            } else {
                title.innerHTML = "Register";
                nameField.style.display = "flex";
                confirmPass.style.display = "flex";
                nameField.required = true;
                confirmPass.required = true;
                
                regMain.innerHTML = "Register";
                regLink.innerHTML = "";
                signMain.innerHTML = "Already have an account?";
                signLink.innerHTML = "Sign in";
                
                registerbtn.classList.remove("disable");
                signinbtn.classList.add("disable");
                
                registerbtn.type = "submit";
                signinbtn.type = "button";
                registerbtn.name = "action";
                registerbtn.value = "register";
                signinbtn.removeAttribute("name");
                signinbtn.removeAttribute("value");
                registerbtn.removeAttribute("onclick");
            }
        }
		
		function verifyPassword() {
			if (!isLoginForm && passField.value != confirmPass.value) {
				alert("Passwords don't match, please try again.")
				return false;
			}
            return true;
		}
	</script>
</html> 