<?php
session_start();
include("../config.php");

$id_post = $_POST['id_post'] ?? null;

// Validación CSRF
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: ../ver-post.php?id=" . $id_post);
    exit();
}

unset($_SESSION['csrf_token']);

$id_comentario = $_POST['id_comentario'];
$id_usuario    = $_SESSION['id_usuario'];

// Borrar comentario
$sql = 'DELETE FROM comentarios WHERE id_comentario = ? AND id_usuario = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_comentario, $id_usuario]);

$_SESSION['mensaje'] = "Comentario eliminado correctamente.";
$_SESSION['tipo']    = "success";

header("Location: ../ver-post.php?id=" . $id_post);
exit;
