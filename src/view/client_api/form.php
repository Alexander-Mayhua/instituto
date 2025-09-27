<?php $isEdit = !empty($row); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><?= $isEdit?'Editar':'Nuevo' ?> Cliente API</h3>
  <a class="btn btn-outline-secondary" href="?c=clientapi">Volver</a>
</div>
<div class="card p-3">
<form method="post" action="?c=clientapi&a=<?= $isEdit?'update':'store' ?>">
  <?php if($isEdit): ?><input type="hidden" name="id" value="<?= e($row['id']) ?>"><?php endif; ?>
  <div class="row g-3">
    <div class="col-md-4"><label class="form-label">RUC</label><input name="ruc" value="<?= e($row['ruc']??'') ?>" class="form-control" required></div>
    <div class="col-md-8"><label class="form-label">Razón Social</label><input name="razon_social" value="<?= e($row['razon_social']??'') ?>" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Teléfono</label><input name="telefono" value="<?= e($row['telefono']??'') ?>" class="form-control"></div>
    <div class="col-md-8"><label class="form-label">Correo</label><input type="email" name="correo" value="<?= e($row['correo']??'') ?>" class="form-control"></div>
    <div class="col-md-4">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select">
        <?php foreach(['Activo','Inactivo'] as $g): ?>
        <option value="<?= $g ?>" <?= ($row['estado']??'')===$g?'selected':'' ?>><?= $g ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mt-3"><button class="btn btn-primary"><?= $isEdit?'Actualizar':'Guardar' ?></button></div>
</form>
</div>
