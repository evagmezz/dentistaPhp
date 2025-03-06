<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticia - Clínica Dental</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="create-news-page">
    <h2>Crear Noticia</h2>
    <form id="createNewsForm" action="create_news_process.php" method="POST" enctype="multipart/form-data">
        <input type="text" id="titulo" name="titulo" required placeholder="Título">
        <input type="file" id="imagen" name="imagen" accept="image/*" required>
        <textarea id="texto" name="texto" required placeholder="Noticia"></textarea>

        <button type="submit">Crear Noticia</button>
    </form>
</div>
</body>
</html>
<?php include("footer.php"); ?>
