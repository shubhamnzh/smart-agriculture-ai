<?php
include "disease_data.php";

$disease = $_GET['disease'] ?? '';

if(isset($diseases[$disease])){

$data = $diseases[$disease];

echo "
<div class='card mt-3 p-3 text-start shadow'>
<h5 class='text-success'>📖 Description</h5>
<p>{$data['description']}</p>

<h5 class='text-danger'>🦠 Causes</h5>
<p>{$data['causes']}</p>

<h5 class='text-primary'>💊 Treatment</h5>
<p>{$data['treatment']}</p>

<h5 class='text-warning'>🛡 Precautions</h5>
<p>{$data['precautions']}</p>

<h5 class='text-dark'>👨‍🌾 Advice</h5>
<p>{$data['advice']}</p>
</div>
";

}else{
echo "<div class='alert alert-warning mt-3'>No data available</div>";
}
?>
