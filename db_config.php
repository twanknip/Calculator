<?php
$servername = "localhost";
$username = "twan";
$password = "B75fu57g$";
$dbname = "mkv_form";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
