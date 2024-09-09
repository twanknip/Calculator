<?php
require_once 'Database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT idUsers, password FROM users";
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);
    $update_query = "UPDATE users SET password = :password WHERE idUsers = :id";
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':password', $hashed_password);
    $update_stmt->bindParam(':id', $row['idUsers']);
    $update_stmt->execute();
}

echo "Wachtwoorden zijn succesvol bijgewerkt.";
?>
