<?php
require '../config.php';

$nombre = "Walter";
$apellido = "Medina";
$usuario = "admin";
$correo = "admin@tublog.com";
$clave = password_hash("12345678", PASSWORD_DEFAULT);
$rol = "admin";
$estado = 1;

$sql = "INSERT INTO usuarios (nombre, apellido, usuario, correo, clave, rol, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nombre, $apellido, $usuario, $correo, $clave, $rol, $estado]);

echo "Usuario admin creado correctamente.";
