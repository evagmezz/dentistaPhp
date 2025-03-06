<?php
global $conn;
include("config.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users_login WHERE usuario=?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['idUser'] = $user['idUser'];
        $response['success'] = true;
    } else {
        $response['error'] = "Usuario o contraseña incorrectos.";
    }
}

echo json_encode($response);
?>
