<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analytics Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Plotly -->
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<style>
body {
  background: linear-gradient(180deg, #f5f7fb 0%, #eef1f7 100%);
  font-family: system-ui, -apple-system, BlinkMacSystemFont;
}

h2 {
  font-weight: 700;
}

.card {
  border: none;
  border-radius: 18px;
  box-shadow: 0 12px 28px rgba(0,0,0,.07);
}

.card h5 {
  font-weight: 600;
  margin-bottom: 14px;
}

.chart-box {
  height: 440px; /* large, readable charts */
}
</style>
</head>

<body>

<div class="container py-5">
  <div class="text-center mb-5">
    <h2>Analytics Dashboard</h2>
    <p class="text-muted mb-1">Plotly • NBP Public API</p>
    <p class="text-muted small">Mirzayusif Mirzayev — 68843</p>
  </div>

  <div class="row g-4 justify-content-center">

    <!-- USD -->
    <div class="col-lg-10">
      <div class="card p-4">
        <h5>USD → PLN (last 20 days)</h5>
        <div id="chart_usd" class="chart-box"></div>
      </div>
    </div>

    <!-- CHF -->
    <div class="col-lg-10">
      <div class="card p-4">
        <h5>CHF → PLN (last 20 days)</h5>
        <div id="chart_chf" class="chart-box"></div>
      </div>
    </div>

  </div>
</div>

<script>
const layoutBase = {
  paper_bgcolor: "transparent",
  plot_bgcolor: "transparent",
  margin: { t: 30, l: 55, r: 30, b: 55 },
  xaxis: { tickfont: { size: 11 } },
  yaxis: { tickfont: { size: 11 } }
};

const config = {
  displayModeBar: false,
  responsive: true
};

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
    line: { width: 3, color: "#2563eb" },
    marker: { size: 6 }
  }], layoutBase, config);

  Plotly.newPlot("chart_chf", [{
    x: chf.rates.map(r => r.effectiveDate),
    y: chf.rates.map(r => r.mid),
    mode: "lines+markers",
    line: { width: 3, color: "#16a34a" },
    marker: { size: 6 }
  }], layoutBase, config);
}

drawCurrencyCharts();
</script>

</body>
</html>
