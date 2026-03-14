<?php
require "config.php";

$username = "admin";
$plainPassword = "12345"; // Change to strong password if you want
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();

echo "Admin user created securely. Delete this file now.";
?>
