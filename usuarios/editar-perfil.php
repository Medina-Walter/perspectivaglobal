<?php
$titulo = "Edita tú Perfil";
include("../include/header.php");
include("../config.php");
include("../include/menu.php");


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$id_usuario = $_SESSION['id_usuario'];
$sql = 'SELECT * FROM usuarios WHERE id_usuario = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <h4 class="text-center mt-3">Edita tu Información</h4>

            <form class="form-control " action="actualizar-perfil.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                <div class="">
                    <label class="form-label mt-3" for="nombre">Nombre</label>
                    <input class="form-control " type="text" name="nombre" id="nombre" value="<?php echo $usuario['nombre'];?>">
                </div>

                <div class="mt-3">
                    <label class="form-label" for="apellido">Apellido</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $usuario['apellido'];?>">
                </div>

                <div class="mt-3">
                    <label class="form-label" for="foto_perfil">Foto de Perfil</label>
                    <input class="form-control" type="file" name="foto_perfil" id="foto_perfil">
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary mt-3 w-40" type="submit">Actualizar Perfil</button>
                    <a class="btn btn-info mt-3" href="miperfil.php">Cancelar</a>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<?php include("../include/footer.php");?>