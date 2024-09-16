<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers

// Database configuration
$servername = "team-codeops.ct2cs4w6a1pt.ap-south-1.rds.amazonaws.com"; // Replace with your RDS endpoint
$username = "admin"; // Replace with your RDS database username
$password = "Codeops#123"; // Replace with your RDS database password
$dbname = "codeops"; // Replace with your RDS database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['full_name'];
    $userEmail = $_POST['username'];
    $userPassword = $_POST['password'];

    // Validate input (basic validation)
    if (empty($fullName) || empty($userEmail) || empty($userPassword)) {
        die("All fields are required.");
    }

    // Hash the password
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO user (full_name, username, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $fullName, $userEmail, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Form not submitted.";
}

// Close connection
$conn->close();
?>