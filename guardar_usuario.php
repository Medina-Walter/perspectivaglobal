<?php
// Conexión a la base de datos (ajustá con tus datos)
$host = "localhost";
$dbname = "blog_simple"; // o el nombre de tu base
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Recibir datos POST
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$correo = $_POST['correo'] ?? '';
$clave = $_POST['clave'] ?? '';

// Validar campos obligatorios (puedes agregar más validaciones)
if (!$nombre || !$apellido || !$usuario || !$correo || !$clave) {
    die("Faltan datos obligatorios.");
}

// Hashear la contraseña
$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

// Preparar la consulta
$sql = "INSERT INTO usuarios (nombre, apellido, usuario, correo, clave) VALUES (:nombre, :apellido, :usuario, :correo, :clave)";
$stmt = $pdo->prepare($sql);

// Ejecutar
try {
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':usuario' => $usuario,
        ':correo' => $correo,
        ':clave' => $clave_hash
    ]);
    echo "Usuario registrado con éxito.";
    // Opcional: redirigir a login u otra página
    // header("Location: login.php");
} catch (Exception $e) {
    die("Error al guardar el usuario: " . $e->getMessage());
}
