<?php
include 'config.php';
$conn->query("INSERT INTO admin (username,password) VALUES ('admin','12345')");
echo "Admin user created (admin / 12345). You can now delete this file.";
?>