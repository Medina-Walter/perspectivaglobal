<?php
session_start();
require 'db.php';
//Validamos  los campos obligatorios.
if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
    $_SESSION['error_login'] = 'Todos los campos son obligatorios';
    header('Location: login.php');
    exit;
}

//Sanitizamos 

$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
$clave = $_POST['contrasena'];

// Consulta segura
try {
    $stmt = $pdo->prepare('SELECT id_usuario, nombre, correo, clave FROM usuarios WHERE correo = ?');
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch();



    // Verificaciones

    if (!$usuario){
        $_SESSION['error_login'] = 'El correo ingresado no está registrado. <a href="registro.php" class="alert-link">Regístrese aquí</a>';
        header('Location: login.php');
        exit;
    }
    if (!password_verify($clave, $usuario['clave'])) {
        $_SESSION['error_login']= 'La contraseña es incorrecta';
        header('Location: login.php');
        exit;
    }
    
    //Usuario válido, login exitoso
        $_SESSION['usuario'] = [
            'id' => $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'correo' => $usuario['correo'],
        ];
        header('Location: post.php');
        exit;
    
    
} catch (PDOException $e) {
    error_log('Error en login: ' . $e->getMessage());
    $_SESSION['error_login'] = 'Error al procesar el login. Intente más tarde.';
    header('Location: login.php');
    exit;
}
