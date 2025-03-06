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
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];
        $fecha = date('Y-m-d');

        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen = basename($_FILES["imagen"]["name"]);
            $conn->query("INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES ('$titulo', '$imagen', '$texto', '$fecha', {$_SESSION['idUser']})");
        } else {
            echo "Error uploading image.";
        }
    } elseif (isset($_POST['update'])) {
        $idNoticia = $_POST['idNoticia'];
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];

        if (!empty($_FILES["imagen"]["name"])) {
            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $imagen = basename($_FILES["imagen"]["name"]);
                $conn->query("UPDATE noticias SET titulo = '$titulo', texto = '$texto', imagen = '$imagen' WHERE idNoticia = $idNoticia");
            } else {
                echo "Error uploading image.";
            }
        } else {
            $conn->query("UPDATE noticias SET titulo = '$titulo', texto = '$texto' WHERE idNoticia = $idNoticia");
        }
    } elseif (isset($_POST['delete'])) {
        $idNoticia = $_POST['idNoticia'];
        $conn->query("DELETE FROM noticias WHERE idNoticia = $idNoticia");
    }
}

$noticias = $conn->query("SELECT * FROM noticias");
?>

<?php include("header.php"); ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administración de Noticias</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <div class="admin-page">
        <h2>Administración de Noticias</h2>
        <form action="noticias-administracion.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Título de la Noticia" required>
            <textarea name="texto" placeholder="Texto de la Noticia" required></textarea>
            <input type="file" name="imagen" required>
            <button type="submit" name="create">Crear Noticia</button>
        </form>

        <h2>Noticias Existentes</h2>
        <table>
            <tr>
                <th>ID Noticia</th>
                <th>Título</th>
                <th>Texto</th>
                <th>Fecha</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            <?php while ($noticia = $noticias->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $noticia['idNoticia']; ?></td>
                    <td><?php echo $noticia['titulo']; ?></td>
                    <td><?php echo $noticia['texto']; ?></td>
                    <td><?php echo $noticia['fecha']; ?></td>
                    <td><img src="img/<?php echo $noticia['imagen']; ?>" alt="<?php echo $noticia['titulo']; ?>" width="100"></td>
                    <td>
                        <form action="noticias-administracion.php" method="POST" enctype="multipart/form-data" style="display:inline;">
                            <input type="hidden" name="idNoticia" value="<?php echo $noticia['idNoticia']; ?>">
                            <input type="text" name="titulo" value="<?php echo $noticia['titulo']; ?>" required>
                            <textarea name="texto" required><?php echo $noticia['texto']; ?></textarea>
                            <input type="file" name="imagen">
                            <button type="submit" name="update">Modificar</button>
                        </form>
                        <form action="noticias-administracion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idNoticia" value="<?php echo $noticia['idNoticia']; ?>">
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