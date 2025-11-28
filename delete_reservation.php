<?php
include 'config.php';
$id = $_GET['id'];
$conn->query("DELETE FROM reservations WHERE id=$id");
echo "<script>alert('Deleted'); window.location.href='admin.php';</script>";
?>