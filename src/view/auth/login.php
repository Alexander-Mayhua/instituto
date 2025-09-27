<?php require_once __DIR__ . '/../layout/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-12 col-md-5">
    <div class="card p-4">
      <h4 class="mb-3 text-center">Iniciar sesión</h4>
      <?php if($m=get_flash('danger')): ?><div class="alert alert-danger"><?= e($m) ?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Usuario (DNI)</label>
          <input name="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Clave</label>
          <input type="password" name="clave" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Ingresar</button>
      </form>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
