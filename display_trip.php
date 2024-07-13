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

// Get booking ID from query parameters
$booking_id = $_GET['id'];

// Retrieve booking details
$stmt = $conn->prepare("SELECT * FROM booking WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Details</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #333;
            text-align: left;
        }
        th {
            background-color: #333;
        }
        .button-container {
            text-align: center;
        }
        .button {
            padding: 10px 20px;
            background-color: #6200ee;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #3700b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Trip Details</h2>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($booking['name']); ?></td>
            </tr>
            <tr>
                <th>Route</th>
                <td><?php echo htmlspecialchars($booking['route']); ?></td>
            </tr>
            <tr>
                <th>Location</th>
                <td><?php echo htmlspecialchars($booking['location']); ?></td>
            </tr>
            <tr>
                <th>Pickup Stage</th>
                <td><?php echo htmlspecialchars($booking['pickup_stage']); ?></td>
            </tr>
            <tr>
                <th>Seat Number</th>
                <td><?php echo htmlspecialchars($booking['seat_number']); ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?php echo htmlspecialchars($booking['phone_number']); ?></td>
            </tr>
            <tr>
                <th>Paid Amount</th>
                <td><?php echo htmlspecialchars($booking['paid_amount']); ?></td>
            </tr>
            <tr>
                <th>Date</th>
                <td><?php echo htmlspecialchars($booking['date']); ?></td>
            </tr>
            <tr>
                <th>Time</th>
                <td><?php echo htmlspecialchars($booking['time']); ?></td>
            </tr>
            <tr>
                <th>Booked At</th>
                <td><?php echo htmlspecialchars($booking['booked_at']); ?></td>
            </tr>
        </table>
        <div class="button-container">
            <a href="Welcome.html" class="button">Go to Welcome Page</a>
        </div>
    </div>
</body>
</html>
