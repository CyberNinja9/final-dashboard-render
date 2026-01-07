<?php
header("Content-Type: application/json");

$host = "fdb1034.awardspace.net";
$dbname = "4706409_mirza68843";
$user = "4706409_mirza68843";
$pass = "Acca2023";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$sql = "
    SELECT order_id, amount
    FROM transactions2
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "order_id" => $row["order_id"],
        "amount" => (float)$row["amount"]
    ];
}

$conn->close();

echo json_encode($data);

