<?php
session_start();
include("../config.php");

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: registro.php");
    exit();
}

unset($_SESSION['csrf_token']);

// Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Error: Debes iniciar sesión.");
}

$id_usuario = $_SESSION['id_usuario'];
$id_comentario = $_POST['id_comentario'] ?? null;
$id_post = $_POST['id_post'] ?? null;
$contenido = $_POST['contenido'] ?? '';

if ($id_comentario && $id_post && !empty($contenido)) {
    $sql = "UPDATE comentarios 
            SET contenido = ? 
            WHERE id_comentario = ? AND id_usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$contenido, $id_comentario, $id_usuario]);

    $_SESSION['mensaje'] = "Comentario actualizado";
    $_SESSION['tipo'] = "success";
    header('Location: ../ver-post.php?id=' . $id_post);
    exit;
} else {
    $_SESSION['mensaje'] = "Error al actualizar";
    $_SESSION['tipo'] = "danger";
}
?>
