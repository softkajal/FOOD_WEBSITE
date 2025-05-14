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

// Process donation actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['donation_id']) && isset($_POST['action'])) {
    $donation_id = intval($_POST['donation_id']);
    $action = $_POST['action'];
    
    // Verify donation exists
    $check_sql = "SELECT * FROM donations WHERE id = $donation_id";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) == 1) {
        $donation = mysqli_fetch_assoc($check_result);
        
        // Process based on action
        if ($action == 'assign' && $donation['status'] == 'pending' && $donation['agent_id'] === NULL) {
            // Assign donation to agent and update status
            $update_sql = "UPDATE donations SET agent_id = $agent_id, status = 'approved' WHERE id = $donation_id";
            
            if (mysqli_query($conn, $update_sql)) {
                header("Location: agent.php?msg=assigned");
                exit;
            } else {
                header("Location: agent.php?error=db_error");
                exit;
            }
        } elseif ($action == 'complete' && $donation['status'] == 'approved' && $donation['agent_id'] == $agent_id) {
            // Mark donation as completed
            $update_sql = "UPDATE donations SET status = 'completed' WHERE id = $donation_id";
            
            if (mysqli_query($conn, $update_sql)) {
                header("Location: agent.php?msg=completed");
                exit;
            } else {
                header("Location: agent.php?error=db_error");
                exit;
            }
        } else {
            header("Location: agent.php?error=invalid_action");
            exit;
        }
    } else {
        header("Location: agent.php?error=not_found");
        exit;
    }
} else {
    header("Location: agent.php?error=invalid_request");
    exit;
}
?> 