<?php
session_start();
require '../config.php';

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Recargue la página e intente de nuevo.";
    header("Location: registro.php");
    exit();
}

unset($_SESSION['csrf_token']);

if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['usuario']) &&
    !empty($_POST['correo']) && !empty($_POST['clave'])) {

    $nombre   = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $usuario  = trim($_POST['usuario']);
    $correo   = strtolower(trim($_POST['correo']));
    $clave    = $_POST['clave'];

    // Validación correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "El correo no es válido.";
        header("Location: registro.php");
        exit();
    }

    // Validación contraseña
    if (strlen($clave) < 8) {
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres.";
        header("Location: registro.php");
        exit();
    }

    // Verificar si el usuario ya existe
    $sql = "SELECT id_usuario FROM usuarios WHERE usuario = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "El nombre de usuario ya está en uso.";
        header("Location: registro.php");
        exit();
    }

    // Verificar si el correo ya existe
    $sql = "SELECT id_usuario FROM usuarios WHERE correo = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "El correo ya está registrado.";
        header("Location: registro.php");
        exit();
    }

    // Si todo está bien, registramos
    $clave_segura = password_hash($clave, PASSWORD_DEFAULT);
    $rol = 'usuario';

    $sql = "INSERT INTO usuarios (nombre, apellido, usuario, correo, clave, rol, estado) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$nombre, $apellido, $usuario, $correo, $clave_segura, $rol]);

        $_SESSION['success'] = "Registro exitoso. Ahora puede iniciar sesión.";
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        error_log("Error en registro: " . $e->getMessage(), 3, __DIR__ . "/../errores.log");
        $_SESSION['error'] = "Error en el registro. Intente nuevamente.";
        header("Location: registro.php");
        exit();
    }

} else {
    $_SESSION['error'] = "Por favor, complete todos los campos.";
    header("Location: registro.php");
    exit();
}
