<?php
require 'db_config.php';

// Handle POST requests for adding or updating brands
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $name = $_POST['name'];
            $stmt = $conn->prepare("INSERT INTO brands (name) VALUES (?)");
            $stmt->bind_param('s', $name);
            $stmt->execute();
        } elseif ($_POST['action'] == 'update') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $stmt = $conn->prepare("UPDATE brands SET name = ? WHERE id = ?");
            $stmt->bind_param('si', $name, $id);
            $stmt->execute();
        } elseif ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM brands WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
    }
}

// Fetch brands
$result = $conn->query("SELECT * FROM brands");
$brands = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($brands);
?>


