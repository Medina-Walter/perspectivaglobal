<?php include("include/header.php"); ?>
<?php include("include/menu.php"); ?>
<?php
require 'bd.php';

$sql = 'SELECT * FROM posts';
$stmt = $pdo->query($sql);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
  <a class="btn btn-primary" href="index.php">Volver</a>
    <?php foreach ($posts as $post) { ?>
        <div class="row mt-3">
            <div class="col">
                <div class="card mb-3">
                   <div class="card-body">
                      <img class="card-img-top" src="img/<?php echo htmlspecialchars($post['imagen']); ?>" alt="imagen de portada">
                      <h4 class="card-title text-center mt-3"><?php echo htmlspecialchars($post['titulo']); ?></h4>
                      <p><?php echo htmlspecialchars($post['fecha']); ?></p>
                      <p class="card-text"><?php echo htmlspecialchars(substr($post['contenido'], 0, 200)) . '...'; ?></p>
                      <a href="ver-post.php?id=<?php echo $post['id_post']; ?>" class="btn btn-primary">Leer más</a>
                    </div>
                </div>
            </div>
        </div>    
    <?php } ?>
</div>

<?php include("include/footer.php"); ?>