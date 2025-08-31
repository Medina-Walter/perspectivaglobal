<?php
session_start();
require '../config.php';

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: login.php");
    exit();
}

unset($_SESSION['csrf_token']);

if (!empty($_POST['correo']) && !empty($_POST['clave'])) {

    $correo = strtolower(trim($_POST['correo']));
    $clave = $_POST['clave'];

    // Ahora también traemos el campo estado
    $sql = 'SELECT * FROM usuarios WHERE correo = ? LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($clave, $usuario['clave'])) {
        
        //Verificar si el usuario está activo
        if ($usuario['estado'] != 1) {
            $_SESSION['error'] = "Tu cuenta está desactivada.";
            header("Location: login.php");
            exit();
        }

        // Guardar datos en la sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre_usuario'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        // Redirigir según rol
        if ($usuario['rol'] === 'admin') {
            header('Location: escritores.php');
        } else {
            header('Location: ../index.php');
        }
        exit();
    } else {
        $_SESSION['error'] = "Credenciales incorrectas";
        header("Location: login.php");
        exit();
    }

} else {
    $_SESSION['error'] = "Por favor complete todos los campos.";
    header("Location: login.php");
    exit();
}
