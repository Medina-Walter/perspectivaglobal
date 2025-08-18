<?php session_start();
include("include/header.php"); ?>


<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <h4 class="text-center mt-3">Registro de Usuario</h4>

            <form class="form-control " action="guardar-registro.php" method="POST">
                <div class="">
                    <label class="form-label mt-3" for="nombre">Nombre</label>
                    <input class="form-control " type="text" name="nombre" id="nombre" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="apellido">Apellido</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="correo">Correo</label>
                    <input class="form-control" type="email" name="correo" id="correo" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="clave">Contraseña</label>
                    <input class="form-control" type="password" name="clave" id="clave" required>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary mt-3 w-100" type="submit">Registrarme</button>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>