<?php
$servername = "localhost";
$username = "root";  // Adjust if necessary
$password = "Mech2anism";  // Adjust if necessary
$dbname = "bus_commuter";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = sanitize_input($_POST["firstname"]);
    $lastname = sanitize_input($_POST["lastname"]);
    $phonenumber = sanitize_input($_POST["phonenumber"]);
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, phone_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $phonenumber);

    if ($stmt->execute()) {
        header("Location: Welcome.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
