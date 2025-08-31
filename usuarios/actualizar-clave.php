<?php
session_start();
include("../config.php");



if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: registro.php");
    exit();
}

unset($_SESSION['csrf_token']);

if (!isset($_SESSION['id_usuario'])) {
    die("Error: Debes iniciar sesión.");
}

$id_usuario = $_SESSION['id_usuario'];
$clave_actual = $_POST['clave_actual'] ?? '';
$clave_nueva = $_POST['clave_nueva'] ?? '';
$clave_confirmar = $_POST['clave_confirmar'] ?? '';

// Verificar que las nuevas coincidan
if ($clave_nueva !== $clave_confirmar) {
    $_SESSION['mensaje'] = "Las contraseñas no coinciden";
    $_SESSION['tipo'] = "warning";
    header("Location: miperfil.php");
    exit;
}

// Obtener la contraseña actual del usuario
$sql = "SELECT clave FROM usuarios WHERE id_usuario=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    $_SESSION['mensaje'] = "Usuario no encontrado";
    $_SESSION['tipo'] = "danger";
    header("Location: miperfil.php");
    exit;
}

// Verificar la contraseña actual
if (!password_verify($clave_actual, $usuario['clave'])) {
    $_SESSION['mensaje'] = "La contraseña actual es incorrecta";
    $_SESSION['tipo'] = "danger";
    header("Location: miperfil.php");
    exit;
}

// Actualizar con la nueva contraseña (encriptada)
$hash = password_hash($clave_nueva, PASSWORD_DEFAULT);
$sql = "UPDATE usuarios SET clave=? WHERE id_usuario=?";
$stmt = $pdo->prepare($sql);
$resultado = $stmt->execute([$hash, $id_usuario]);

if ($resultado) {
    $_SESSION['mensaje'] = "Contraseña actualizada correctamente";
    $_SESSION['tipo'] = "success";
    header("Location: miperfil.php");
    exit;
} else {
    $_SESSION['mensaje'] = "Error al actualizar la contraseña";
    $_SESSION['tipo'] = "danger";
    header("Location: miperfil.php");
    exit;
}
