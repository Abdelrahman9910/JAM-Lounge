<?php
include 'config.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT blocked_date FROM blocked_dates ORDER BY blocked_date ASC");
$dates = [];

while ($row = $result->fetch_assoc()) {
  $dates[] = $row['blocked_date']; // format: YYYY-MM-DD
}

echo json_encode($dates);
