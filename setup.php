<?php
$host = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($host, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS food_donation";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select the database
mysqli_select_db($conn, "food_donation");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('user', 'agent', 'admin') DEFAULT 'user',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'users' created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Create donations table
$sql = "CREATE TABLE IF NOT EXISTS donations (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    food_type ENUM('Veg', 'NonVeg', 'Both') NOT NULL,
    quantity INT(6) NOT NULL,
    status ENUM('pending', 'approved', 'completed', 'rejected') DEFAULT 'pending',
    agent_id INT(6) UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (agent_id) REFERENCES users(id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'donations' created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Create contact table
$sql = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'contact_messages' created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Create admin account
$admin_username = "admin";
$admin_email = "admin@fooddonation.com";
$admin_password = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT IGNORE INTO users (username, email, password, user_type) 
        VALUES ('$admin_username', '$admin_email', '$admin_password', 'admin')";

if (mysqli_query($conn, $sql)) {
    echo "Admin account created successfully<br>";
} else {
    echo "Error creating admin account: " . mysqli_error($conn) . "<br>";
}

echo "Setup completed. You can now <a href='index.php'>go to the homepage</a>.";

mysqli_close($conn);
?> 