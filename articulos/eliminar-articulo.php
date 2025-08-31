<?php
session_start();
include("../config.php");

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: registro.php");
    exit();
}

unset($_SESSION['csrf_token']);

$id_post = $_POST['id_post'];
$id_usuario = $_SESSION['id_usuario'];

$sql = 'DELETE FROM posts WHERE id_post =? AND id_usuario =?';
$stmt = $pdo->prepare($sql);
if ($stmt->execute([$id_post, $id_usuario])) {
    $_SESSION['mensaje'] = "Artículo eliminado";
    $_SESSION['tipo'] = "success";
} else {
    $_SESSION['mensaje'] = "Error al eliminar el artículo";
    $_SESSION['tipo'] = "danger";
}

header('Location: ../usuarios/miperfil.php');
exit;
?>