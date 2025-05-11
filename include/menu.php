<?php

function menu(){ ?>
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
                  <li><a class="dropdown-item" href="index.php?categoria=Espectaculos">Espectaculos</a></li>
                  <li><a class="dropdown-item" href="index.php?categoria=Política">Política</a></li>
                  <!--<li><a class="dropdown-item" href="#">Todas las categorías</a></li>-->
                </ul>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="crear_articulo.php">Publicar Artículo</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<?php
}
?>