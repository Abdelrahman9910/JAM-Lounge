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

/* ----------------------------
   Block/Unblock date logic
----------------------------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $action = $_POST['action'] ?? '';
  $selectedDate = $_POST['blocked_date'] ?? '';

  if ($action === 'block' && $selectedDate) {
    $stmt = $conn->prepare("INSERT IGNORE INTO blocked_dates (blocked_date) VALUES (?)");
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    echo "<script>alert('Date blocked successfully!'); window.location.href='admin.php';</script>";
    exit;
  }

  if ($action === 'unblock' && $selectedDate) {
    $stmt = $conn->prepare("DELETE FROM blocked_dates WHERE blocked_date=?");
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    echo "<script>alert('Date unblocked successfully!'); window.location.href='admin.php';</script>";
    exit;
  }
}

// Auto delete old reservations
$conn->query("DELETE FROM reservations WHERE reservation_date < DATE_SUB(CURDATE(), INTERVAL 30 DAY)");


$result = $conn->query("
  SELECT r.*,
         (bd.blocked_date IS NOT NULL) AS is_blocked
  FROM reservations r
  LEFT JOIN blocked_dates bd ON bd.blocked_date = r.reservation_date
  ORDER BY r.reservation_date ASC, r.reservation_time ASC
");


$countsResult = $conn->query("
  SELECT reservation_date,
         COUNT(*) AS total_reservations,
         COALESCE(SUM(guests),0) AS total_guests
  FROM reservations
  GROUP BY reservation_date
  ORDER BY reservation_date ASC
");



$blockedResult = $conn->query("
  SELECT blocked_date
  FROM blocked_dates
  ORDER BY blocked_date ASC
");
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>

<h2>Admin Dashboard</h2>
<a href='logout.php'>Logout</a>

<hr>

<h3>Stop Reservations For a Specific Day</h3>
<form method="POST" action="admin.php" style="margin-bottom: 15px;">
  <input type="date" name="blocked_date" required>
  <button type="submit" name="action" value="block">Block Day</button>
  <button type="submit" name="action" value="unblock">Unblock Day</button>
</form>

<h4>Blocked Days</h4>
<table border="1">
  <tr>
    <th>Blocked Date</th>
  </tr>
  <?php while($b = $blockedResult->fetch_assoc()): ?>
    <tr>
      <td><?= $b['blocked_date'] ?></td>
    </tr>
  <?php endwhile; ?>
</table>

<hr>

<h3>Reservation Count Per Day</h3>
<table border="1">
  <tr>
  <th>Date</th>
  <th>Total Reservations</th>
  <th>Total Guests</th>
</tr>

  <?php while($c = $countsResult->fetch_assoc()): ?>
    <tr>
      <td><?= $c['reservation_date'] ?></td>
      <td><?= $c['total_reservations'] ?></td>
      <td><?= $c['total_guests'] ?></td>

    </tr>
  <?php endwhile; ?>
</table>

<hr>

<h2>Reservations (last 30 days)</h2>
<table border='1'>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Phone</th>
  <th>Date</th>
  <th>Status</th>
  <th>Time</th>
  <th>Guests</th>
  <th>Area</th>
  <th>Comment</th>
  <th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['name'] ?></td>
  <td><?= $row['phone'] ?></td>
  <td><?= $row['reservation_date'] ?></td>
  <td><?= ((int)$row['is_blocked'] === 1) ? 'Blocked' : 'Open' ?></td>
  <td><?= date("g:i A", strtotime($row['reservation_time'])) ?></td>
  <td><?= $row['guests'] ?></td>
  <td><?= isset($row['area']) ? $row['area'] : '-' ?></td>
  <td><?= isset($row['comment']) ? $row['comment'] : '' ?></td>
  <td>
    <a href='edit_reservation.php?id=<?= $row['id'] ?>'>Edit</a> |
    <a href='delete_reservation.php?id=<?= $row['id'] ?>'>Delete</a>
  </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
