<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>About Us</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="about.css">
        <link rel="stylesheet" href="custom.css">
    	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    </head>
    
    <body>
		<header class="logo-div">
			<div class="logo-div">
				<img src="logo.png">
				<p>SAVE AND SHARE FOOD</p>
            </div>
            <a href="index.php" class="home-link">Home</a>
		</header>
	
    	<section class="main">
		    <h1>Our Misson</h1>
		    <div class="container">
		        <div class="main-content">
		            <h2>Welcome To Save And Share Food.</h2>
		            <p>
						We have developed a Food Waste Management System to
						reduce food wastage and properly dispose off
						leftovers. We provide a platform for people where
		            	they can easily donate any extra food. We collect
						the donated food and distribute it among the people
						who really need it. Not only do we reduce food
						wastes but also facilitate donations to charity by
						different items. We believe nutritious food should
						go to people, and only waste food should be
						disposed off in landfills.
					</p>
					<div id="hidden-para">
						<h2> How we do it.</h2>
						<p> Each user is allowed to submit a form request
						of the food that they wish to donate. The request 
						consists of various details regarding the donator,
						food and its quality. All requests, after being 
						acknowledged by an admin, are sent over to our
						trusted volunteers, who are responsible for 
						collecting all the food items. </p>
					</div>
					
	                <button id="read-button">
						<span id="text">Read More</span>
						<span id="arrow"></span>
					</button>
		        </div>
		        
				<div class="side-image">
					<img src="about.jpg">
				</div>
			</div>
		</section>
		
		<section class="footer">
			<div class="footlinks">
		   	    <h4>Quick Links</h4>
		        <ul>
		  	        <li><a href="index.php">Home</a></li>
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
        </section>
    </body>
	
	<script>
		let moreDiv = document.getElementById("hidden-para");
		let readbtn = document.getElementById("read-button");
		let arrowSpan = document.getElementById("arrow");
		let textSpan = document.getElementById("text");

		readbtn.onclick = function(){
			if (moreDiv.style.opacity == 0) {
				moreDiv.style.height = "auto";
				moreDiv.style.opacity = 1;
				arrowSpan.style.bottom = 0;
				arrowSpan.style.transform = "rotate(225deg)";
				textSpan.innerHTML = "Read Less";
			}
			else {
				moreDiv.style.height = 0;
				moreDiv.style.opacity = 0;
				arrowSpan.style.bottom = "5px";
				arrowSpan.style.transform = "rotate(45deg)";
				textSpan.innerHTML = "Read More";
			}
		}
	</script>
</html> 