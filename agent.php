<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is an agent
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'agent') {
    header("Location: login.php");
    exit;
}

// Get agent information
$agent_id = $_SESSION['user_id'];
$agent_name = $_SESSION['username'];
$agent_email = $_SESSION['email'];

// Get agent's assigned donations
$sql = "SELECT * FROM donations WHERE agent_id = $agent_id OR agent_id IS NULL ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
	<head>
        <title> Agent Dashboard </title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='agent.css'>
        <link rel='stylesheet' href='custom.css'>
    	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
	</head>
	<body>
		<header>
			<img src='logo.png'>
			<p>SAVE AND SHARE FOOD</p>
		</header>
		
		<div class='main-body'>
			<aside class='menu'>
				<ul>
					<li>
					<button type='button' class='menu-button selected' id='detailsbtn'>
						PERSONAL INFO
					</button>
					</li>
					
					<li>
					<button type='button' class='menu-button' id='dashbrdbtn'>
						DASHBOARD
					</button>
					</li>
				</ul>
			</aside>

			<content>
				<div class='profile' id='profileDiv'>
					<div class='details'>
						<h1><?php echo $agent_name; ?></h1>
						<p>Trusted Agent</p>
						
						<h2> Account ID </h2>
						<p><?php echo $agent_id; ?></p>
						
						<h2> Email Address </h2> 
						<p><?php echo $agent_email; ?></p>
					</div>
					<div class='picture'>
						<img src='profile.png'>
					</div>
				</div>
				
				<div class='dashboard' id='dashbrdDiv'>
					<?php if(mysqli_num_rows($result) > 0): ?>
						<h2>Donation Requests</h2>
						<table class="donation-table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Food Type</th>
									<th>Quantity</th>
									<th>Address</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php while($row = mysqli_fetch_assoc($result)): ?>
									<tr>
										<td><?php echo $row['id']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['food_type']; ?></td>
										<td><?php echo $row['quantity']; ?> kg</td>
										<td><?php echo $row['address']; ?></td>
										<td><?php echo $row['status']; ?></td>
										<td>
											<?php if($row['status'] == 'pending' && $row['agent_id'] === NULL): ?>
												<form method="POST" action="process_donation.php">
													<input type="hidden" name="donation_id" value="<?php echo $row['id']; ?>">
													<input type="hidden" name="action" value="assign">
													<button type="submit" class="action-btn">Assign to Me</button>
												</form>
											<?php elseif($row['status'] == 'approved' && $row['agent_id'] == $agent_id): ?>
												<form method="POST" action="process_donation.php">
													<input type="hidden" name="donation_id" value="<?php echo $row['id']; ?>">
													<input type="hidden" name="action" value="complete">
													<button type="submit" class="action-btn">Mark as Completed</button>
												</form>
											<?php else: ?>
												-
											<?php endif; ?>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					<?php else: ?>
						<p> There are no donation requests yet </p>
					<?php endif; ?>
				</div>
			</content>
		</div>
		
		<footer>
			<div class='footlinks'>
		   	    <h4>Quick Links</h4>
		        <ul>
		  	        <li><a href='index.php'>Home</a></li>
		            <li><a href='donate.php'>Donate</a></li>
		            <li><a href='contact.php'>Contact Us</a></li>
		   		</ul>
			</div>
	
	        <div class='footlinks'>
	    	    <h4>Connect</h4>
	    	    <div class='social'>
	    	    	<a href='' target='_blank'><i class='bx bxl-github'></i></a>
	    	        <a href='' target='_blank'><i class='bx bxl-instagram' ></i></a>
	                <a href='' target='_blank'><i class='bx bxl-twitter' ></i></a>
	                <a href='' target='_blank'><i class='bx bxl-youtube' ></i></a>
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