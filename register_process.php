<?php
global $conn;
include("config.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $sexo = $_POST['sexo'];
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $rol = 'user';


    $checkEmail = $conn->query("SELECT * FROM users_data WHERE email='$email'");
    $checkUser = $conn->query("SELECT * FROM users_login WHERE usuario='$usuario'");

    if ($checkEmail->num_rows > 0 || $checkUser->num_rows > 0) {
        $response['error'] = "El email o el nombre de usuario ya están registrados.";
    } else {

        $stmt = $conn->prepare("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);
        $stmt->execute();
        $idUser = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO users_login (idUser, usuario, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $idUser, $usuario, $password, $rol);
        $stmt->execute();
        $stmt->close();

        $response['success'] = true;
    }
}

echo json_encode($response);
?>