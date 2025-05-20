<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $categoria = trim($_POST['categoria']);
    $id_usuario = 1; // id_usuario fijo para Walter Medina (reemplaza con el id_usuario real)

    if (!empty($titulo) && !empty($contenido) && !empty($categoria)) {
        try {
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombre_tmp = $_FILES['imagen']['tmp_name'];
                $nombre_original = $_FILES['imagen']['name'];

                $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
                $extension = strtolower($extension);

                $nombre_final = 'img_' . uniqid() . '.' . $extension;
                $ruta_destino = 'img/' . $nombre_final;

                if (move_uploaded_file($nombre_tmp, $ruta_destino)) {
                    $stmt = $pdo->prepare('INSERT INTO posts (titulo, contenido, categoria, imagen, id_usuario) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([$titulo, $contenido, $categoria, $nombre_final, $id_usuario]);
                } else {
                    echo "Error al subir la imagen.";
                    exit;
                }
            } else {
                $stmt = $pdo->prepare('INSERT INTO posts (titulo, contenido, categoria, id_usuario) VALUES (?, ?, ?, ?)');
                $stmt->execute([$titulo, $contenido, $categoria, $id_usuario]);
            }

            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            echo "Error al guardar el artículo: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    echo "Acceso no permitido.";
}
