<?php
// src/view/consumoDocente/form.php
$tokenValue = $_POST['token'] ?? ($_GET['token'] ?? '');
?>
<div class="card p-4">
  <form id="frmApiDocente" method="post" class="row g-3 align-items-end">
    <!-- 🔒 Token oculto -->
    <input type="hidden" name="token" id="token"
           value="<?= htmlspecialchars($tokenValue, ENT_QUOTES, 'UTF-8') ?>">

    <div class="col-md-6">
      <label class="form-label">Nombre / Apellido / DNI</label>
      <input type="text" name="data" id="data" class="form-control" placeholder="Ej.: Ana, Pérez o 12345678">
    </div>

    <div class="col-md-3">
      <button type="submit" class="btn btn-primary w-100">Buscar</button>
    </div>
    <div class="col-md-3">
      <button type="button" id="btnLimpiarDoc" class="btn btn-outline-secondary w-100">Limpiar</button>
    </div>
  </form>

  <?php if (!$tokenValue): ?>
    <div class="alert alert-warning mt-3 mb-0">
      No se encontró el token. Esta búsqueda requiere un token válido.
    </div>
  <?php endif; ?>
</div>
