<!DOCTYPE html>
<html>
<head>
<title>History</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>📊 Prediction History</h2>

<table class="table table-striped">
<thead>
<tr><th>Disease</th><th>Confidence</th></tr>
</thead>
<tbody id="historyTable"></tbody>
</table>

<script>
let history = JSON.parse(localStorage.getItem("history")) || [];
let table = document.getElementById("historyTable");

history.forEach(item=>{
table.innerHTML += `<tr><td>${item.disease}</td><td>${item.confidence}%</td></tr>`;
});
</script>

</body>
</html>
