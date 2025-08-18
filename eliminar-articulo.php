<?php
session_start();
include("bd.php");

$id_post = $_POST['id_post'];
$id_usuario = $_SESSION['id_usuario'];

$sql = 'DELETE FROM posts WHERE id_post =? AND id_usuario =?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post, $id_usuario]);

header('Location: miperfil.php');
exit;
?>