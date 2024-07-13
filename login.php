<?php
session_start();

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

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $row['role'];
            $_SESSION['firstname'] = $row['firstname']; // Store first name in session

            if ($row['role'] == 'admin') {
                header("Location: admin.html");
            } else {
                header("Location: Welcome.html");
            }
            exit();
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }
    $stmt->close();
}
$conn->close();
?>
