<?php
session_start();

require 'bd.php';

if (!empty($_POST['correo']) && !empty($_POST['clave'])) {
    
    $correo = trim($_POST['correo']);
    $clave = $_POST['clave'];

    //Buscar Usuario por correo
    $sql = 'SELECT * FROM usuarios where correo = ? LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($clave, $usuario['clave'])) {
        //Login correcto

        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre_usuario'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        if ($usuario['rol'] === 'admin') {
            header('Location: admin/dashboard.php');
        }else {
            header('Location: index.php');
        }
        exit;
    }else {
        echo "Credenciales incorrectas";
    }
}
?>