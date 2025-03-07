<?php
include("config.php");
session_start();
global $conn;

$idUser = $_SESSION['idUser'];
$fecha_cita = $_POST['fecha_cita'];
$motivo_cita = $_POST['motivo_cita'];

if (strtotime($fecha_cita) <= strtotime(date('Y-m-d'))) {
    $error = "La fecha de la cita debe ser posterior a hoy.";
    echo "<script>alert('$error'); window.location.href = 'citaciones.php';</script>";
    exit();
}

$stmt = $conn->prepare("INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $idUser, $fecha_cita, $motivo_cita);
$stmt->execute();
$stmt->close();

header("Location: citaciones.php");
?>