<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Just get all users — no need for $_GET['id'] here
$sql = "SELECT * FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Panel | Alontech</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background-color: #f8f8f8; }
    table { width: 100%; border-collapse: collapse; background-color: white; }
    th, td { padding: 12px; border: 1px solid #ddd; }
    th { background-color: #2c6e2f; color: white; }
    a { padding: 5px 10px; background-color: #2c6e2f; color: white; text-decoration: none; border-radius: 5px; }
    a.delete { background-color: red; }
    .actions { display: flex; gap: 10px; }
  </style>
</head>
<body>

<h2>Admin Panel – Manage Users</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Contact Number</th>
    <th>Actions</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['username'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['contact_number'] ?></td>
      
      <td class="actions">
        <a href="user_edit.php?id=<?= $row['id'] ?>">Edit</a>
        <a class="delete" href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
      </td>
    </tr>
  <?php } ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
