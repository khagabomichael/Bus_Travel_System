<?php
// get_bookings.php

// Establish database connection
$servername = "localhost";
$username = "root";  // Adjust if necessary
$password = "";  // Adjust if necessary
$dbname = "bus_commuter";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings from database
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

$bookings = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'location' => $row['location'],
            'price' => $row['price'],
            'date' => $row['date'],
            'time' => $row['time'],
            'payment_method' => $row['payment_method'],
            'pickup_stage' => $row['pickup_stage'],
            'status' => $row['status']
        );
    }
}

// Output bookings as JSON
header('Content-Type: application/json');
echo json_encode($bookings);

// Close connection
$conn->close();
?>
