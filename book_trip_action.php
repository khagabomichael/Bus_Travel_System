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

$name = $_POST['name'];
$route = $_POST['route'];
$location = $_POST['location'];
$pickup_stage = $_POST['pickup_stage'];
$seat_number = $_POST['seat_number'];
$phone_number = $_POST['phone_number'];
$paid_amount = $_POST['paid_amount'];
$date = $_POST['date'];
$time = $_POST['time'];

// Check if seat is already booked
$stmt = $conn->prepare("SELECT COUNT(*) FROM booking WHERE route = ? AND location = ? AND seat_number = ?");
$stmt->bind_param("ssi", $route, $location, $seat_number);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    // Seat is already booked
    echo "<script>alert('Seat already booked! Please choose another seat.'); window.history.back();</script>";
} else {
    // Proceed with booking
    $stmt = $conn->prepare("INSERT INTO booking (name, route, location, pickup_stage, seat_number, phone_number, paid_amount, date, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisdss", $name, $route, $location, $pickup_stage, $seat_number, $phone_number, $paid_amount, $date, $time);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Booking successful!'); window.location.href = 'Welcome.html';</script>";
}

$conn->close();
?>
