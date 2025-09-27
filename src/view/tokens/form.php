<?php $isEdit = !empty($row); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><?= $isEdit?'Editar':'Nuevo' ?> Token</h3>
  <a class="btn btn-outline-secondary" href="?c=tokens">Volver</a>
</div>
<div class="card p-3">
<form method="post" action="?c=tokens&a=<?= $isEdit?'update':'store' ?>">
  <?php if($isEdit): ?><input type="hidden" name="id" value="<?= e($row['id']) ?>"><?php endif; ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Cliente</label>
      <select name="id_client_api" class="form-select" required>
        <option value="">Seleccione…</option>
        <?php foreach($clients as $c): ?>
          <option value="<?= e($c['id']) ?>" <?= ($row['id_client_api']??'')==$c['id']?'selected':'' ?>><?= e($c['razon_social']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6"><label class="form-label">Token</label><input name="token" value="<?= e($row['token']??'') ?>" class="form-control" required></div>
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
