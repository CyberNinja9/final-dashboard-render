<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analytics Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<style>
body {
  background: #f5f7fb;
  font-family: system-ui, -apple-system, BlinkMacSystemFont;
}

h2 {
  font-weight: 700;
}

.card {
  border: none;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0,0,0,.06);
}

.card h5 {
  font-weight: 600;
  margin-bottom: 10px;
}

.chart-box {
  height: 300px;
}
</style>
</head>

<body>

<div class="container py-5">
  <div class="text-center mb-5">
    <h2>Analytics Dashboard</h2>
    <p class="text-muted">PHP • Plotly • NBP API • Render</p>
  </div>

  <div class="row g-4">

    <div class="col-lg-6">
      <div class="card p-4">
        <h5>Products by Category</h5>
        <div id="chart_category" class="chart-box"></div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card p-4">
        <h5>Product Prices</h5>
        <div id="chart_prices" class="chart-box"></div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card p-4">
        <h5>Transactions by Response Code</h5>
        <div id="chart_response" class="chart-box"></div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card p-4">
        <h5>Transaction Amounts</h5>
        <div id="chart_amounts" class="chart-box"></div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card p-4">
        <h5>USD → PLN (last 20 days)</h5>
        <div id="chart_usd" class="chart-box"></div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card p-4">
        <h5>CHF → PLN (last 20 days)</h5>
        <div id="chart_chf" class="chart-box"></div>
      </div>
    </div>

  </div>
</div>

<script>
/* ===== STATIC DATA ===== */

const productsByCategory = [
  { category: "Electronics", total: 120 },
  { category: "Furniture", total: 80 },
  { category: "Kitchen", total: 60 }
];

const productPrices = [
  { name: "Laptop", price: 1200 },
  { name: "Office Chair", price: 180 },
  { name: "Coffee Mug", price: 25 }
];

const transactionsByResp = [
  { response_code: 200, total: 40 },
  { response_code: 400, total: 20 },
  { response_code: 500, total: 10 }
];

const transactionsAmount = [
  { order_id: 1, amount: 120 },
  { order_id: 2, amount: 240 },
  { order_id: 3, amount: 180 },
  { order_id: 4, amount: 320 }
];

const layoutBase = {
  paper_bgcolor: "transparent",
  plot_bgcolor: "transparent",
  margin: { t: 30, l: 40, r: 20, b: 40 }
};

const config = {
  displayModeBar: false,
  responsive: true
};

/* ===== CHARTS ===== */

Plotly.newPlot("chart_category", [{
  labels: productsByCategory.map(i => i.category),
  values: productsByCategory.map(i => i.total),
  type: "pie",
  hole: .45
}], layoutBase, config);

Plotly.newPlot("chart_prices", [{
  x: productPrices.map(i => i.name),
  y: productPrices.map(i => i.price),
  type: "bar",
  marker: { color: "#3b82f6" }
}], layoutBase, config);

Plotly.newPlot("chart_response", [{
  labels: transactionsByResp.map(i => "Code " + i.response_code),
  values: transactionsByResp.map(i => i.total),
  type: "pie",
  hole: .45
}], layoutBase, config);

Plotly.newPlot("chart_amounts", [{
  x: transactionsAmount.map(i => i.order_id),
  y: transactionsAmount.map(i => i.amount),
  type: "bar",
  marker: { color: "#22c55e" }
}], layoutBase, config);

/* ===== LIVE NBP ===== */

async function drawCurrencyCharts() {
  const usd = await (await fetch(
    "https://api.nbp.pl/api/exchangerates/rates/a/usd/last/20/?format=json"
  )).json();

  const chf = await (await fetch(
    "https://api.nbp.pl/api/exchangerates/rates/a/chf/last/20/?format=json"
  )).json();

  Plotly.newPlot("chart_usd", [{
    x: usd.rates.map(r => r.effectiveDate),
    y: usd.rates.map(r => r.mid),
    mode: "lines+markers",
    line: { width: 3, color: "#2563eb" }
  }], layoutBase, config);

  Plotly.newPlot("chart_chf", [{
    x: chf.rates.map(r => r.effectiveDate),
    y: chf.rates.map(r => r.mid),
    mode: "lines+markers",
    line: { width: 3, color: "#16a34a" }
  }], layoutBase, config);
}

drawCurrencyCharts();
</script>

</body>
</html>
