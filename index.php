<?php
function fetchApi($url) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch);
  return json_decode($response, true);
}

// CHANGE THIS to your Render base URL
$baseUrl = "https://final-dashboard-render.onrender.com/api";

// Fetch data from REST APIs using PHP cURL
$productsByCategory = fetchApi("$baseUrl/products_by_category.php");
$productPrices      = fetchApi("$baseUrl/product_prices.php");
$transactionsByResp = fetchApi("$baseUrl/transactions_by_response.php");
$transactionsAmount = fetchApi("$baseUrl/transactions_amounts.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analytics Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<style>
body {
  background:#f5f7fb;
  font-family: system-ui, -apple-system, BlinkMacSystemFont;
}
.card {
  border:none;
  border-radius:16px;
  box-shadow:0 10px 25px rgba(0,0,0,.06);
}
.chart-box { height:300px; }
</style>
</head>

<body>

<div class="container py-5">
  <h2 class="text-center mb-5">Analytics Dashboard</h2>

  <div class="row g-4">

    <div class="col-md-6">
      <div class="card p-4">
        <h5>Products by Category</h5>
        <div id="chart_category" class="chart-box"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-4">
        <h5>Product Prices</h5>
        <div id="chart_prices" class="chart-box"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-4">
        <h5>Transactions by Response Code</h5>
        <div id="chart_response" class="chart-box"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-4">
        <h5>Transaction Amounts</h5>
        <div id="chart_amounts" class="chart-box"></div>
      </div>
    </div>

  </div>
</div>

<script>
// Data passed from PHP (via cURL)
const productsByCategory = <?= json_encode($productsByCategory) ?>;
const productPrices      = <?= json_encode($productPrices) ?>;
const transactionsByResp = <?= json_encode($transactionsByResp) ?>;
const transactionsAmount = <?= json_encode($transactionsAmount) ?>;

// Pie chart – Products by Category
Plotly.newPlot("chart_category", [{
  labels: productsByCategory.map(x => x.category),
  values: productsByCategory.map(x => x.total),
  type: "pie",
  hole: .4
}]);

// Bar chart – Product Prices
Plotly.newPlot("chart_prices", [{
  x: productPrices.map(x => x.name),
  y: productPrices.map(x => x.price),
  type: "bar"
}]);

// Pie chart – Transactions by Response Code
Plotly.newPlot("chart_response", [{
  labels: transactionsByResp.map(x => "Code " + x.response_code),
  values: transactionsByResp.map(x => x.total),
  type: "pie",
  hole: .4
}]);

// Bar chart – Transaction Amounts
Plotly.newPlot("chart_amounts", [{
  x: transactionsAmount.map(x => x.order_id),
  y: transactionsAmount.map(x => x.amount),
  type: "bar"
}]);
</script>

</body>
</html>
