<?php
session_start();
include("bd.php");

$id_usuario = $_SESSION['id_usuario'];
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';

$sql = "UPDATE usuarios SET nombre=?, apellido=? WHERE id_usuario=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nombre, $apellido, $id_usuario]);

header('Location: miperfil.php');
exit;
?>
