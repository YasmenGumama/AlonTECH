<?php
// login.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_monitoring";

session_start();

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM user WHERE email='$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      header("Location: dashboard.php");
      exit();
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "User not found.";
  }
}
$conn->close();
?>