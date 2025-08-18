<?php
session_start();
require 'bd.php';

if (!empty($_POST['titulo']) && !empty($_POST['categoria']) && 
    !empty($_POST['contenido'])) {

    $id_usuario = $_SESSION['id_usuario'];
    $titulo =  $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $categoria = $_POST['categoria'];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
           $nombreImagen = $_FILES['imagen']['name'];
           $rutaTemp = $_FILES['imagen']['tmp_name'];
           move_uploaded_file($rutaTemp, "img/" . $nombreImagen);
        } else {
           $nombreImagen = null;
        }


    $sql = "INSERT INTO posts (titulo, id_categoria, contenido, imagen, id_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
        $titulo,
        $categoria,
        $contenido,
        $nombreImagen,
        $id_usuario
    ]);

    header('Location: index.php');
    exit();
    } catch (Exception $e) {
        echo "Error, no se pudo crear el artículo" . $e->getMessage();
    }
}

?>