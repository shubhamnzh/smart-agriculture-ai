<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(to right, #e6f7ec, #ffffff);
}
.card {
    border-radius: 20px;
}
</style>

</head>

<body>

<nav class="navbar navbar-dark bg-success">
<div class="container">
<span class="navbar-brand">🌿 Smart Agriculture AI</span>
<a href="logout.php" class="btn btn-light">Logout</a>
</div>
</nav>

<div class="container mt-5">

<div class="row g-4 text-center">

<div class="col-md-4">
<div class="card p-4">
<h4>🧠 Detection</h4>
<a href="detect.php" class="btn btn-success mt-3">Start</a>
</div>
</div>

<div class="col-md-4">
<div class="card p-4">
<h4>🌱 Recommendation</h4>
<a href="recommendation.php" class="btn btn-success mt-3">Open</a>
</div>
</div>

<div class="col-md-4">
<div class="card p-4">
<h4>📊 History</h4>
<a href="admin.php" class="btn btn-success mt-3">View</a>
</div>
</div>

</div>

</div>

</body>
</html>
