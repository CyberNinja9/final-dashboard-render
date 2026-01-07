<?php
echo "PHP works on Render<br>";

$data = file_get_contents("https://api.nbp.pl/api/exchangerates/rates/a/usd/last/1/?format=json");
echo "NBP works<br>";

echo "<pre>";
print_r(json_decode($data, true));

