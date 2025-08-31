<div class="modal fade" id="cambiarPasswordModal" tabindex="-1" aria-labelledby="cambiarPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="cambiarPasswordLabel">Cambiar Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form action="actualizar-clave.php" method="POST">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="mb-3">
                <label>Contraseña actual</label>
                <input type="password" name="clave_actual" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nueva contraseña</label>
                <input type="password" name="clave_nueva" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirmar nueva contraseña</label>
                <input type="password" name="clave_confirmar" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>
