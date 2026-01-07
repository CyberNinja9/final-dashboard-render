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
    SELECT response_code, COUNT(*) AS total
    FROM transactions2
    GROUP BY response_code
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "response_code" => (int)$row["response_code"],
        "total" => (int)$row["total"]
    ];
}

$conn->close();

echo json_encode($data);

