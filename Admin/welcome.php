<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to login page
    exit();
}

require_once 'Database.php';
require_once 'Brand.php';
require_once 'Model.php';

$db = (new Database())->connect();
if (!$db) {
    die("Database connection failed.");
}
$brandObj = new Brand($db);
$modelObj = new Model($db);

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Brand actions
    if (isset($_POST['createBrand'])) {
        $brandObj->name = $_POST['brandName'];
        $brandObj->create();
    } elseif (isset($_POST['updateBrand'])) {
        $brandObj->id = $_POST['brandId'];
        $brandObj->name = $_POST['brandName'];
        $brandObj->update();
    } elseif (isset($_POST['deleteBrand'])) {
        $brandObj->id = $_POST['brandId'];
        $brandObj->delete();
    }

    // Model actions
    if (isset($_POST['createModel'])) {
        $modelObj->brand_id = $_POST['brandId'];
        $modelObj->name = $_POST['modelName'];
        $modelObj->create();
    } elseif (isset($_POST['updateModel'])) {
        $modelObj->id = $_POST['modelId'];
        $modelObj->brand_id = $_POST['brandId'];
        $modelObj->name = $_POST['modelName'];
        $modelObj->update();
    } elseif (isset($_POST['deleteModel'])) {
        $modelObj->id = $_POST['modelId'];
        $modelObj->delete();
    }
}

// Fetch all brands and models
$brands = $brandObj->readAll();
$models = $modelObj->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<h2>Beheer Merken</h2>
<form method="POST">
    <input type="hidden" name="brandId" value="">
    <input type="text" name="brandName" placeholder="Merknaam" required>
    <button type="submit" name="createBrand">Voeg Toe</button>
    <button type="submit" name="updateBrand">Bijwerken</button>
    <button type="submit" name="deleteBrand">Verwijderen</button>
</form>

<h2>Merkenlijst</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Naam</th>
        <th>Acties</th>
    </tr>
    <?php while ($row = $brands->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']); ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td>
                <a href="manage.php?type=brand&id=<?= htmlspecialchars($row['id']); ?>" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="manage.php?type=brand&id=<?= htmlspecialchars($row['id']); ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this brand?');">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Beheer Modellen</h2>
<form method="POST">
    <input type="hidden" name="modelId" value="">
    <input type="text" name="modelName" placeholder="Modelnaam" required>
    <input type="number" name="brandId" placeholder="Merk ID" required>
    <button type="submit" name="createModel">Voeg Toe</button>
    <button type="submit" name="updateModel">Bijwerken</button>
    <button type="submit" name="deleteModel">Verwijderen</button>
</form>

<h2>Modellenlijst</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Merk ID</th>
        <th>Naam</th>
        <th>Acties</th>
    </tr>
    <?php while ($row = $models->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']); ?></td>
            <td><?= htmlspecialchars($row['brand_id']); ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td>
                <a href="manage.php?type=model&id=<?= htmlspecialchars($row['id']); ?>" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="manage.php?type=model&id=<?= htmlspecialchars($row['id']); ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this model?');">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Logout Button -->
<form action="logout.php" method="post">
    <button type="submit">Logout</button>
</form>

</body>
</html>

