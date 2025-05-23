<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Help Us Reduce Food Waste </title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="custom.css">
    	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    </head>
    <body>
		<div class="main-page">
			<nav>
				<div class="logo-div">
					<img src="logo.png">
					<p>SAVE AND SHARE FOOD</p>
				</div>
				
				<ul id="Menu Items">
					<li> <a href="about.php">ABOUT US</a> </li>
					<li> <a href="contact.php">CONTACT US</a> </li>   
					<?php if(isset($_SESSION['user_id'])): ?>
						<li> <a href="profile.php">PROFILE</a> </li>
						<li> <a href="logout.php">LOGOUT</a> </li>
					<?php else: ?>
						<li> <a href="login.php">LOGIN</a> </li>
					<?php endif; ?>
				</ul>
			</nav>
			
			<div class="title">
				<h1>Give away extra food at extra ease</h1>
				<a href="donate.php" class="button">Donate</a>
			</div>
			
			<content>
				<section class="image-section">
					<img src="food-waste.jpg">
					<p>Donating food made easier.</p>
				</section>
				
				<section class="text-section">
					<p>
						Food waste poses a global challenge, with millions
						of tons discarded annually. In developed nations,
						consumer habits, including overbuying and adherence
						to expiration dates, contribute significantly.
						Throughout the supply chain, inefficiencies and
						cosmetic standards lead to further waste. This
						squanders resources like water and energy,
						exacerbating environmental strain. Economically, it
						represents lost investment and revenue. Addressing
						food waste demands education, policy interventions,
						infrastructure improvements, and innovative
						technologies. By collectively acting, we can
						mitigate environmental harm, reduce hunger, and
						foster sustainable food systems for the future.
						
					</p>
				</section>
			</content>
		</div>
		
		<footer>
			<div class="footlinks">
		   	    <h4>Quick Links</h4>
		        <ul>
					<?php if(isset($_SESSION['user_id'])): ?>
						<li><a href="profile.php">Profile</a></li>
					<?php else: ?>
						<li><a href="login.php">Login</a></li>
					<?php endif; ?>
		            <li><a href="donate.php">Donate</a></li>
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
		</footer>
    </body>
</html> 