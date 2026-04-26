<?php
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $_SESSION['user'] = $_POST['username'];
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: url('https://images.unsplash.com/photo-1464226184884-fa280b87c399') no-repeat center/cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.card {
    border-radius: 20px;
}
</style>

</head>

<body>

<div class="card p-4" style="width:320px;">
<h4 class="text-center text-success">🌿 Farmer Login</h4>

<form method="post">
<input type="text" name="username" class="form-control mt-3" placeholder="Username" required>
<input type="password" class="form-control mt-3" placeholder="Password" required>

<button class="btn btn-success w-100 mt-3">Login</button>
</form>

</div>

</body>
</html>
