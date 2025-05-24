<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $clave  = trim($_POST['clave']);

    // Validación de entrada
    if (empty($correo) || empty($clave)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Consulta para obtener el usuario por su correo
    $stmt = $pdo->prepare('SELECT id_usuario, usuario, clave FROM usuarios WHERE correo = ?');
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($clave, $usuario['clave'])) {
        // Iniciar sesión y almacenar datos
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['usuario'] = $usuario['usuario'];

        // Redirigir al usuario a la página principal
        header('Location: index.php');
        exit;
    } else {
        echo "Credenciales inválidas.";
    }
} else {
    echo "Acceso no permitido.";
}
