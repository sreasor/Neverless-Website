<?php
// Database connection code
$con = mysqli_connect('127.0.0.1:3306', 'u879535303_neverless', '1212875046kT', 'u879535303_fans');

// Check the connection
if ($con->connect_error)
{
    die("Connection failed: " . $con->connect_error);
}

// Get the post records
$txtFName = filter_input(INPUT_POST, 'txtFName', FILTER_SANITIZE_STRING);
$txtLName = filter_input(INPUT_POST, 'txtLName', FILTER_SANITIZE_STRING);
$txtEmail = filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_STRING);

// Regular expression pattern for email validation
$email_pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

// Check if the email is valid
if (preg_match($email_pattern, $txtEmail)) {
    // Email is valid, proceed with database insertion
    // Database insert SQL code with prepared statements
    $sql = "INSERT INTO `email` (`firstname`, `lastname`, `email`) VALUES (?, ?, ?)";

    // Create a prepared statement
    $stmt = $con->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param('sss', $txtFName, $txtLName, $txtEmail);
        
        if ($stmt->execute()) {
            echo "We will email you soon!";
        } else {
            // Log error securely
            error_log("SQL Error: " . $stmt->error);
            echo "An error occurred. Please try again later.";
        }
    }
} else {
    // Email is invalid
    echo "Invalid email address. Please enter a valid email.";
}

// Close database connection
$con->close();
?>