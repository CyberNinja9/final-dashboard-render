<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analytics Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<style>
body { background:#f5f7fb; }
.card {
  border-radius:16px;
  border:none;
  box-shadow:0 10px 25px rgba(0,0,0,.08);
}
.chart { height:300px; }
</style>
</head>

<body>
<div class="container py-5">
<h2 class="text-center mb-5">Analytics Dashboard</h2>

<div class="row g-4">

<div class="col-md-6"><div class="card p-4">
<h5>Products by Category</h5>
<div id="cat" class="chart"></div>
</div></div>

<div class="col-md-6"><div class="card p-4">
<h5>Product Prices</h5>
<div id="prices" class="chart"></div>
</div></div>

<div class="col-md-6"><div class="card p-4">
<h5>Transactions by Response Code</h5>
<div id="resp" class="chart"></div>
</div></div>

<div class="col-md-6"><div class="card p-4">
<h5>Transaction Amounts</h5>
<div id="amounts" class="chart"></div>
</div></div>

<div class="col-md-6"><div class="card p-4">
<h5>USD → PLN (last 20 days)</h5>
<div id="usd" class="chart"></div>
</div></div>

<div class="col-md-6"><div class="card p-4">
<h5>CHF → PLN (last 20 days)</h5>
<div id="chf" class="chart"></div>
</div></div>

</div>
</div>

<script>
// STATIC APIs (yours)
const products = [
 {category:"Electronics",total:120},
 {category:"Furniture",total:80},
 {category:"Kitchen",total:60}
];

const prices = [
 {name:"Laptop",price:1200},
 {name:"Office Chair",price:180},
 {name:"Coffee Mug",price:25}
];

const resp = [
 {response_code:200,total:40},
 {response_code:400,total:20},
 {response_code:500,total:10}
];

const amounts = [
 {order_id:1,amount:120},
 {order_id:2,amount:240},
 {order_id:3,amount:180},
 {order_id:4,amount:320}
];

// Charts
Plotly.newPlot("cat",[{
 labels:products.map(x=>x.category),
 values:products.map(x=>x.total),
 type:"pie",
 hole:.4
}]);

Plotly.newPlot("prices",[{
 x:prices.map(x=>x.name),
 y:prices.map(x=>x.price),
 type:"bar"
}]);

Plotly.newPlot("resp",[{
 labels:resp.map(x=>"Code "+x.response_code),
 values:resp.map(x=>x.total),
 type:"pie",
 hole:.4
}]);

Plotly.newPlot("amounts",[{
 x:amounts.map(x=>x.order_id),
 y:amounts.map(x=>x.amount),
 type:"bar"
}]);

// NBP live
fetch("https://api.nbp.pl/api/exchangerates/rates/a/usd/last/20/?format=json")
.then(r=>r.json())
.then(d=>{
 Plotly.newPlot("usd",[{
  x:d.rates.map(r=>r.effectiveDate),
  y:d.rates.map(r=>r.mid),
  mode:"lines+markers"
 }]);
});

fetch("https://api.nbp.pl/api/exchangerates/rates/a/chf/last/20/?format=json")
.then(r=>r.json())
.then(d=>{
 Plotly.newPlot("chf",[{
  x:d.rates.map(r=>r.effectiveDate),
  y:d.rates.map(r=>r.mid),
  mode:"lines+markers"
 }]);
});
</script>
</body>
</html>
