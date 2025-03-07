<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Clínica Dental</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body class="register-body">
<div class="register-page">
    <h2>Registro</h2>
    <form id="registerForm">
        <input type="text" id="nombre" name="nombre" required placeholder="Nombre">
        <input type="text" id="apellidos" name="apellidos" required placeholder="Apellidos">
        <input type="text" id="usuario" name="usuario" required placeholder="Nombre de Usuario">
        <input type="email" id="email" name="email" required placeholder="Email">
        <input type="text" id="telefono" name="telefono" required placeholder="Teléfono">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
        <textarea id="direccion" name="direccion" required placeholder="Dirección"></textarea>
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
        <input type="password" id="password" name="password" required placeholder="Contraseña">
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    <p id="message"></p>
</div>
</body>
</html>
<?php include("footer.php"); ?>
