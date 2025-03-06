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
        $idUser = $_POST['idUser'];
        $fecha_cita = $_POST['fecha_cita'];
        $motivo_cita = $_POST['motivo_cita'];

        $conn->query("INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$idUser', '$fecha_cita', '$motivo_cita')");
    } elseif (isset($_POST['update'])) {
        $idCita = $_POST['idCita'];
        $fecha_cita = $_POST['fecha_cita'];
        $motivo_cita = $_POST['motivo_cita'];

        $conn->query("UPDATE citas SET fecha_cita = '$fecha_cita', motivo_cita = '$motivo_cita' WHERE idCita = $idCita");
    } elseif (isset($_POST['delete'])) {
        $idCita = $_POST['idCita'];

        $conn->query("DELETE FROM citas WHERE idCita = $idCita");
    }
}

$users = $conn->query("SELECT idUser, usuario FROM users_login");
$citas = $conn->query("SELECT c.idCita, c.fecha_cita, c.motivo_cita, u.usuario FROM citas c JOIN users_login u ON c.idUser = u.idUser");
?>

<?php include("header.php"); ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administración de Citas</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <div class="admin-page">
        <h2>Administración de Citas</h2>
        <form action="citas-administracion.php" method="POST">
            <select name="idUser" required>
                <option value="">Seleccionar Usuario</option>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <option value="<?php echo $user['idUser']; ?>"><?php echo $user['usuario']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="date" name="fecha_cita" placeholder="Fecha de la Cita" required>
            <textarea name="motivo_cita" placeholder="Motivo de la Cita" required></textarea>
            <button type="submit" name="create">Crear Cita</button>
        </form>

        <h2>Citas Existentes</h2>
        <table>
            <tr>
                <th>ID Cita</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
            <?php while ($cita = $citas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $cita['idCita']; ?></td>
                    <td><?php echo $cita['fecha_cita']; ?></td>
                    <td><?php echo $cita['motivo_cita']; ?></td>
                    <td><?php echo $cita['usuario']; ?></td>
                    <td>
                        <form action="citas-administracion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idCita" value="<?php echo $cita['idCita']; ?>">
                            <input type="date" name="fecha_cita" value="<?php echo $cita['fecha_cita']; ?>" required>
                            <textarea name="motivo_cita" required><?php echo $cita['motivo_cita']; ?></textarea>
                            <button type="submit" name="update">Modificar</button>
                        </form>
                        <form action="citas-administracion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idCita" value="<?php echo $cita['idCita']; ?>">
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