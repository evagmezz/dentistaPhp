<?php
global $conn;
include("config.php");
$result = $conn->query("SELECT n.titulo, n.imagen, n.texto, n.fecha, u.nombre FROM noticias n JOIN users_data u ON n.idUser = u.idUser ORDER BY n.fecha DESC");
?>

<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias - Clínica Dental</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="news-page">
    <div class="news-grid">
        <?php if (isset($_SESSION['idUser'])): ?>
        <button id="add-news-btn" class="add-news-btn">+</button>
        <?php endif; ?>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='news-item'>";
            echo "<img src='img/{$row['imagen']}' alt='{$row['titulo']}'>";
            echo "<h3>{$row['titulo']}</h3>";
            echo "<p>{$row['texto']}</p>";
            echo "<p class='author'>Por: {$row['nombre']}</p>";
            echo "<p class='date'>{$row['fecha']}</p>";
            echo "</div>";
        }
        ?>
    </div>
</div>
<script src="script.js"></script>
</body>
<?php include("footer.php"); ?>
</html>