<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <h1>Dentista</h1>
    <nav>
        <ul>
            <li><a href="index.php"
                   class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Inicio</a></li>
            <li><a href="noticias.php"
                   class="<?php echo basename($_SERVER['PHP_SELF']) == 'noticias.php' ? 'active' : ''; ?>">Noticias</a>
            </li>

            <?php if (isset($_SESSION['idUser'])): ?>
                <li><a href="perfil.php"
                       class="<?php echo basename($_SERVER['PHP_SELF']) == 'perfil.php' ? 'active' : ''; ?>">Perfil</a>
                </li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                    <li><a href="usuarios-administracion.php">Administración de Usuarios</a></li>
                <?php else : ?>
                    <li><a href="citaciones.php"
                           class="<?php echo basename($_SERVER['PHP_SELF']) == 'citaciones.php' ? 'active' : ''; ?>">Citaciones</a>
                    </li>
                <?php endif; ?>
                <li><a href="logout.php">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>