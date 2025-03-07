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

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/", $nombre)) {
        $response['error'] = "El nombre solo puede contener letras y espacios.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/", $apellidos)) {
        $response['error'] = "Los apellidos solo pueden contener letras y espacios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = "El email no es válido.";
    } elseif (!preg_match("/^\d{9}$/", $telefono)) {
        $response['error'] = "El teléfono debe contener 9 números.";
    } elseif (strtotime($fecha_nacimiento) >= strtotime(date('Y-m-d'))) {
        $response['error'] = "La fecha de nacimiento debe ser anterior a hoy.";
    } elseif (!preg_match("/^[a-zA-Z0-9_.]+$/", $usuario)) {
        $response['error'] = "El nombre de usuario solo puede contener letras, números, guiones bajos y puntos.";
    } else {
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
}

echo json_encode($response);
?>