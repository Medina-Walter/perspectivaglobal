<?php
session_start();
include("include/header.php"); 
include("include/menu.php"); 
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <h4 class="text-center mt-4">Publicar Artículo</h4>

        <form class="form-control mt-3" action="guardar-articulo.php" method="POST" enctype="multipart/form-data">
            <div class="">
                <label class="form-label mt-3" for="titulo">Título</label>
                <input class="form-control " type="text" name="titulo" id="titulo" required>
            </div>
            
            <div class="">
                <label class="form-label mt-3" for="titulo">Selecciona una Categoría</label>
                <select class="form-control" name="categoria" id="categoria">
                    <option></option>
                    <option value="economia">Economía</option>
                    <option value="espectaculo">Espectáculo</option>
                    <option value="politica">Política</option>
                </select>
            </div>

            <div class="mt-3">
                <label class="form-label" for="contenido">Contenido</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="10" required></textarea>
            </div>

            <div class="mt-3">
                <label class="form-label" for="imagen">Imagen de Portada(Opcional)</label>
                <input class="form-control" type="file" name="imagen" id="imagen">
            </div>

            <div class="mt-3">
                <button class="btn btn-primary mt-3" type="submit">Publicar Artículo</button>
                <a class="btn btn-info mt-3" href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>