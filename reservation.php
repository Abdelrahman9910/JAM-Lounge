<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Make a Reservation</title>
<link
      href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<a href="http://" target="_blank" rel="noopener noreferrer" class="reservation-logo">
          <img src="./images/Asset 4@4x.png" alt="Restaurant Logo"
        /></a>
<h2 class="reservation-head">Make a Reservation</h2>
<form action="reserve.php" method="POST" class="reservation-form">
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
  <label for="area">Seating Area:</label>
  <br>
<select name="area" id="area" required>
  <option value="">Select Area</option>
  <br>
  <option value="indoor">Indoor</option>
  <option value="outdoor">Outdoor</option>
</select><br><br>

  <button type="submit">Submit</button>
</form>
</body>
</html>