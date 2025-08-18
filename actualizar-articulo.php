<?php
session_start();
include("bd.php");

// Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Error: Debes iniciar sesión.");
}

$id_usuario = $_SESSION['id_usuario'];
$id_post    = $_POST['id_post'] ?? null;
$titulo     = $_POST['titulo'] ?? '';
$categorias = $_POST['categoria'] ?? '';
$contenido  = $_POST['contenido'] ?? '';

// Manejo de imagen
$imagen = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombreImagen = time() . "_" . basename($_FILES['imagen']['name']);
    $rutaDestino  = "img/" . $nombreImagen;
    move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
    $imagen = $nombreImagen;
}

// UPDATE con o sin imagen
if ($imagen) {
    $sql = "UPDATE posts SET titulo=?, id_categoria=?, contenido=?, imagen=? WHERE id_post=? AND id_usuario=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $categorias, $contenido, $imagen, $id_post, $id_usuario]);
} else {
    $sql = "UPDATE posts SET titulo=?, id_categoria=?, contenido=? WHERE id_post=? AND id_usuario=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $categorias, $contenido, $id_post, $id_usuario]);
}

// Redirigir al perfil
header('Location: miperfil.php');
exit;
?>
