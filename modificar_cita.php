<?php
include("config.php");
session_start();
global $conn;

$idCita = $_POST['idCita'];
$fecha_cita = $_POST['fecha_cita'];
$motivo_cita = $_POST['motivo_cita'];

if (strtotime($fecha_cita) <= strtotime(date('Y-m-d'))) {
    $error = "La fecha de la cita debe ser posterior a hoy.";
    echo "<script>alert('$error'); window.location.href = 'citaciones.php';</script>";
    exit();
}

$stmt = $conn->prepare("UPDATE citas SET fecha_cita = ?, motivo_cita = ? WHERE idCita = ?");
$stmt->bind_param("ssi", $fecha_cita, $motivo_cita, $idCita);
$stmt->execute();
$stmt->close();

header("Location: citaciones.php");
?>