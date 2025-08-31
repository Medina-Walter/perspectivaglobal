<?php
session_start();
require '../config.php';

// Validar CSRF
if (!isset($_POST['csrf_token']) || 
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['mensaje'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    $_SESSION['tipo'] = "danger";
    header("Location: crear-articulo.php");
    exit();
}
unset($_SESSION['csrf_token']);

// Validar usuario logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

// Validar campos
if (!empty($_POST['titulo']) && !empty($_POST['contenido'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $titulo     = trim($_POST['titulo']);
    $contenido  = trim($_POST['contenido']);

    // Imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreImagen = time() . "_" . uniqid() . "." . $ext;
        $rutaTemp = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($rutaTemp, "../img/" . $nombreImagen);
    } else {
        $nombreImagen = null;
    }

    $sql = "INSERT INTO posts (titulo, contenido, imagen, id_usuario, fecha) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$titulo, $contenido, $nombreImagen, $id_usuario]);

        $_SESSION['mensaje'] = "Artículo creado con éxito";
        $_SESSION['tipo']    = "success";
        header("Location: ../index.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['mensaje'] = "Error al crear el artículo: " . $e->getMessage();
        $_SESSION['tipo']    = "danger";
        header("Location: crear-articulo.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "Por favor complete todos los campos obligatorios ⚠️";
    $_SESSION['tipo']    = "warning";
    header("Location: crear-articulo.php");
    exit();
}
