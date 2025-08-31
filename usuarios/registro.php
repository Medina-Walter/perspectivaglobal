<?php 
$titulo = "Registro de Usuario";
session_start();
include("../include/header.php"); ?>

<?php
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <h4 class="text-center mt-3">Registro de Usuario</h4>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form class="form-control " action="guardar-registro.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                <div class="">
                    <label class="form-label mt-3" for="nombre">Nombre</label>
                    <input class="form-control " type="text" name="nombre" id="nombre" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="apellido">Apellido</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="usuario">Nombre de Usuario</label>
                    <input class="form-control" type="text" name="usuario" id="usuario" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="correo">Correo</label>
                    <input class="form-control" type="email" name="correo" id="correo" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="clave">Contraseña</label>
                    <input class="form-control" type="password" name="clave" id="clave" required>
                    <p>La contraseña debe contener al menos 8 caracteres</p>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary mt-3 w-100" type="submit">Registrarme</button>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>