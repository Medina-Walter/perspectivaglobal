<?php
session_start();
require '../config.php';

// ✅ Solo admins pueden cambiar estados
if (!isset($_SESSION['id_usuario']) || $_SESSION['usuario_rol'] !== 'admin') {
    $_SESSION['error'] = "Acceso denegado.";
    header("Location: login.php");
    exit();
}

if (isset($_POST['id_usuario'], $_POST['estado'])) {
    $id_usuario = (int) $_POST['id_usuario'];
    $estado     = (int) $_POST['estado'];

    $sql = "UPDATE usuarios SET estado = ? WHERE id_usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$estado, $id_usuario]);

    $_SESSION['mensaje'] = "Estado actualizado correctamente.";
    $_SESSION['tipo'] = "success";
    header("Location: escritores.php");
    exit();
} else {
    $_SESSION['mensaje'] = "Datos inválidos.";
    $_SESSION['tipo'] = "danger";
    header("Location: escritores.php");
    exit();
}
