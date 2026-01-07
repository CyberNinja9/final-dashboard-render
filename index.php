<?php
// --------------------------------------------------
// Helper function: fetch JSON from URL
// --------------------------------------------------
function fetchJson($url) {
    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: RenderPHP\r\n",
            "timeout" => 15
        ]
    ]);
    $data = @file_get_contents($url, false, $context);
    return $data ? json_decode($data, true) : [];
}

// --------------------------------------------------
// AWARDSPACE REST APIs (YOUR OWN APIs)
// --------------------------------------------------
$base = "https://mirzayev68843.atwebpages.com/final_exam_5";

$productsByCategory = fetchJson("$base/products_by_category.php");
$productPrices      = fetchJson("$base/product_prices.php");
$transactionsByResp = fetchJson("$base/transactions_by_response.php");
$transactionsAmount = fetchJson("$base/transactions_amounts.php");

// --------------------------------------------------
// EXTERNAL API (NBP – DIRECT, NO PROXY NEEDED)
// --------------------------------------------------
$usdRates = fetchJson("https://api.nbp.pl/api/exchangerates/rates/A/USD/last/20/?format=json");
$chfRates = fetchJson("https://api.nbp.pl/api/exchangerates/rates/A/CHF/last/20/?format=json");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Final Analytics Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body class="bg-light">

<div class="container py-4">
  <h2 class="text-center mb-4">Analytics Dashboard</h2>

  <div class="row g-4">

    <!-- PIE 1 -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Products by Category</h5>
        <div id="chart_category"></div>
      </div>
    </div>

    <!-- BAR 1 -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Product Prices</h5>
        <div id="chart_prices"></div>
      </div>
    </div>

    <!-- PIE 2 -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Transactions by Response Code</h5>
        <div id="chart_response"></div>
      </div>
    </div>

    <!-- BAR 2 -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Transaction Amounts</h5>
        <div id="chart_amounts"></div>
      </div>
    </div>

    <!-- LINE USD -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">USD Exchange Rate (Last 20 Days)</h5>
        <div id="chart_usd"></div>
      </div>
    </div>

    <!-- LINE CHF -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">CHF Exchange Rate (Last 20 Days)</h5>
        <div id="chart_chf"></div>
      </div>
    </div>

  </div>
</div>

<script>
// ---------------- DATA FROM PHP ----------------
const productsByCategory = <?= json_encode($productsByCategory) ?>;
const productPrices      = <?= json_encode($productPrices) ?>;
const transactionsByResp = <?= json_encode($transactionsByResp) ?>;
const transactionsAmount = <?= json_encode($transactionsAmount) ?>;
const usdRates           = <?= json_encode($usdRates) ?>;
const chfRates           = <?= json_encode($chfRates) ?>;

// ---------------- PIE: PRODUCTS BY CATEGORY ----------------
Plotly.newPlot("chart_category", [{
  labels: productsByCategory.map(i => i.category),
  values: productsByCategory.map(i => i.total),
  type: "pie"
}]);

// ---------------- BAR: PRODUCT PRICES ----------------
Plotly.newPlot("chart_prices", [{
  x: productPrices.map(i => i.name),
  y: productPrices.map(i => i.price),
  type: "bar"
}]);

// ---------------- PIE: TRANSACTIONS BY RESPONSE ----------------
Plotly.newPlot("chart_response", [{
  labels: transactionsByResp.map(i => "Code " + i.response_code),
  values: transactionsByResp.map(i => i.total),
  type: "pie"
}]);

// ---------------- BAR: TRANSACTION AMOUNTS ----------------
Plotly.newPlot("chart_amounts", [{
  x: transactionsAmount.map(i => i.order_id),
  y: transactionsAmount.map(i => i.amount),
  type: "bar"
}]);

// ---------------- LINE: USD ----------------
Plotly.newPlot("chart_usd", [{
  x: usdRates.rates.map(r => r.effectiveDate),
  y: usdRates.rates.map(r => r.mid),
  type: "scatter",
  mode: "lines+markers"
}]);

// ---------------- LINE: CHF ----------------
Plotly.newPlot("chart_chf", [{
  x: chfRates.rates.map(r => r.effectiveDate),
  y: chfRates.rates.map(r => r.mid),
  type: "scatter",
  mode: "lines+markers"
}]);
</script>

</body>
</html>
