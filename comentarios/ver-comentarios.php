<?php
require 'config.php';

// Asegurarnos de tener el id del post actual
if (!isset($post['id_post'])) {
    echo "Post no encontrado";
    exit;
}

$id_post = $post['id_post'];

// Traer solo los comentarios de este post
$sql = 'SELECT c.id_comentario, c.id_usuario, c.id_post, c.contenido, u.nombre, u.apellido 
        FROM comentarios c
        INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
        WHERE c.id_post = ?
        ORDER BY c.id_comentario DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post]);
$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
.oculto {
    display: none !important;
}
</style>

<!-- Mostrar comentarios -->
<?php foreach ($comentarios as $comentario): ?>
<div class="card mb-2" id="comentario-<?= $comentario['id_comentario']; ?>">
    <div class="card-body">
        <strong><?= htmlspecialchars($comentario['nombre'] . " " . $comentario['apellido']); ?></strong>

        <!-- Texto del comentario -->
        <p id="texto-<?= $comentario['id_comentario']; ?>">
            <?= htmlspecialchars($comentario['contenido']); ?>
        </p>

        <!-- Formulario de edición (oculto por defecto) -->
        <form method="POST" action="actualizar-comentario.php" 
            id="form-<?= $comentario['id_comentario']; ?>" class="oculto">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
            <input type="hidden" name="id_comentario" value="<?= $comentario['id_comentario']; ?>">
            <input type="hidden" name="id_post" value="<?= $comentario['id_post']; ?>">
            <textarea name="contenido" class="form-control"><?= htmlspecialchars($comentario['contenido']); ?></textarea>
            <button type="submit" class="btn btn-success btn-sm mt-2">Actualizar</button>
            <button type="button" onclick="cancelarEdicion(<?= $comentario['id_comentario']; ?>)" 
            class="btn btn-secondary btn-sm mt-2">Cancelar</button>
        </form>

        <!-- Botones editar / eliminar -->
        <?php if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] == $comentario['id_usuario']): ?> 
            <div class="d-flex gap-2" id="btn-<?= $comentario['id_comentario']; ?>">
                <button class="btn btn-warning btn-sm" onclick="editarComentario(<?= $comentario['id_comentario']; ?>)">Editar</button>
                <form action="comentarios/eliminar-comentario.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="id_comentario" value="<?= $comentario['id_comentario']; ?>">
                    <input type="hidden" name="id_post" value="<?= $comentario['id_post']; ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>

<script>
function editarComentario(id) {
    document.getElementById('texto-' + id).classList.add('oculto');   // ocultar texto
    document.getElementById('form-' + id).classList.remove('oculto'); // mostrar formulario
    document.getElementById('btn-' + id).classList.add('oculto');     // ocultar botones
}

function cancelarEdicion(id) {
    document.getElementById('texto-' + id).classList.remove('oculto'); 
    document.getElementById('form-' + id).classList.add('oculto'); 
    document.getElementById('btn-' + id).classList.remove('oculto'); 
}
</script>
