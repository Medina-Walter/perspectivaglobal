<?php
$titulo = "Mi Perfil";
include("../config.php");
include("../include/header.php");
include("../include/menu.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// ====================
// Datos del usuario
// ====================
$sql = 'SELECT * FROM usuarios WHERE id_usuario = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// ====================
// Paginación artículos
// ====================
$registrosPorPagina = 4; // cantidad de artículos por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($paginaActual < 1) $paginaActual = 1;

// total de artículos de ese usuario
$sql = "SELECT COUNT(*) FROM posts WHERE id_usuario = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$totalRegistros = $stmt->fetchColumn();

// calcular total de páginas
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// desde qué registro empezar
$inicio = ($paginaActual - 1) * $registrosPorPagina;

// traer artículos del usuario con LIMIT
$sql = "SELECT * FROM posts WHERE id_usuario = ? ORDER BY fecha DESC LIMIT $inicio, $registrosPorPagina";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="container mt-3 w-50">
        <div class="alert alert-<?= $_SESSION['tipo']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo']); ?>
<?php endif; ?>

<h4 class="text-center mt-3">Mi Perfil</h4>
<div class="container">
    <?php if ($usuario): 
        $fotoPerfil = !empty($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'default-avatar.png';
    ?>
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img class="form-label rounded-circle d-block mx-auto"
                        src="../img/<?= htmlspecialchars($fotoPerfil); ?>"
                        style="height:200px;">
                </div>

                <label class="mt-3">Nombre:</label>
                <p><?= htmlspecialchars($usuario['nombre']); ?></p>

                <label>Apellido:</label>
                <p><?= htmlspecialchars($usuario['apellido']); ?></p>

                <a class="btn btn-primary" href="editar-perfil.php">Editar Perfil</a>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                    data-bs-target="#cambiarPasswordModal">
                    Cambiar Contraseña
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>

<h4 class="text-center mt-3">Mis Artículos</h4>
<div class="container mt-4 mb-5">
    <div class="row">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): 
                $portada = !empty($post['imagen']) ? $post['imagen'] : 'default-portada.png';
            ?>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <img class="card-img-top img-fluid"
                                src="../img/<?= htmlspecialchars($portada); ?>"
                                style="height:200px;">
                            <h5 class="card-title text-center mt-3"><?= htmlspecialchars($post['titulo']); ?></h5>
                            <p><?= htmlspecialchars($post['fecha']); ?></p>
                            <p class="card-text"><?= htmlspecialchars(substr($post['contenido'], 0, 200)) . '...'; ?></p>
                            <div class="d-flex gap-2">
                                <a href="../ver-post.php?id=<?= $post['id_post']; ?>" class="btn btn-primary">Leer más</a>
                                <a class="btn btn-warning" href="../articulos/editar-articulo.php?id_post=<?= $post['id_post']; ?>">Editar</a>
                                <form action="../articulos/eliminar-articulo.php" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este artículo?');">
                                    <input type="hidden" name="id_post" value="<?= $post['id_post']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No has publicado ningún artículo.</p>
            <div class="text-center">
                <a class="btn btn-primary w-25 justify-center" href="../articulos/crear-articulo.php">Crear Artículo</a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($totalPaginas > 1): ?>
        <nav aria-label="Paginación de artículos">
            <ul class="pagination justify-content-center">

                <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>">Anterior</a>
                </li>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= ($paginaActual == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($paginaActual >= $totalPaginas) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>">Siguiente</a>
                </li>

            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include("../include/footer.php"); ?>
<?php include("modal-clave.php"); ?>
