<?php
$titulo = "Usuarios";
include("../include/header.php");
include("../include/menu.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

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

require '../config.php';

$usuario = $_GET['usuario'] ?? '';

$usuariosPorPagina = 10;
$paginaActual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $usuariosPorPagina;

if (!empty($usuario)) {
    $sql = 'SELECT * FROM usuarios 
            WHERE usuario LIKE :usuario 
            ORDER BY id_usuario DESC 
            LIMIT :limit OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':usuario', "%$usuario%", PDO::PARAM_STR);
} else {
    $sql = 'SELECT * FROM usuarios 
            ORDER BY id_usuario DESC 
            LIMIT :limit OFFSET :offset';
    $stmt = $pdo->prepare($sql);
}

$stmt->bindValue(':limit', (int)$usuariosPorPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// total
if (!empty($usuario)) {
    $sqlTotal = 'SELECT COUNT(*) FROM usuarios WHERE usuario LIKE :usuario';
    $stmtTotal = $pdo->prepare($sqlTotal);
    $stmtTotal->bindValue(':usuario', "%$usuario%", PDO::PARAM_STR);
    $stmtTotal->execute();
} else {
    $sqlTotal = 'SELECT COUNT(*) FROM usuarios';
    $stmtTotal = $pdo->query($sqlTotal);
}
$totalUsuarios = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalUsuarios / $usuariosPorPagina);

?>

<!-- Buscador -->
<div class="container d-flex justify-content-end mb-3 mt-3">
  <form method="GET" action="escritores.php" class="d-flex">
    <input class="form-control me-2" type="search" name="usuario" 
           placeholder="Buscar por usuario..." 
           value="<?= htmlspecialchars($usuario) ?>">
    <button class="btn btn-outline-success" type="submit">Buscar</button>
  </form>
</div>

<h4 class="p-4">Usuarios Registrados</h4>

<div class="container">
    <table class="data table">
        <thead>
            <th class="text-center">Nombre</th>
            <th class="text-center">Apellido</th>
            <th class="text-center">Usuario</th>
            <th class="text-center">Correo</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Acción</th>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($usuario['nombre']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($usuario['apellido']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($usuario['usuario']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($usuario['correo']); ?></td>
                    <td class="text-center">
                        <?php if ($usuario['estado'] == 1): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <form action="cambiar-estado.php" method="POST">
                            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">
                            <input type="hidden" name="estado" value="<?= $usuario['estado'] == 1 ? 0 : 1; ?>">
                            <button type="submit" class="btn btn-sm btn-<?= $usuario['estado'] == 1 ? 'danger' : 'success'; ?>">
                                <?= $usuario['estado'] == 1 ? 'Desactivar' : 'Activar'; ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Paginación -->
<div class="container">
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($paginaActual > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>&palabra=<?= urlencode($palabra) ?>">Anterior</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $paginaActual ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>&palabra=<?= urlencode($palabra) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>&palabra=<?= urlencode($palabra) ?>">Siguiente</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php include("../include/footer.php"); ?>
