<?php
include 'config.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM reservations WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $area = $_POST['area'];

    $stmt = $conn->prepare("UPDATE reservations SET name=?, email=?, phone=?, reservation_date=?, reservation_time=?, guests=?, area=? WHERE id=?");
    $stmt->bind_param("sssssssi", $name, $email, $phone, $date, $time, $guests, $area, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error updating reservation.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Reservation - JAM Lounge</title>
</head>
<body>
<h2>Edit Reservation</h2>
<form action="" method="POST">
  <label>Name:</label><br>
  <input type="text" name="name" value="<?= $row['name'] ?>" required><br>

  <label>Email:</label><br>
  <input type="email" name="email" value="<?= $row['email'] ?>" required><br>

  <label>Phone:</label><br>
  <input type="text" name="phone" value="<?= $row['phone'] ?>" required><br>

  <label>Date:</label><br>
  <input type="date" name="date" value="<?= $row['reservation_date'] ?>" required><br>

  <label>Time:</label><br>
  <input type="time" name="time" value="<?= $row['reservation_time'] ?>" required><br>

  <label>Guests:</label><br>
  <input type="number" name="guests" value="<?= $row['guests'] ?>" required><br><br>

  <label>Seating Area:</label><br>
  <select name="area" required>
    <option value="indoor" <?= ($row['area'] == 'indoor') ? 'selected' : '' ?>>Indoor</option>
    <option value="outdoor" <?= ($row['area'] == 'outdoor') ? 'selected' : '' ?>>Outdoor</option>
  </select><br><br>

  <button type="submit">Update</button>
</form>
</body>
</html>
