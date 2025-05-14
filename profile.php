<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if user is admin or agent - redirect to appropriate page
if($_SESSION['user_type'] == 'admin') {
    header("Location: admin/dashboard.php");
    exit;
} elseif($_SESSION['user_type'] == 'agent') {
    header("Location: agent.php");
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Get user's donation history
$sql = "SELECT * FROM donations WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
	<head>
        <title>User Profile</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="agent.css">
        <link rel="stylesheet" href="custom.css">
    	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
	</head>
	<body>
		<header>
			<img src="logo.png">
			<p>SAVE AND SHARE FOOD</p>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="donate.php">Donate</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
		</header>
		
		<div class="main-body">
			<aside class="menu">
				<ul>
					<li>
					<button type="button" class="menu-button selected" id="detailsbtn">
						PROFILE INFO
					</button>
					</li>
					
					<li>
					<button type="button" class="menu-button" id="dashbrdbtn">
						MY DONATIONS
					</button>
					</li>
				</ul>
			</aside>

			<content>
				<div class="profile" id="profileDiv">
					<div class="details">
						<h1><?php echo $username; ?></h1>
						<p>Registered User</p>
						
						<h2>User ID</h2>
						<p><?php echo $user_id; ?></p>
						
						<h2>Email Address</h2> 
						<p><?php echo $email; ?></p>
                        
                        <a href="donate.php" class="donate-btn">Make a Donation</a>
					</div>
					<div class="picture">
						<img src="profile.png">
					</div>
				</div>
				
				<div class="dashboard" id="dashbrdDiv">
					<?php if(mysqli_num_rows($result) > 0): ?>
						<h2>My Donation History</h2>
						<table class="donation-table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Food Type</th>
									<th>Quantity</th>
									<th>Address</th>
									<th>Status</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php while($row = mysqli_fetch_assoc($result)): ?>
									<tr>
										<td><?php echo $row['id']; ?></td>
										<td><?php echo $row['food_type']; ?></td>
										<td><?php echo $row['quantity']; ?> kg</td>
										<td><?php echo $row['address']; ?></td>
										<td>
                                            <span class="status-<?php echo $row['status']; ?>">
                                                <?php echo ucfirst($row['status']); ?>
                                            </span>
                                        </td>
										<td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					<?php else: ?>
						<p>You haven't made any donations yet. <a href="donate.php">Make your first donation</a></p>
					<?php endif; ?>
				</div>
			</content>
		</div>
		
		<footer>
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
	    	    	<a href="" target="_blank"><i class="bx bxl-github"></i></a>
	    	        <a href="" target="_blank"><i class="bx bxl-instagram" ></i></a>
	                <a href="" target="_blank"><i class="bx bxl-twitter" ></i></a>
	                <a href="" target="_blank"><i class="bx bxl-youtube" ></i></a>
	            </div>
	    	</div>
		</footer>
	</body>
	
	<script>
		let detailsbtn = document.getElementById('detailsbtn');
		let dashbrdbtn = document.getElementById('dashbrdbtn');
		let profileDiv = document.getElementById('profileDiv');
		let dashbrdDiv = document.getElementById('dashbrdDiv');
		
		detailsbtn.onclick = function() {
			if (detailsbtn.classList.contains('selected')) {
				return
			}
			dashbrdbtn.classList.remove('selected');
			detailsbtn.classList.add('selected');
			
			dashbrdDiv.style.display = 'none';
			profileDiv.style.display = 'flex';
		}
		
		dashbrdbtn.onclick = function() {
			if (dashbrdbtn.classList.contains('selected')) {
				return
			}
			detailsbtn.classList.remove('selected');
			dashbrdbtn.classList.add('selected');
			
			profileDiv.style.display = 'none';
			dashbrdDiv.style.display = 'flex';
		}
	</script>
</html> 