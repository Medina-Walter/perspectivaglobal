<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include("include/menu.php");
    menu(); ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow"> <!--Contenedor principal -->
                    <div class="card-header text-white" style="background-color: #F37E00;">
                        <h3 class="mb-0">Iniciar sesión</h3>
                    </div>

                    <div class="card-body">
                        <?php if (isset($_SESSION['error_login'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= $_SESSION['error_login'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php unset($_SESSION['error_login']); ?>
                        <?php  endif; ?>
                        <form action="validar_login.php" method="POST">
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" name="correo" id="correo" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" name="clave" id="clave" class="form-control" required />
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn text-white" style="background-color: #F37E00;">
                                    Ingresar
                                </button>
                            </div>
                        </form>
                    </div>
                </div> <!-- Cierre del contenedor central -->
            </div>
        </div>
    </div>
    <footer class="fixed-bottom text-center text-black py-3" style="background-color: #F37E00;">
        <p class="mb-0">&copy; 2025 Miblog. Todos los derechos reservados.</p>
    </footer>
</body>
</html>