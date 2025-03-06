<?php
global $conn;
include("config.php");
$result = $conn->query("SELECT titulo, imagen, texto, fecha FROM noticias ORDER BY fecha DESC LIMIT 2");
?>
<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Clínica Dental</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/clinicadental1.png" alt="Clínica Dental 1">
        </div>
        <div class="carousel-item">
            <img src="img/clinicadental2.png" alt="Clínica Dental 2">
        </div>
        <div class="carousel-item">
            <img src="img/clinicadental3.png" alt="Clínica Dental 3">
        </div>
        <div class="carousel-item">
            <img src="img/clinicadental4.png" alt="Clínica Dental 4">
        </div>
    </div>
</div>
<div class="description">
    <h2>Bienvenidos a nuestra Clínica Dental</h2>
    <p>Ubicada en Calle Napoleón 123, nuestra clínica ofrece los mejores servicios dentales con un equipo de
        profesionales altamente calificados. Nos especializamos en una amplia gama de tratamientos para asegurar la
        salud y la belleza de tu sonrisa.</p>
</div>
<div class="last-news">
    <h2><a href="noticias.php">Últimas noticias</a></h2>
    <div class="news-list">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='news-item'>";
            echo "<img src='img/{$row['imagen']}' alt='{$row['titulo']}'>";
            echo "<h3>{$row['titulo']}</h3>";
            echo "<p>{$row['texto']}</p>";
            echo "<p class='date'>{$row['fecha']}</p>";
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
<?php include("footer.php"); ?>
</html>
