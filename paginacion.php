<?php 
$articulosPorPagina = 8;
$paginaActual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;

$offset = ($paginaActual - 1) * $articulosPorPagina;

    // Traer todos los artículos
    $sql = 'SELECT * FROM posts ORDER BY fecha DESC LIMIT ? OFFSET ?';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $articulosPorPagina, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Contar todos los artículos
    $sqlTotal = 'SELECT COUNT(*) FROM posts';
    $stmtTotal = $pdo->query($sqlTotal);
    $totalArticulos = $stmtTotal->fetchColumn();

$totalPaginas = ceil($totalArticulos / $articulosPorPagina);
?>
