<?php
include("bd.php");
include("include/header.php");
include("include/menu.php");


session_start();
$id_usuario = $_SESSION['id_usuario'];
$sql = 'SELECT * FROM usuarios WHERE id_usuario = ? LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$id_usuario = $_SESSION['id_usuario'];
$sql = 'SELECT * FROM posts WHERE id_usuario = ? ORDER BY fecha DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<h4 class="text-center mt-3">Mi Perfil</h4>
<div class="container">
    <?php foreach ($usuarios as $usuario) { ?>
        <div class="card">
            <div class="card-body">
                <label>Nombre:</label>
                <p><?php echo htmlspecialchars($usuario['nombre']); ?></p>

                <label>Apellido:</label>
                <p><?php echo htmlspecialchars($usuario['apellido']); ?></p>

                <label>Usuario:</label>
                <p><?php echo htmlspecialchars($usuario['usuario']); ?></p>

                <a class="btn btn-primary" href="editar-perfil.php?">Editar Perfil</a>
            </div>
        </div>
    <?php } ?>
</div>


<h4 class="text-center mt-3">Mis Artículos</h4>
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
                        alt="imagen de portada" style="height:200px; ">
                        <h4 class="card-title text-center mt-3"><?php echo htmlspecialchars($post['titulo']); ?></h4>
                        <p><?php echo htmlspecialchars($post['fecha']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars(substr($post['contenido'], 0, 200)) . '...'; ?></p>
                        <div class="d-flex gap-2">
                            <a href="ver-post.php?id=<?php echo $post['id_post']; ?>" class="btn btn-primary">Leer más</a>
                            <a class="btn btn-warning" href="editar-articulo.php?id_post=<?php echo $post['id_post']; ?>">Editar</a>
                            <form action="eliminar-articulo.php" method="POST">
                               <input type="hidden" name="id_post" value="<?= $post['id_post']; ?>">
                               <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php }else { ?> 
            <p class="text-center">No has publicado ningún artículo.</p>
            <div class="text-center">
                <a class="btn btn-primary w-25 justify-center" href="crear-articulo.php">Crear Artículo</a>
            </div>            
        <?php }?>
    </div>
</div>
<?php include("include/footer.php");
?>