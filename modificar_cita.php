<?php
include("config.php");
session_start();
global $conn;

$idCita = $_POST['idCita'];
$fecha_cita = $_POST['fecha_cita'];
$motivo_cita = $_POST['motivo_cita'];

$stmt = $conn->prepare("UPDATE citas SET fecha_cita = ?, motivo_cita = ? WHERE idCita = ? AND fecha_cita >= CURDATE()");
$stmt->bind_param("ssi", $fecha_cita, $motivo_cita, $idCita);
$stmt->execute();
$stmt->close();

header("Location: citaciones.php");
?>