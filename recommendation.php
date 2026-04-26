<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Crop Recommendation</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>🌱 Crop Recommendation</h2>

<form method="post">
<input type="text" name="soil" placeholder="Soil type" class="form-control mb-2">
<input type="text" name="weather" placeholder="Weather" class="form-control mb-2">
<button class="btn btn-success">Recommend</button>
</form>

<?php
if(isset($_POST['soil'])){
    echo "<div class='alert alert-success mt-3'>🌽 Recommended Crop: Maize</div>";
}
?>

</body>
</html>
