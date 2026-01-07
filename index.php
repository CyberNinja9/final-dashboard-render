<?php

function callApi($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}


$baseUrl = "https://mirzayev68843.atwebpages.com/final_exam_5";

$productsByCategory = callApi("$baseUrl/products_by_category.php");
$productPrices      = callApi("$baseUrl/product_prices.php");
$transactionsByResp  = callApi("$baseUrl/transactions_by_response.php");
$transactionsAmount  = callApi("$baseUrl/transactions_amounts.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Final Project Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body class="bg-light">

<div class="container py-4">
<h2 class="text-center mb-4">Analytics Dashboard</h2>

<div class="row g-4">

<!-- PIE: PRODUCTS BY CATEGORY -->
<div class="col-md-6">
<div class="card p-3">
<h5 class="text-center">Products by Category</h5>
<div id="chart_products_category"></div>
</div>
</div>

<!-- BAR: PRODUCT PRICES -->
<div class="col-md-6">
<div class="card p-3">
<h5 class="text-center">Product Prices</h5>
<div id="chart_product_prices"></div>
</div>
</div>

<!-- PIE: TRANSACTIONS BY RESPONSE -->
<div class="col-md-6">
<div class="card p-3">
<h5 class="text-center">Transactions by Response Code</h5>
<div id="chart_transactions_response"></div>
</div>
</div>

<!-- BAR: TRANSACTION AMOUNTS -->
<div class="col-md-6">
<div class="card p-3">
<h5 class="text-center">Transaction Amounts</h5>
<div id="chart_transactions_amounts"></div>
</div>
</div>

</div>
</div>

<script>

const productsByCategory = <?= json_encode($productsByCategory) ?>;
const productPrices = <?= json_encode($productPrices) ?>;
const transactionsByResp = <?= json_encode($transactionsByResp) ?>;
const transactionsAmount = <?= json_encode($transactionsAmount) ?>;

// ---------- PIE: PRODUCTS BY CATEGORY ----------
Plotly.newPlot("chart_products_category", [{
    labels: productsByCategory.map(i => i.category),
    values: productsByCategory.map(i => i.total),
    type: "pie"
}]);

// ---------- BAR: PRODUCT PRICES ----------
Plotly.newPlot("chart_product_prices", [{
    x: productPrices.map(i => i.name),
    y: productPrices.map(i => i.price),
    type: "bar"
}]);

// ---------- PIE: TRANSACTIONS BY RESPONSE ----------
Plotly.newPlot("chart_transactions_response", [{
    labels: transactionsByResp.map(i => "Code " + i.response_code),
    values: transactionsByResp.map(i => i.total),
    type: "pie"
}]);

// ---------- BAR: TRANSACTION AMOUNTS ----------
Plotly.newPlot("chart_transactions_amounts", [{
    x: transactionsAmount.map(i => i.order_id),
    y: transactionsAmount.map(i => i.amount),
    type: "bar"
}]);
</script>

</body>
</html>

