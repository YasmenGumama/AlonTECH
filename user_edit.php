<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get user ID from URL
$id = $_GET['id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newUsername = $_POST['username'];
  $newEmail = $_POST['email'];
  $newNumber = $_POST['contact_number'];
  $updateSql = "UPDATE user SET username='$newUsername', email='$newEmail' WHERE id=$id";
  if ($conn->query($updateSql) === TRUE) {
    header("Location: admin.php"); // Redirect back to admin panel
    exit();
  } else {
    echo "Error updating user: " . $conn->error;
  }
}

// Get user data to fill the form
$sql = "SELECT * FROM user WHERE id=$id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit User | Alontech</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f8f8f8;
    }

    form {
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      font-size: 1rem;
    }

    button {
      padding: 10px;
      background-color: #2c6e2f;
      color: white;
      border: none;
      width: 100%;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
    }

    a {
      display: block;
      margin-top: 15px;
      text-align: center;
      color: #2c6e2f;
      text-decoration: none;
    }
  </style>
</head>
<body>

<h2 style="text-align:center;">Edit User</h2>

<form method="POST">
  <input type="text" name="username" value="<?= $user['username'] ?>" required>
  <input type="email" name="email" value="<?= $user['email'] ?>" required>
  <input type="text" name="contact_number" value="<?php echo $user['contact_number']; ?>" pattern="^[0-9]{11}$" title="Please enter exactly 11 digits" required />
  <button type="submit">Update</button>
</form>

<a href="admin.php">← Back to Admin Panel</a>

</body>
</html>

<?php $conn->close(); ?>
