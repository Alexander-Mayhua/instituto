<?php ?>
<h3 class="mb-3">Usuarios (sin contraseña)</h3>
<div class="card p-3">
<div class="table-responsive">
<table class="table table-sm">
  <thead><tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Estado</th><th>Registro</th></tr></thead>
  <tbody>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?= e($r['id_usuario']) ?></td>
      <td><?= e($r['usuario']) ?></td>
      <td class="text-capitalize"><?= e($r['rol']) ?></td>
      <td><span class="badge bg-<?= $r['estado']=='Activo'?'success':'secondary' ?>"><?= e($r['estado']) ?></span></td>
      <td><?= e($r['fecha_registro']) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
