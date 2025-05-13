<?php 
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];

// Fetch user info
$sql = "SELECT username, email, contact_number FROM user WHERE id=$userId";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $contact = $_POST['contact_number'];
  $updateFields = "email='$email', contact_number='$contact'";

  // Handle password change
  if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Verify current password
    $check = $conn->query("SELECT password FROM user WHERE id=$userId");
    $stored = $check->fetch_assoc();

    if (password_verify($current_password, $stored['password'])) {
      $newHash = password_hash($new_password, PASSWORD_DEFAULT);
      $updateFields .= ", password='$newHash'";
    } else {
      echo "<script>alert('Current password is incorrect.');</script>";
    }
  }

  $updateSql = "UPDATE user SET $updateFields WHERE id=$userId";
  if ($conn->query($updateSql) === TRUE) {
    echo "<script>alert('Profile updated successfully');</script>";
    // Refresh user info
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
  } else {
    echo "<script>alert('Error updating profile');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard | Alontech</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    .container {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 50px;
      border-radius: 11px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #2c6e2f;
    }

    input, button {
      width: 100%;
      padding: 13px;
      margin: 10px 0;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    button {
      background-color: #2c6e2f;
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color: #1b4d26;
    }

    a.logout {
      display: block;
      margin-top: 15px;
      text-align: center;
      color: red;
      text-decoration: none;
    }

    h3 {
      margin-top: 20px;
      color: #444;
    }
  </style>
  <script>
    function confirmPasswordChange(event) {
      const current = document.querySelector('[name="current_password"]').value;
      const newPass = document.querySelector('[name="new_password"]').value;

      if (current && newPass) {
        const confirmed = confirm("Are you sure you want to change your password?");
        if (!confirmed) {
          event.preventDefault();
        }
      }
    }
  </script>
</head>
<body>
<div class="container">
  <h2>Welcome, <?= htmlspecialchars($user['username']) ?></h2>
  <form method="POST" onsubmit="confirmPasswordChange(event)">
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required />
    <input type="text" name="contact_number" value="<?= htmlspecialchars($user['contact_number']) ?>" pattern="^[0-9]{11}$" title="Enter exactly 11 digits" required />

    <h3>Change Password</h3>
    <input type="password" name="current_password" placeholder="Current Password" />
    <input type="password" name="new_password" placeholder="New Password" />

    <button type="submit">Update Profile</button>
  </form>
  <a class="logout" href="logout.php">Logout</a>
</div>
</body>
</html>

<?php $conn->close(); ?>
