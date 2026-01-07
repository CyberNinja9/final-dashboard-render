<?php
header("Content-Type: application/json");

$data = [
  ["order_id"=>1,"amount"=>120],
  ["order_id"=>2,"amount"=>240],
  ["order_id"=>3,"amount"=>180],
  ["order_id"=>4,"amount"=>320]
];

echo json_encode($data);

