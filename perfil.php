<?php
session_start();
include("config.php");
global $conn;

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit();
}
$idUser = $_SESSION['idUser'];
$query = $conn->prepare("SELECT * FROM users_data u JOIN users_login l ON u.idUser = l.idUser WHERE u.idUser = ?");
$query->bind_param("i", $idUser);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $sexo = $_POST['sexo'];
    $password = $_POST['password'];

    // Validations
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/", $nombre)) {
        $error = "El nombre solo puede contener letras y espacios.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/", $apellidos)) {
        $error = "Los apellidos solo pueden contener letras y espacios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El email no es válido.";
    } elseif (!preg_match("/^\d{9}$/", $telefono)) {
        $error = "El teléfono debe contener 9 números.";
    } elseif (strtotime($fecha_nacimiento) >= strtotime(date('Y-m-d'))) {
        $error = "La fecha de nacimiento debe ser anterior a hoy.";
    } else {
        $updateQuery = $conn->prepare("UPDATE users_data SET nombre = ?, apellidos = ?, email = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, sexo = ? WHERE idUser = ?");
        $updateQuery->bind_param("sssssssi", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $idUser);
        $updateQuery->execute();

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updatePasswordQuery = $conn->prepare("UPDATE users_login SET password = ? WHERE idUser = ?");
            $updatePasswordQuery->bind_param("si", $hashedPassword, $idUser);
            $updatePasswordQuery->execute();
        }

        header("Location: perfil.php");
        exit();
    }
}
?>

<?php include("header.php"); ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil - Clínica Dental</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <div class="profile-card">
        <h2>Perfil</h2>
        <form method="POST" action="perfil.php">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($user['apellidos']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($user['fecha_nacimiento']); ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($user['direccion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required>
                    <option value="Masculino" <?php if ($user['sexo'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                    <option value="Femenino" <?php if ($user['sexo'] == 'Femenino') echo 'selected'; ?>>Femenino</option>
                    <option value="Otro" <?php if ($user['sexo'] == 'Otro') echo 'selected'; ?>>Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($user['usuario']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Dejar en blanco para no cambiar">
            </div>
            <button type="submit">Actualizar</button>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
    <script src="script.js"></script>
    </body>
    </html>
<?php include("footer.php"); ?>