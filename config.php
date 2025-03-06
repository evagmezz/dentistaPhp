<?php
$host = "localhost";
$user = "root";
$password = "Ev@2003.";
$database = "bbdd";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>