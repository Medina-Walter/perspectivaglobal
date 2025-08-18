<?php
$host = 'localhost';
$user = 'root';
$password = '';
$baseDeDatos = 'blog_simple';

try {
    // 👇 DSN correcto para MySQL
    $pdo = new PDO("mysql: host=$host; dbname=$baseDeDatos; charset=utf8", $user, $password);

    // Activar el modo de errores para ver problemas
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

?>
