<?php
$config = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'blog_simple',
    'charset' => 'utf8mb4'
];

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", 
    $config['user'], 
    $config['password']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage(), 3, __DIR__ . '/errores.log');
    die("Error de conexión. Intente más tarde.");
}

?>
