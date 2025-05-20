<?php
require 'db.php';

$categoria = $_GET['categoria'] ?? null;

$por_pagina = 4;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $por_pagina;

  if ($categoria) {
    $stmt = $pdo->prepare('SELECT * FROM posts WHERE categoria = ? ORDER BY fecha DESC LIMIT ? OFFSET ?');
    $stmt->bindParam(1, $categoria);
    $stmt->bindParam(2, $por_pagina, PDO::PARAM_INT);
    $stmt->bindParam(3, $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Para contar total de resultados
    $total_stmt = $pdo->prepare('SELECT COUNT(*) FROM posts WHERE categoria = ?');
    $total_stmt->execute([$categoria]);
  } else {
    $stmt = $pdo->prepare('SELECT * FROM posts ORDER BY fecha DESC LIMIT ? OFFSET ?');
    $stmt->bindParam(1, $por_pagina, PDO::PARAM_INT);
    $stmt->bindParam(2, $offset, PDO::PARAM_INT);
    $stmt->execute();

    $total_stmt = $pdo->query('SELECT COUNT(*) FROM posts');
  }

$posts = $stmt->fetchAll();
$total_resultados = $total_stmt->fetchColumn();
$total_paginas = ceil($total_resultados / $por_pagina);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Blog</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include("include/menu.php");
     menu();
    ?>
  
  <main class="container my-5">
    <?php if (!empty($posts)): ?>
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($posts as $post): ?>
          <div class="col">
            <article class="card h-100 shadow-sm">
              <div class="card-body">
              <?php if (!empty($post['imagen'])): ?>
                <img src="img/<?= htmlspecialchars($post['imagen']); ?>" class="card-img-top" alt="Imagen del artículo">
                <?php endif; ?>
                <h2 class="card-title"><?= htmlspecialchars($post['titulo']); ?></h2>
                <time class="text-muted"><?= date('d/m/Y', strtotime($post['fecha'])); ?></time>
                <p class="card-text "><?= substr(htmlspecialchars($post['contenido']), 0, 150); ?>...</p>
                <a href="post.php?id_post=<?= $post['id_post']; ?>" class="btn btn-primary">Leer más</a>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-muted">No hay publicaciones aún.</p>
    <?php endif; ?>
  </main>

  <nav>
   <ul class="pagination justify-content-center mt-4">
     <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
          <a class="page-link" href="?<?= $categoria ? "categoria=$categoria&" : "" ?>pagina=<?= $i ?>"><?= $i ?></a>
        </li>
     <?php endfor; ?>
   </ul>
  </nav>

  
  <footer class="text-center text-black py-3" style="background-color: #F37E00;">
    <p class="mb-0">&copy; 2025 MiBlog. Todos los derechos reservados.</p>
  </footer>

  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
