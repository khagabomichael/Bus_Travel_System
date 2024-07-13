<?php
$servername = "localhost";
$username = "root";  // Adjust if necessary
$password = "";  // Adjust if necessary
$dbname = "bus_commuter";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get route and location from query parameters
$route = $_GET['route'];
$location = $_GET['location'];

// Retrieve booked seats
$stmt = $conn->prepare("SELECT seat_number FROM booking WHERE route = ? AND location = ?");
$stmt->bind_param("ss", $route, $location);
$stmt->execute();
$result = $stmt->get_result();

$booked_seats = [];
while ($row = $result->fetch_assoc()) {
    $booked_seats[] = $row['seat_number'];
}

$stmt->close();
$conn->close();

echo json_encode($booked_seats);
?>
