<?php 
$titulo = "Inicio"; 
include("include/header.php"); 
include("include/menu.php"); 

if (isset($_SESSION['mensaje'])): ?>
<div class="container mt-3 w-50">
    <div class="alert alert-<?= $_SESSION['tipo']; ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php 
unset($_SESSION['mensaje'], $_SESSION['tipo']); 
endif; 
?>

<?php
require 'config.php';

// Palabra de búsqueda
$palabra = $_GET['palabra'] ?? '';

// Paginación
$articulosPorPagina = 8;
$paginaActual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $articulosPorPagina;

// Consulta principal
if (!empty($palabra)) {
    $sql = 'SELECT * FROM posts 
            WHERE titulo LIKE :palabra 
            ORDER BY fecha DESC 
            LIMIT :limit OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':palabra', "%$palabra%", PDO::PARAM_STR);
} else {
    $sql = 'SELECT * FROM posts 
            ORDER BY fecha DESC 
            LIMIT :limit OFFSET :offset';
    $stmt = $pdo->prepare($sql);
}

$stmt->bindValue(':limit', (int)$articulosPorPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar total de artículos
if (!empty($palabra)) {
    $sqlTotal = 'SELECT COUNT(*) FROM posts WHERE titulo LIKE :palabra';
    $stmtTotal = $pdo->prepare($sqlTotal);
    $stmtTotal->bindValue(':palabra', "%$palabra%", PDO::PARAM_STR);
    $stmtTotal->execute();
} else {
    $sqlTotal = 'SELECT COUNT(*) FROM posts';
    $stmtTotal = $pdo->query($sqlTotal);
}
$totalArticulos = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalArticulos / $articulosPorPagina);
?>

<!-- Buscador -->
<div class="container d-flex justify-content-end mb-3 mt-3">
  <form method="GET" action="index.php" class="d-flex">
    <input class="form-control me-2" type="search" name="palabra" 
           placeholder="Buscar por título..." 
           value="<?= htmlspecialchars($palabra) ?>">
    <button class="btn btn-outline-success" type="submit">Buscar</button>
  </form>
</div>

<!-- Listado de artículos -->
<div class="container mt-4 mb-5">
    <div class="row">
        <?php if (!empty($posts)) { ?>
            <?php foreach ($posts as $post) { ?>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                          <?php 
                          $portada = !empty($post['imagen']) ? $post['imagen'] : 'default-portada.png'; 
                          ?>
                            <img class="card-img-top img-fluid" 
                                 src="img/<?= htmlspecialchars($portada); ?>" 
                                 alt="imagen de portada"
                                 style="height:200px;">
                            <h4 class="card-title text-center mt-3"><?= htmlspecialchars($post['titulo']); ?></h4>
                            <p><?= htmlspecialchars($post['fecha']); ?></p>
                            <p class="card-text">
                                <?= htmlspecialchars(substr($post['contenido'], 0, 200)) . '...'; ?>
                            </p>
                            <a href="ver-post.php?id=<?= $post['id_post']; ?>" class="btn btn-primary">Leer más</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <h2 class="text-center">No hay Artículos Disponibles</h2>
        <?php } ?>
    </div>

    <!-- Paginación -->
    <?php if ($totalPaginas > 1): ?>
    <nav aria-label="Paginación de artículos">
      <ul class="pagination justify-content-center">
        <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>&palabra=<?= urlencode($palabra) ?>">Anterior</a>
        </li>

        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <li class="page-item <?= ($paginaActual == $i) ? 'active' : '' ?>">
            <a class="page-link" href="?pagina=<?= $i ?>&palabra=<?= urlencode($palabra) ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <li class="page-item <?= ($paginaActual >= $totalPaginas) ? 'disabled' : '' ?>">
          <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>&palabra=<?= urlencode($palabra) ?>">Siguiente</a>
        </li>
      </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include("include/footer.php"); ?>
