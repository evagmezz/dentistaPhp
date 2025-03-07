<?php
include("config.php");
global $conn;
session_start();

if ($_SESSION['rol'] != 'admin') {
    header("location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $sexo = $_POST['sexo'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

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
    } elseif (!preg_match("/^[a-zA-Z0-9_.]+$/", $usuario)) {
        $error = "El nombre de usuario solo puede contener letras, números, guiones bajos y puntos.";
    } else {
        $checkEmail = $conn->query("SELECT * FROM users_data WHERE email='$email'");
        $checkUser = $conn->query("SELECT * FROM users_login WHERE usuario='$usuario'");

        if ($checkEmail->num_rows > 0 || $checkUser->num_rows > 0) {
            $error = "El email o el nombre de usuario ya están registrados.";
        } else {
            $conn->query("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES ('$nombre', '$apellidos', '$email', '$telefono', '$fecha_nacimiento', '$direccion', '$sexo')");
            $idUser = $conn->insert_id;

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $conn->query("INSERT INTO users_login (idUser, usuario, password, rol) VALUES ('$idUser', '$usuario', '$hashedPassword', '$rol')");
        }
    }
}

$result = $conn->query("SELECT * FROM users_login");
?>

<?php include("header.php"); ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administración de Usuarios</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <div class="admin-page">
        <h2>Administración de Usuarios</h2>
        <form action="usuarios-administracion.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellidos" placeholder="Apellidos" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="date" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" required>
            <textarea name="direccion" placeholder="Dirección"></textarea>
            <select name="sexo" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <select name="rol" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="create">Crear Usuario</button>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>

        <h2>Usuarios Existentes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>usuario</th>
                <th>rol</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idUser']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['rol']; ?></td>
                    <td>
                        <form action="usuarios-administracion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['idUser']; ?>">
                            <input type="text" name="usuario" value="<?php echo $row['usuario']; ?>" required>
                            <input type="password" name="password" placeholder="Nueva contraseña">
                            <select name="rol" required>
                                <option value="user" <?php if ($row['rol'] == 'user') echo 'selected'; ?>>User</option>
                                <option value="admin" <?php if ($row['rol'] == 'admin') echo 'selected'; ?>>Admin</option>
                            </select>
                            <button type="submit" name="update">Modificar</button>
                        </form>
                        <form action="usuarios-administracion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['idUser']; ?>">
                            <button type="submit" name="delete">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    </body>
    </html>
<?php include("footer.php"); ?>