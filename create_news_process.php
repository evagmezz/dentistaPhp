<?php
global $conn;
include("config.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    if (!isset($_SESSION['idUser'])) {
        $response['error'] = "User not logged in.";
        echo json_encode($response);
        exit;
    }

    $idUser = $_SESSION['idUser'];
    $fecha = date('Y-m-d');

    $stmt = $conn->prepare("SELECT idUser FROM users_data WHERE idUser = ?");
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $response['error'] = "Invalid user ID.";
        echo json_encode($response);
        exit;
    }

    $stmt->close();

    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];

    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        $imagen = basename($_FILES["imagen"]["name"]);
    } else {
        $response['error'] = "Error al subir la imagen.";
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $titulo, $imagen, $texto, $fecha, $idUser);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['error'] = "Error al crear la noticia.";
    }

    $stmt->close();
}

echo json_encode($response);
?>