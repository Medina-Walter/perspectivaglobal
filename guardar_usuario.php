<?php

include 'db.php';

// Recibir datos POST
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$correo = $_POST['correo'] ?? '';
$clave = $_POST['clave'] ?? '';


if (!$nombre || !$apellido || !$usuario || !$correo || !$clave) {
    die("Faltan datos obligatorios.");
}


$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, usuario, correo, clave) VALUES (?, ?, ?, ?, ?)");


try {
    $stmt->execute([
        $nombre,
        $apellido,
        $usuario,
        $correo,
        $clave_hash
    ]);
    header('Location: login.php');
    //echo "Usuario registrado con éxito.";


} catch (Exception $e) {
    die("Error al guardar el usuario: " . $e->getMessage());
}
