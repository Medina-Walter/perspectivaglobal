<?php
session_start();
include("include/header.php"); 
include("include/menu.php");
include("bd.php");

$id_post = $_GET['id_post'] ?? 0;

$sql = 'SELECT * FROM posts WHERE id_post = ? AND id_usuario = ? LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post, $_SESSION['id_usuario']]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<p class='text-center mt-4 text-danger'>No se encontró el artículo.</p>";
    exit;
}
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <h4 class="text-center mt-4">Edita tu Artículo</h4>

        <form class="form-control mt-3" action="actualizar-articulo.php" method="POST" enctype="multipart/form-data">
            
            <!-- Campo oculto para enviar el ID del post -->
            <input type="hidden" name="id_post" value="<?php echo $post['id_post']; ?>">

            <div>
                <label class="form-label mt-3" for="titulo">Título</label>
                <input class="form-control" type="text" name="titulo" id="titulo" 
                       value="<?php echo htmlspecialchars($post['titulo']); ?>" required>
            </div>
            
            <div>
                <label class="form-label mt-3" for="categoria">Selecciona una Categoría</label>
                <select class="form-control" name="categoria" id="categoria">
                    <option></option>
                    <option value="economia" <?php if ($post['id_categoria']=='economia') echo 'selected'; ?>>Economía</option>
                    <option value="espectaculo" <?php if ($post['id_categoria']=='espectaculo') echo 'selected'; ?>>Espectáculo</option>
                    <option value="politica" <?php if ($post['id_categoria']=='politica') echo 'selected'; ?>>Política</option>
                </select>
            </div>

            <div class="mt-3">
                <label class="form-label" for="contenido">Contenido</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="10" required><?php echo htmlspecialchars($post['contenido']); ?></textarea>
            </div>

            <div class="mt-3">
                <label class="form-label" for="imagen">Imagen de Portada (Opcional)</label>
                <input class="form-control" type="file" name="imagen" id="imagen">
            </div>

            <div class="mt-3">
                <button class="btn btn-primary mt-3" type="submit">Editar Artículo</button>
                <a class="btn btn-info mt-3" href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>
