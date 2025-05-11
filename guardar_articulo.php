
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $categoria = trim($_POST['categoria']);

    if (!empty($titulo) && !empty($contenido) && !empty($categoria)) {

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombre_tmp = $_FILES['imagen']['tmp_name'];
            $nombre_original = $_FILES['imagen']['name'];


            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $extension = strtolower($extension);

            $nombre_final = 'img_' . uniqid() . '.' . $extension;

            $ruta_destino = 'img/' . $nombre_final;

            if (move_uploaded_file($nombre_tmp, $ruta_destino)) {
                $stmt = $pdo->prepare('INSERT INTO posts (título, contenido, categoría, imagen) VALUES (?, ?, ?, ?)');
                $stmt->execute([$titulo, $contenido, $categoria, $nombre_final]);

                header('Location: index.php');
                exit;
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            $stmt = $pdo->prepare('INSERT INTO posts (título, contenido, categoría) VALUES (?, ?, ?)');
            $stmt->execute([$titulo, $contenido, $categoria]);

            header('Location: index.php');
            exit;
        }

    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
