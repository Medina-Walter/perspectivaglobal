<?php
session_start();
require 'bd.php'; // Archivo con la conexión PDO

if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && 
    !empty($_POST['correo']) && !empty($_POST['clave'])) {

    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $clave = $_POST['clave'];

    // Encriptar contraseña
    $clave_segura = password_hash($clave, PASSWORD_DEFAULT);

    // Rol por defecto
    $rol = 'usuario';

    // Consulta para insertar
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, clave, rol) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $nombre,
            $apellido,
            $correo,
            $clave_segura,
            $rol
        ]);

        // Redirigir a login después de registrar
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Código para entrada duplicada
            echo "El correo ya está registrado.";
        } else {
            echo "Error en el registro: " . $e->getMessage();
        }
    }

} else {
    echo "Por favor, complete todos los campos.";
}
?>
