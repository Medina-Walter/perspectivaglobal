<?php
function menu()
{ ?>
  <nav class="navbar navbar-expand-lg py-1" style="background-color: #F37E00;">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MiBlog</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Menú">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContenido">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Artículos</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Categorías</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="index.php?categoria=Economía">Economía</a></li>
              <li><a class="dropdown-item" href="index.php?categoria=Espectáculos">Espectáculos</a></li>
              <li><a class="dropdown-item" href="index.php?categoria=Política">Política</a></li>
            </ul>
          </li>
            <li class="nav-item">
              <a class="nav-link" href="crear_articulo.php">Publicar Artículo</a>
            </li>
              <?php if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true): ?>
            <li class="nav-item">
              <a class="nav-link" href="cerrar_sesion.php">Cerrar Sesión</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="registro.php">Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Iniciar Sesión</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
<?php
}
?>