<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publicar Artículo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include("include/menu.php");
     menu();
    ?>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
          <div class="card-header text-white" style="background-color: #F37E00;">
            <h3 class="mb-0">Publicar un Nuevo Artículo</h3>
          </div>
          <div class="card-body">
            <form action="guardar_articulo.php" method="POST" enctype="multipart/form-data">
              <!-- Título -->
              <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" name="titulo" id="titulo" required>
              </div>

              <!-- Contenido -->
              <div class="mb-3">
                <label for="contenido" class="form-label">Contenido</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="3" required></textarea>
              </div>

              <!-- Categoría -->
              <div class="mb-4">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" name="categoria" id="categoria" required>
                  <option value="">-- Selecciona una categoría --</option>
                  <option value="Economía">Economía</option>
                  <option value="Espectáculos">Espectáculos</option>
                  <option value="Política">Política</option>
                </select>
              </div>

              <div class="mb-4">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
              </div>
                            

              <!-- Botón -->
              <div class="d-grid">
                <button type="submit" class="btn text-white" style="background-color: #F37E00;">Publicar Artículo</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="text-center text-black py-3" style="background-color: #F37E00;">
    <p class="mb-0">&copy; 2025 MiBlog. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
