<?php
require "db.php";

$result = $conn->query("SHOW TABLES");

echo "Database connected successfully<br><br>";

while ($row = $result->fetch_array()) {
    echo $row[0] . "<br>";
}

