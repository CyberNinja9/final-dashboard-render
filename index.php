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

    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Products by Category</h5>
        <div id="chart_category" style="height:300px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Product Prices</h5>
        <div id="chart_prices" style="height:300px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Transactions by Response Code</h5>
        <div id="chart_response" style="height:300px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Transaction Amounts</h5>
        <div id="chart_amounts" style="height:300px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">USD Exchange Rate (Last 20 Days)</h5>
        <div id="chart_usd" style="height:300px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">CHF Exchange Rate (Last 20 Days)</h5>
        <div id="chart_chf" style="height:300px;"></div>
      </div>
    </div>

  </div>
</div>

<script>
// ✅ HARD-CODED DATA (LIKE YOUR FRIEND)

// Products by category
const productsByCategory = [
  { category: "Electronics", total: 120 },
  { category: "Furniture", total: 80 },
  { category: "Kitchen", total: 60 }
];

// Product prices
const productPrices = [
  { name: "Laptop", price: 1200 },
  { name: "Office Chair", price: 180 },
  { name: "Coffee Mug", price: 25 }
];

// Transactions by response
const transactionsByResp = [
  { response_code: 200, total: 40 },
  { response_code: 400, total: 20 },
  { response_code: 500, total: 10 }
];

// Transaction amounts
const transactionsAmount = [
  { order_id: 1, amount: 120 },
  { order_id: 2, amount: 240 },
  { order_id: 3, amount: 180 },
  { order_id: 4, amount: 320 }
];

// USD & CHF (NBP data – static but valid)
const usdRates = {
  rates: [
    { effectiveDate: "2026-01-02", mid: 3.5963 },
    { effectiveDate: "2026-01-05", mid: 3.6045 }
  ]
};

const chfRates = {
  rates: [
    { effectiveDate: "2026-01-02", mid: 4.5314 },
    { effectiveDate: "2026-01-05", mid: 4.5263 }
  ]
};

// ✅ DRAW CHARTS

Plotly.newPlot("chart_category", [{
  labels: productsByCategory.map(i => i.category),
  values: productsByCategory.map(i => i.total),
  type: "pie"
}]);

Plotly.newPlot("chart_prices", [{
  x: productPrices.map(i => i.name),
  y: productPrices.map(i => i.price),
  type: "bar"
}]);

Plotly.newPlot("chart_response", [{
  labels: transactionsByResp.map(i => "Code " + i.response_code),
  values: transactionsByResp.map(i => i.total),
  type: "pie"
}]);

Plotly.newPlot("chart_amounts", [{
  x: transactionsAmount.map(i => i.order_id),
  y: transactionsAmount.map(i => i.amount),
  type: "bar"
}]);

Plotly.newPlot("chart_usd", [{
  x: usdRates.rates.map(r => r.effectiveDate),
  y: usdRates.rates.map(r => r.mid),
  type: "scatter",
  mode: "lines+markers"
}]);

Plotly.newPlot("chart_chf", [{
  x: chfRates.rates.map(r => r.effectiveDate),
  y: chfRates.rates.map(r => r.mid),
  type: "scatter",
  mode: "lines+markers"
}]);
</script>

</body>
</html>
