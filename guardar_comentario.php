<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
    $contenido = isset($_POST['contenido']) ? trim($_POST['contenido']) : '';
    $id_usuario = 1; // id_usuario fijo para Walter Medina

    if (!empty($post_id) && !empty($contenido)) {
        $stmt = $pdo->prepare('INSERT INTO comentarios (contenido, id_usuario, id_post) VALUES (?, ?, ?)');
        if ($stmt->execute([$contenido, $id_usuario, $post_id])) {
            header("Location: post.php?id=$post_id");
            exit;
        } else {
            echo "Error al guardar el comentario.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
