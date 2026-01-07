<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$databaseUrl = getenv("DATABASE_URL");
var_dump($databaseUrl);

try {
    $pdo = new PDO($databaseUrl);
    echo "DB CONNECTED OK";
} catch (Exception $e) {
    echo "<pre>";
    echo $e->getMessage();
    echo "</pre>";
}
