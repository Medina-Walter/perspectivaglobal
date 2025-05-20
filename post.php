<?php
require 'db.php';

// Consulta para obtener un post específico
$id = filter_input(INPUT_GET, 'id_post', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM posts WHERE id_post = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['titulo']); ?> - Mi Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Asegurar que el texto se ajuste y no desborde */
        .post-content {
            word-break: break-word; /* Divide palabras largas */
            overflow-wrap: break-word; /* Asegura que el texto se ajuste al contenedor */
            white-space: normal; /* Permite saltos de línea naturales */
        }
        .card-body {
            overflow: auto; /* Agrega scroll si el contenido es muy largo */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include("include/menu.php"); menu(); ?>

    <main class="container my-5">
      <div class="card shadow-sm">
        <div class="card-body overflow-visible">
         <h2 class="card-title mb-3"><?= htmlspecialchars($post['titulo']); ?></h2>
         <time class="text-muted d-block mb-3"><?= date('d/m/Y', strtotime($post['fecha'])); ?></time>
          <div class="mb-4 text-wrap overflow-visible">
            <?= nl2br(htmlspecialchars($post['contenido'])); ?>
          </div>
        </div>
      </div>

        <!-- FORMULARIO DE COMENTARIO -->
        <section class="container mt-5">
            <h4>Dejá un comentario</h4>
            <form method="POST" action="guardar_comentario.php">
                <input type="hidden" name="post_id" value="<?= $post['id_post']; ?>">
                <div class="mb-3">
                    <label for="contenido" class="form-label">Comentario</label>
                    <textarea name="contenido" id="contenido" rows="4" class="form-control" placeholder="Escribí tu comentario aquí…" required></textarea>
                </div>
                <button type="submit" name="guardar_comentario" class="btn btn-primary">Publicar Comentario</button>
            </form>
        </section>

        <!-- LISTA DE COMENTARIOS -->
        <?php
        $stmt = $pdo->prepare('SELECT contenido, fecha FROM comentarios WHERE id_post = ? ORDER BY fecha DESC');
        $stmt->execute([$post['id_post']]);
        $comentarios = $stmt->fetchAll();
        ?>

        <section class="container mt-5">
            <h4>Comentarios</h4>
            <?php if (count($comentarios) > 0): ?>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="mb-1"><?= nl2br(htmlspecialchars($comentario['contenido'])) ?></p>
                            <?php if (!empty($comentario['fecha'])): ?>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($comentario['fecha'])) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Aún no hay comentarios en este post.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="text-center text-black py-3" style="background-color: #F37E00;">
        <p class="mb-0">© 2025 MiBlog. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>