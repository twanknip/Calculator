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

$type = $_GET['type'] ?? ''; // 'brand' or 'model'
$id = $_GET['id'] ?? '';

if ($type == 'brand') {
    $brandObj->id = $id;
    $brandObj->readSingle(); // Load brand data
} elseif ($type == 'model') {
    $modelObj->id = $id;
    $modelObj->readSingle(); // Load model data
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type == 'brand') {
        if (isset($_POST['updateBrand'])) {
            $brandObj->name = $_POST['brandName'];
            $brandObj->update();
            header("Location: welcome.php"); // Redirect after update
            exit();
        } elseif (isset($_POST['deleteBrand'])) {
            $brandObj->delete();
            header("Location: welcome.php"); // Redirect after delete
            exit();
        }
    } elseif ($type == 'model') {
        if (isset($_POST['updateModel'])) {
            $modelObj->name = $_POST['modelName'];
            $modelObj->brand_id = $_POST['brandId'];
            $modelObj->update();
            header("Location: welcome.php"); // Redirect after update
            exit();
        } elseif (isset($_POST['deleteModel'])) {
            $modelObj->delete();
            header("Location: welcome.php"); // Redirect after delete
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage <?= htmlspecialchars($type); ?></title>
</head>
<body>
<h2>Manage <?= htmlspecialchars($type); ?></h2>

<?php if ($type == 'brand'): ?>
    <form method="POST">
        <input type="hidden" name="brandId" value="<?= htmlspecialchars($brandObj->id); ?>">
        <input type="text" name="brandName" value="<?= htmlspecialchars($brandObj->name); ?>" required>
        <button type="submit" name="updateBrand">Update</button>
        <button type="submit" name="deleteBrand" onclick="return confirm('Are you sure you want to delete this brand?');">Delete</button>
    </form>
<?php elseif ($type == 'model'): ?>
    <form method="POST">
        <input type="hidden" name="modelId" value="<?= htmlspecialchars($modelObj->id); ?>">
        <input type="text" name="modelName" value="<?= htmlspecialchars($modelObj->name); ?>" required>
        <input type="number" name="brandId" value="<?= htmlspecialchars($modelObj->brand_id); ?>" required>
        <button type="submit" name="updateModel">Update</button>
        <button type="submit" name="deleteModel" onclick="return confirm('Are you sure you want to delete this model?');">Delete</button>
    </form>
<?php else: ?>
    <p>Invalid type specified.</p>
<?php endif; ?>

</body>
</html>
