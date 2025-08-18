<?php include("include/header.php"); ?>
<?php include("include/menu.php"); ?>
<?php
require 'bd.php';

$sql = 'SELECT * FROM posts';
$stmt = $pdo->query($sql);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 mb-5">
    <div class="row">
        <?php 
        if (!empty($posts)) {
            foreach ($posts as $post) { ?>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <img class="card-img-top img-fluid" 
                        src="img/<?php echo htmlspecialchars($post['imagen']); ?>" 
                        alt="imagen de portada"
                        style="height:200px; ">
                        <h4 class="card-title text-center mt-3"><?php echo htmlspecialchars($post['titulo']); ?></h4>
                        <p><?php echo htmlspecialchars($post['fecha']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars(substr($post['contenido'], 0, 200)) . '...'; ?></p>
                        <a href="ver-post.php?id=<?php echo $post['id_post']; ?>" class="btn btn-primary">Leer más</a>
                    </div>
                </div>
            </div>
        <?php } 
        } else {?>
        <h2 class="text-center" >No hay Artículos Disponibles</h2>
        <?php }?>
    </div>
</div>

<?php include("include/footer.php"); ?>