<?php
include("config.php");
global $conn;
session_start();
?>
<?php include("header.php"); ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Citaciones - Clínica Dental</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <div class="citaciones-page">
        <h2>Solicitar Cita</h2>
        <form id="solicitarCitaForm" action="solicitar_cita.php" method="POST">
            <div class="form-row">
                <input type="date" id="fecha_cita" name="fecha_cita" required>
                <textarea id="motivo_cita" name="motivo_cita" required placeholder="Motivo de la cita"></textarea>
            </div>
            <button type="submit">Solicitar Cita</button>
        </form>

        <h2>Mis Citas</h2>
        <div class="mis-citas">
            <?php
            $usuario_id = $_SESSION['idUser'];
            $result = $conn->query("SELECT * FROM citas WHERE idUser = $usuario_id AND fecha_cita >= CURDATE()");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='cita-item'>";
                    echo "<p><strong>Fecha:</strong> {$row['fecha_cita']}</p>";
                    echo "<p><strong>Motivo:</strong> {$row['motivo_cita']}</p>";
                    echo "<div class='form-container'>";
                    echo "<form action='modificar_cita.php' method='POST'>";
                    echo "<div class='form-row'>";
                    echo "<input type='hidden' name='idCita' value='{$row['idCita']}'>";
                    echo "<input type='date' name='fecha_cita' value='{$row['fecha_cita']}' required>";
                    echo "<textarea name='motivo_cita' required>{$row['motivo_cita']}</textarea>";
                    echo "</div>";
                    echo "<button type='submit'>Modificar</button>";
                    echo "</form>";
                    echo "<form action='borrar_cita.php' method='POST'>";
                    echo "<input type='hidden' name='idCita' value='{$row['idCita']}'>";
                    echo "<button type='submit'>Borrar</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-citas'>No tienes citas pendientes</p>";
            }
            ?>
        </div>
    </div>
    </body>
    </html>
<?php include("footer.php"); ?>