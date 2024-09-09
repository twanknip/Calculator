<?php
require 'db_config.php';

// Handle POST requests for adding, updating, or deleting models
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $brand_id = $_POST['brand_id'];
            $name = $_POST['name'];
            $stmt = $conn->prepare("INSERT INTO models (brand_id, name) VALUES (?, ?)");
            $stmt->bind_param('is', $brand_id, $name);
            $stmt->execute();
        } elseif ($_POST['action'] == 'update') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $stmt = $conn->prepare("UPDATE models SET name = ? WHERE id = ?");
            $stmt->bind_param('si', $name, $id);
            $stmt->execute();
        } elseif ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM models WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
    }
}

// Fetch models with brand information
$result = $conn->query("SELECT models.id, models.name, brands.name AS brand_name FROM models JOIN brands ON models.brand_id = brands.id");
$models = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($models);
?>
