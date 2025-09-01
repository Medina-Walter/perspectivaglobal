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
$id_post    = $_POST['id_post'] ?? null;
$titulo     = $_POST['titulo'] ?? '';
$contenido  = $_POST['contenido'] ?? '';

// Manejo de imagen
$imagen = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombreImagen = time() . "_" . basename($_FILES['imagen']['name']);
    $rutaDestino  = __DIR__ . "/../img/" . $nombreImagen; // ruta absoluta
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        $imagen = $nombreImagen; // guardamos solo el nombre en BD
    }
}


// UPDATE con o sin imagen
if ($imagen) {
    $sql = "UPDATE posts SET titulo=?, contenido=?, imagen=? WHERE id_post=? AND id_usuario=?";
    $stmt = $pdo->prepare($sql);
    $resultado = $stmt->execute([$titulo, $contenido, $imagen, $id_post, $id_usuario]);
} else {
    $sql = "UPDATE posts SET titulo=?,  contenido=? WHERE id_post=? AND id_usuario=?";
    $stmt = $pdo->prepare($sql);
    $resultado = $stmt->execute([$titulo,  $contenido, $id_post, $id_usuario]);
}

// Establecer mensaje siempre
if ($resultado) {
    $_SESSION['mensaje'] = "Artículo actualizado correctamente";
    $_SESSION['tipo'] = "success";
} else {
    $_SESSION['mensaje'] = "Hubo un error al actualizar el artículo";
    $_SESSION['tipo'] = "danger";
}

// Redirigir al perfil
header('Location: ../usuarios/miperfil.php');
exit;
?>
