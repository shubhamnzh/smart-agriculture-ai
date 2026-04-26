<?php
include "disease_data.php";

$d = $_GET['disease'] ?? '';

if(isset($diseases[$d])){
    $x = $diseases[$d];

    echo "
    <div class='card p-3 mt-3'>
    <h5>🦠 Description</h5>
    <p>{$x['description']}</p>

    <h5>💊 Treatment</h5>
    <p>{$x['treatment']}</p>

    <h5>🛡 Prevention</h5>
    <p>{$x['prevention']}</p>
    </div>
    ";
}
?>
