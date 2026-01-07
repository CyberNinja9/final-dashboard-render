<?php
$databaseUrl = getenv("DATABASE_URL");

$pdo = new PDO(
    $databaseUrl . "?sslmode=require",
    null,
    null,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
