<?php
$host = "fdb1034.awardspace.net";
$db   = "4706409_mirza68843";
$user = "4706409_mirza68843";
$pass = "Acca2023";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

