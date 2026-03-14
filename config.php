<?php
// Show errors temporarily (remove later)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$db_host = "localhost";
$db_user = "u524697643_jamlounge11_gm";     // from Hostinger panel
$db_pass = "HyJam21@#2322";       // from Hostinger panel
$db_name = "u524697643_Jam_DB";      // from Hostinger panel

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
