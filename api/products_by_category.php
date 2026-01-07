<?php
header("Content-Type: application/json");

$data = [
  ["category"=>"Electronics","total"=>120],
  ["category"=>"Furniture","total"=>80],
  ["category"=>"Kitchen","total"=>60]
];

echo json_encode($data);

