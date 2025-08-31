<?php session_start(); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand">Perspectiva Global</a>

        <ul class="navbar-nav flex-row ms-auto">

            <!-- Si está logueado, mostrar Mi Perfil -->
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <li class="nav-item">
                    <a class="nav-link me-3" href="/blog_simple/usuarios/miperfil.php">Mi Perfil</a>
                </li>
            <?php endif; ?>

            <!-- Siempre mostrar Artículos -->
            <li class="nav-item">
                <a class="nav-link me-3" href="/blog_simple/index.php">Artículos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link me-3" href="/blog_simple/articulos/crear-articulo.php">Publicar Artículo</a>
            </li>

            <!-- Si NO está logueado, mostrar Registro e Inicio de sesión -->
            <?php if (!isset($_SESSION['id_usuario'])): ?>
                <li class="nav-item">
                    <a class="nav-link me-3" href="/blog_simple/usuarios/registro.php">Registrarse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-3" href="/blog_simple/usuarios/login.php">Iniciar Sesión</a>
                </li>
            <?php endif; ?>

            <!-- Si es admin, mostrar Usuarios -->
            <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link me-3" href="/blog_simple/usuarios/escritores.php">Usuarios</a>
                </li>
            <?php endif; ?>

            <!-- Si está logueado, mostrar Cerrar sesión -->
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <li class="nav-item">
                    <a class="nav-link me-3" href="/blog_simple/cerrar-sesion.php">Cerrar Sesión</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
