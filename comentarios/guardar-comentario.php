<?php
session_start();
require '../config.php';

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: registro.php");
    exit();
}

unset($_SESSION['csrf_token']);

if (!empty($_POST['contenido']) && !empty($_POST['id_post'])) {

    $id_usuario = $_SESSION['id_usuario'];
    $id_post = $_POST['id_post'];
    $contenido = $_POST['contenido'];

    $sql = "INSERT INTO comentarios (contenido, id_usuario, id_post) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$contenido, $id_usuario, $id_post]);
        $_SESSION['mensaje'] = "Comentario creado con éxcito";
        $_SESSION['tipo'] = "success";

    header('Location: ../ver-post.php?id='. $id_post);
    exit();
    } catch (Exception $e) {
        $_SESSION['mensaje'] = "Error al crear el comentario";
        $_SESSION['tipo'] = "danger";
    }
}else {
    echo "El comentario no puede estar  vacio";
}

?>