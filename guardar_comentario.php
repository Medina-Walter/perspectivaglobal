<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];  // ID del artículo al que pertenece el comentario
    $autor = trim($_POST['autor']); // Nombre del autor del comentario
    $contenido = trim($_POST['contenido']); // Contenido del comentario

    if (!empty($post_id) && !empty($autor) && !empty($contenido)) {
        // Insertar el comentario en la base de datos
        $stmt = $pdo->prepare('INSERT INTO comentarios (id_articulo, autor_comentario, texto_comentario) VALUES (?, ?, ?)');
        $stmt->execute([$post_id, $autor, $contenido]);

        // Redirigir de nuevo al artículo después de guardar el comentario
        header("Location: post.php?id=$post_id");
        exit;
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    echo "Acceso no permitido.";
}
