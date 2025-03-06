<?php
include("config.php");
global $conn;
session_start();

if ($_SESSION['rol'] != 'admin') {
    header("location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $direccion = $_POST['direccion'];
        $sexo = $_POST['sexo'];
        $usuario = $_POST['usuario'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
        $rol = $_POST['rol'];

        $conn->query("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES ('$nombre', '$apellidos', '$email', '$telefono', '$fecha_nacimiento', '$direccion', '$sexo')");
        $idUser = $conn->insert_id;

        $conn->query("INSERT INTO users_login (idUser, usuario, password, rol) VALUES ('$idUser', '$usuario', '$password', '$rol')");
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $rol = $_POST['rol'];

        $conn->query("UPDATE users_login SET usuario = '$usuario', password = '$password', rol = '$rol' WHERE idUser = $id");
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $conn->query("DELETE FROM users_login WHERE idUser = $id");

        $conn->query("DELETE FROM users_data WHERE idUser = $id");
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