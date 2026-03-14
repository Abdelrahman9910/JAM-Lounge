<?php
require "config.php";

// SET YOUR NEW LOGIN HERE:
$username = "admin";
$newPassword = "12345"; // change this to something strong after testing

$hash = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ss", $username, $hash);

if ($stmt->execute()) {
    echo "✅ Admin created. Login = admin / 12345. DELETE this file now.";
} else {
    die("Execute failed: " . $stmt->error);
}
