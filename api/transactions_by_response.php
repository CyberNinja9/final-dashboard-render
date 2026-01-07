<?php
header("Content-Type: application/json");

$data = [
  ["name"=>"Laptop","price"=>1200],
  ["name"=>"Office Chair","price"=>180],
  ["name"=>"Coffee Mug","price"=>25]
];

echo json_encode($data);

