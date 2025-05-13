<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the 'id' from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete the user
    $sql = "DELETE FROM user WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to admin panel after deletion
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "User ID not provided!";
}

$conn->close();
?>
