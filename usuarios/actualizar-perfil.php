<?php
session_start();
include("../config.php");

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: registro.php");
    exit();
}

unset($_SESSION['csrf_token']);

$id_usuario = $_SESSION['id_usuario'];
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$nombreImagen = null;

// Si sube imagen nueva
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $nombreImagen = $_FILES['foto_perfil']['name'];
    $rutaTemp = $_FILES['foto_perfil']['tmp_name'];
    move_uploaded_file($rutaTemp, "../img/" . $nombreImagen);
} else {
    // Si no sube nada, conservar la que ya tiene en la BD
    $sql = "SELECT foto_perfil FROM usuarios WHERE id_usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreImagen = $usuario['foto_perfil'];
}

// Actualizar datos
$sql = "UPDATE usuarios SET nombre=?, apellido=?, foto_perfil=? WHERE id_usuario=?";
$stmt = $pdo->prepare($sql);
if ($stmt->execute([$nombre, $apellido, $nombreImagen, $id_usuario])) {
    $_SESSION['mensaje'] = "Perfil actualizado";
    $_SESSION['tipo'] = "success";
} else {
    $_SESSION['mensaje'] = "Error al crear el artículo";
    $_SESSION['tipo'] = "danger";
}

header('Location: ../usuarios/miperfil.php');
exit;
?>
