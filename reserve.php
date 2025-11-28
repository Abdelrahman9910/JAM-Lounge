<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $area = $_POST['area'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.');</script>";
    } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
        echo "<script>alert('Please select today or a future date.');</script>";
    } elseif ((int)date('Hi', strtotime($time)) < 1100 && (int)date('Hi', strtotime($time)) > 100) {
        echo "<script>alert('Reservation time must be between 11:00 AM and 1:00 AM.');</script>";
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO reservations (name,email,phone,reservation_date,reservation_time,guests,area) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssis", $name, $email, $phone, $date, $time, $guests, $area);

        if ($stmt->execute()) {
            echo "<script>alert('Reservation made successfully!'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Error making reservation.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Make a Reservation - JAM Lounge</title>
<link rel="stylesheet" href="./style.css">
    <link
    href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="reservation-body">
<header>
      <div class="overlay"></div>
      <div class="bg-container"></div>

      <div class="logo">
        <a href="http://" target="_blank" rel="noopener noreferrer">
          <img src="./images/Asset 4@4x.png" alt="Restaurant Logo"
        /></a>
      </div>

      <!-- Desktop Navigation -->
      <div class="navbar">
  <nav>
    <ul>
      <li><a href="#about">About</a></li>
      <li><a href="#Contact-us">Contact Us</a></li>
      <li><a href="#menu">Menu</a></li>
      <li>
        <button
          id="book-now-btn"
          onclick="window.location.href='reservation.php'"
        >
          Book Now
        </button>
      </li>

      <!-- 🌐 Language Dropdown -->
      <li class="dropdown">
        <a href="#" class="dropbtn"><i class="fa-solid fa-globe"></i> Language</a>
        <div class="dropdown-content">
          <a href="?lang=en">English</a>
          <a href="?lang=ar">العربية</a>
        </div>
      </li>
    </ul>
  </nav>
</div>

      <!-- Mobile Navigation -->
     <!-- Mobile / Side Navigation -->
<div class="side-nav">
  <nav>
    <ul>
      <li><a href="#about">About</a></li>
      <li><a href="#Contact-us">Contact Us</a></li>
      <li><a href="#menu">Menu</a></li>
      <li><a href="#book-now" class="book-now">Book Now</a></li>

      <!-- 🌐 Language Dropdown -->
      <li class="dropdown">
        <a href="#" class="dropbtn"><i class="fa-solid fa-globe"></i> Language</a>
        <div class="dropdown-content">
          <a href="?lang=en">English</a>
          <a href="?lang=ar">العربية</a>
        </div>
      </li>
    </ul>
  </nav>
</div>
    </header>
<h2>Make a Reservation</h2>
<form action="reserve.php" method="POST">
  <label>Name:</label><br>
  <input type="text" name="name" required><br>

  <label>Email:</label><br>
  <input type="email" name="email" required><br>

  <label>Phone Number:</label><br>
  <input type="text" name="phone" required><br>

  <label>Date:</label><br>
  <input type="date" name="date" required><br>

  <label>Time:</label><br>
  <input type="time" name="time" required><br>

  <label>Number of Guests:</label><br>
  <input type="number" name="guests" required><br><br>

  <label for="area">Seating Area:</label><br>
  <select name="area" id="area" required>
    <option value="">-- Select Area --</option>
    <option value="indoor">Indoor</option>
    <option value="outdoor">Outdoor</option>
  </select><br><br>

  <button type="submit">Submit</button>
</form>
<script src="./script.js"></script>
</body>
</html>
