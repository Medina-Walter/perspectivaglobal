<?php 
$titulo = "Ver Artículo";
include("include/header.php"); ?>
<?php include("include/menu.php"); ?>
<?php
require 'config.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$id_post = $_GET['id'] ?? null;

  $sql = 'SELECT * FROM posts WHERE id_post = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id_post]);
  $post = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-3">
  <a class="btn btn-primary" href="index.php">Volver</a>

  <?php if ($post) { ?>
    <div class="row mt-3">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <?php 
                    if ($post) {
                    $portada = !empty($post['imagen']) ? $post['imagen'] : 'default-portada.png'; 
                    } ?>
                    <img class="card-img-top img-fluid" 
                         src="img/<?php echo htmlspecialchars($portada); ?>" 
                         style="height:300px;">
                    
                    <h3 class="card-title text-center mt-3">
                      <?php echo htmlspecialchars($post['titulo']); ?>
                    </h3>
                    <p><strong>Publicado:</strong> <?php echo htmlspecialchars($post['fecha']); ?></p>
                    <p class="card-text">
                      <?php echo nl2br(htmlspecialchars($post['contenido'])); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Formulario de comentarios -->
    <div class="card mt-6">
        <div class="card-body">
            <h5>Déja un Comentario</h5>
            <form action="comentarios/guardar-comentario.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                <input type="hidden" name="id_post" value="<?= $post['id_post'];?>">
                <label for="comentario">Comentario</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="5" required></textarea>
                <button class="btn btn-primary mt-3" type="submit">Publicar Comentario</button>
            </form>
        </div>
    </div>

    <?php
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

    <h4 class="mt-3">Comentarios</h4>
    <?php include("comentarios/ver-comentarios.php"); ?>

  <?php } else { ?>
    <h2 class="text-center text-danger">El artículo no existe</h2>
  <?php } ?>
</div>

<?php include("include/footer.php"); ?>
