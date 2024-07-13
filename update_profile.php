<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "your_database_name";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume you have a logged in user and their ID is stored in $_SESSION['user_id']
$user_id = $_SESSION['user_id'];  // Adjust this according to your session handling

// Prepare and execute query to fetch user data
$stmt = $conn->prepare("SELECT name, phone_number, email, profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Construct JSON response
    $response = [
        'name' => $row['name'],
        'phone_number' => $row['phone_number'],
        'email' => $row['email'],
        'profile_photo' => $row['profile_photo']
    ];

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle case where user data is not found
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'User data not found']);
}

$stmt->close();
$conn->close();
?>
