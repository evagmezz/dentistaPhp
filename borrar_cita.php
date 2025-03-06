<?php
include("config.php");
global $conn;
session_start();

$idCita = $_POST['idCita'];

$stmt = $conn->prepare("DELETE FROM citas WHERE idCita = ? AND fecha_cita >= CURDATE()");
$stmt->bind_param("i", $idCita);
$stmt->execute();
$stmt->close();

header("Location: citaciones.php");
?>