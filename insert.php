<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form values
$user = $_POST['username'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
$contactNumber = $_POST['contact_number']; // Get contact number

// Validate contact number (check if it's exactly 11 digits)
if (!preg_match('/^[0-9]{11}$/', $contactNumber)) {
    echo "Contact number must be exactly 11 digits.";
    exit();
}

// Insert into database
$sql = "INSERT INTO user (username, email, password, contact_number) VALUES ('$user', '$email', '$pass', '$contactNumber')";

if ($conn->query($sql) === TRUE) {
  // Redirect to index.html after successful registration
  header("Location: index.html");
  exit();
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
