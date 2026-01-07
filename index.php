<?php
function callApi($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 15
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$base = "https://final-dashboard-render.onrender.com/api";

$productsByCategory = callApi("$base/products.php");
$productPrices      = callApi("$base/prices.php");
$transactionsByResp = callApi("$base/responses.php");
$transactionsAmount = callApi("$base/amounts.php");
$usdRates = callApi("https://api.nbp.pl/api/exchangerates/rates/a/usd/last/20/?format=json");
$chfRates = callApi("https://api.nbp.pl/api/exchangerates/rates/a/chf/last/20/?format=json");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analytics Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body class="bg-light">
<div class="container py-4">
<h2 class="text-center mb-4">Analytics Dashboard</h2>

<div class="row g-4">
<div class="col-md-6"><div class="card p-3">
<h5>Products by Category</h5><div id="cat"></div></div></div>

<div class="col-md-6"><div class="card p-3">
<h5>Product Prices</h5><div id="prices"></div></div></div>

<div class="col-md-6"><div class="card p-3">
<h5>Transactions by Response Code</h5><div id="resp"></div></div></div>

<div class="col-md-6"><div class="card p-3">
<h5>Transaction Amounts</h5><div id="amounts"></div></div></div>

<div class="col-md-6"><div class="card p-3">
<h5>USD Exchange Rate (Last 20 Days)</h5><div id="usd"></div></div></div>

<div class="col-md-6"><div class="card p-3">
<h5>CHF Exchange Rate (Last 20 Days)</h5><div id="chf"></div></div></div>
</div>
</div>

<script>
const products = <?= json_encode($productsByCategory) ?>;
const prices   = <?= json_encode($productPrices) ?>;
const resp     = <?= json_encode($transactionsByResp) ?>;
const amounts  = <?= json_encode($transactionsAmount) ?>;
const usd      = <?= json_encode($usdRates) ?>;
const chf      = <?= json_encode($chfRates) ?>;

// PIE
Plotly.newPlot("cat", [{
  labels: products.map(i => i.category),
  values: products.map(i => i.total),
  type: "pie"
}]);

// BAR
Plotly.newPlot("prices", [{
  x: prices.map(i => i.name),
  y: prices.map(i => i.price),
  type: "bar"
}]);

// PIE
Plotly.newPlot("resp", [{
  labels: resp.map(i => "Code " + i.response_code),
  values: resp.map(i => i.total),
  type: "pie"
}]);

// BAR
Plotly.newPlot("amounts", [{
  x: amounts.map(i => i.order_id),
  y: amounts.map(i => i.amount),
  type: "bar"
}]);

// USD
Plotly.newPlot("usd", [{
  x: usd.rates.map(r => r.effectiveDate),
  y: usd.rates.map(r => r.mid),
  mode: "lines+markers"
}]);

// CHF
Plotly.newPlot("chf", [{
  x: chf.rates.map(r => r.effectiveDate),
  y: chf.rates.map(r => r.mid),
  mode: "lines+markers"
}]);
</script>
</body>
</html>
