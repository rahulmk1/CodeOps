<?php
header('Content-Type: application/json');

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers

// Database credentials
$host = 'team-codeops.ct2cs4w6a1pt.ap-south-1.rds.amazonaws.com';
$dbname = 'codeops';
$user = 'admin';
$password = 'Codeops#123';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define the SQL query to fetch product data
    $sql = "SELECT name, description, price, image_url FROM products";

    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all results as an associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the data as JSON
    echo json_encode($products);
} catch (PDOException $e) {
    // Handle any errors
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>