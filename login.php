<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clínica Dental</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body class="login-body">
<div class="login-page">
    <h2>Iniciar Sesión</h2>
    <form id="loginForm">
        <input type="text" id="usuario" name="usuario" required placeholder="Usuario">
        <input type="password" id="password" name="password" required placeholder="Contraseña">
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
    <p id="message"></p>
</div>
</body>
</html>
<?php include("footer.php"); ?>
