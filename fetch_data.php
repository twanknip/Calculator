<?php
include 'db_config.php';

// Fetch brands
$brandsQuery = "SELECT DISTINCT brand FROM coffee_machines";
$brandsResult = $conn->query($brandsQuery);

$brands = [];
if ($brandsResult->num_rows > 0) {
    while ($row = $brandsResult->fetch_assoc()) {
        $brands[] = $row['brand'];
    }
}

// Fetch models by brand
$modelsQuery = "SELECT brand, model FROM coffee_machines";
$modelsResult = $conn->query($modelsQuery);

$models = [];
if ($modelsResult->num_rows > 0) {
    while ($row = $modelsResult->fetch_assoc()) {
        $models[$row['brand']][] = $row['model'];
    }
}

$conn->close();

echo json_encode([
    'brands' => $brands,
    'models' => $models,
]);
?>
