<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//CORS
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers

// Your PHP code to interact with S3 goes here



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
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validate input
    if (empty($user) || empty($pass)) {
        die("Please enter both username and password.");
    }

    // Fetch the user record from the database
    $sql = "SELECT password FROM user WHERE username=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $user); // Bind username
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hash = $row['password'];

        // Verify the password
        if (password_verify($pass, $stored_hash)) {
            echo "Login successful";
            // You can start a session or redirect to another page here
            // For example: header('Location: dashboard.php');
            // exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "No user found with that username";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Form not submitted.";
}

// Close connection
$conn->close();
?>