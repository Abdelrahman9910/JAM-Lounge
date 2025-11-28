<?php
session_start();
include 'config.php';

if (!isset($_SESSION['logged_in'])) {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  $query = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
  $query->bind_param("ss", $username, $password);
  $query->execute();
  $result = $query->get_result();
  if ($result->num_rows > 0) {
    $_SESSION['logged_in'] = true;
  } else {
    echo "<script>alert('Invalid credentials'); window.location.href='admin_login.php';</script>";
    exit;
  }
}

// Auto delete old reservations
$conn->query("DELETE FROM reservations WHERE reservation_date < DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
$result = $conn->query("SELECT * FROM reservations ORDER BY reservation_date ASC, reservation_time ASC");

?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h2>Reservations (last 30 days)</h2>
<a href='logout.php'>Logout</a>
<table border='1'>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Time</th><th>Guests</th><th>area</th><th>Actions</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['name'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= $row['phone'] ?></td>
  <td><?= $row['reservation_date'] ?></td>
  <td><?= date("g:i A", strtotime($row['reservation_time'])) ?></td>
  <td><?= $row['guests'] ?></td>
  <td><?= isset($row['area']) ? $row['area'] : '-' ?></td>
  <td>
    <a href='edit_reservation.php?id=<?= $row['id'] ?>'>Edit</a> |
    <a href='delete_reservation.php?id=<?= $row['id'] ?>'>Delete</a>
  </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>