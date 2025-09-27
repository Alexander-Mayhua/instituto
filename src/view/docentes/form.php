<?php $isEdit = !empty($row); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><?= $isEdit?'Editar':'Nuevo' ?> Docente</h3>
  <a class="btn btn-outline-secondary" href="?c=docentes">Volver</a>
</div>
<div class="card p-3">
<form method="post" action="?c=docentes&a=<?= $isEdit?'update':'store' ?>">
  <?php if($isEdit): ?><input type="hidden" name="id" value="<?= e($row['id_docente']) ?>"><?php endif; ?>
  <div class="row g-3">
    <div class="col-md-3"><label class="form-label">DNI</label><input name="dni" value="<?= e($row['dni']??'') ?>" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Nombres</label><input name="nombres" value="<?= e($row['nombres']??'') ?>" class="form-control" required></div>
    <div class="col-md-5"><label class="form-label">Apellidos</label><input name="apellidos" value="<?= e($row['apellidos']??'') ?>" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Correo</label><input type="email" name="correo" value="<?= e($row['correo']??'') ?>" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Teléfono</label><input name="telefono" value="<?= e($row['telefono']??'') ?>" class="form-control"></div>
    <div class="col-md-5"><label class="form-label">Especialidad</label><input name="especialidad" value="<?= e($row['especialidad']??'') ?>" class="form-control"></div>
    <div class="col-md-4">
      <label class="form-label">Grado</label>
      <select name="grado_academico" class="form-select">
        <?php foreach(['Bachiller','Licenciado','Magister','Doctor'] as $g): ?>
        <option value="<?= $g ?>" <?= ($row['grado_academico']??'')===$g?'selected':'' ?>><?= $g ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select">
        <?php foreach(['Activo','Inactivo'] as $g): ?>
        <option value="<?= $g ?>" <?= ($row['estado']??'')===$g?'selected':'' ?>><?= $g ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary"><?= $isEdit?'Actualizar':'Guardar' ?></button>
  </div>
</form>
</div>
