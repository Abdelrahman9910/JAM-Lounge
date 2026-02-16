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
    <link rel="stylesheet" href="./style.css"/>
</head>
<body class="reservation-body">
<a href="http://" target="_blank" rel="noopener noreferrer" class="reservation-logo">
          <img src="./images/Asset 4@4x.png" alt="Restaurant Logo"
        /></a>
<h2 class="reservation-head">Make a Reservation</h2>
<form action="reserve.php" method="POST" class="reservation-form">
  <!-- <label>Name:</label><br> -->
   
  <input type="text" name="name" placeholder="Name" required>
  <!-- <label>Email:</label><br> -->
  <!-- <input type="email" name="email" placeholder="Email" required><br> -->
  <!-- <label>Phone Number:</label><br> -->
  <input type="text" name="phone" placeholder="Phone" required>
  <!-- <label>Date:</label><br> -->
  <div class="date-wrapper">
  <input type="date" id="res-date" name="date" placeholder="Date" required>
  <div id="date-status" class="date-status"></div>
</div>
  <!-- <label>Time:</label><br> -->
  <input type="time" name="time" value="09:00" required>
  <!-- <label>Number of Guests:</label><br> -->
  <input type="number" name="guests" placeholder="NO of Guests" required>
  <!-- <label for="area">Seating Area:</label> -->

<select name="area" id="area" required>
  <option value="">Select Area</option>
  <br>
  <option value="indoor">Indoor</option>
  <option value="outdoor">Outdoor</option>
</select>
<!-- <label>Comment (optional):</label><br> -->
<textarea class="comment-sec" name="comment" rows="3" placeholder="Any notes or requests?"></textarea>
  <button type="submit" class="submit-btn">Submit</button>
</form>
<script>
  let blockedDates = [];

  fetch('get_blocked_dates.php')
    .then(r => r.json())
    .then(data => blockedDates = data)
    .catch(() => blockedDates = []);

  const dateInput = document.getElementById('res-date');
  const statusBox = document.getElementById('date-status');

  if (dateInput) {
    dateInput.addEventListener('change', function () {
      const selected = this.value; // YYYY-MM-DD

      if (blockedDates.includes(selected)) {
        statusBox.textContent = "❌ This day is fully booked";
        // Prevent form submission using HTML5 validation
        this.setCustomValidity("This day is fully booked.");
      } else {
        statusBox.textContent = "";
        this.setCustomValidity("");
      }
    });
  }
</script>

</body>
</html>