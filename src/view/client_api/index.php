<?php ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Clientes API</h3>
  <a class="btn btn-primary" href="?c=clientapi&a=create">Nuevo</a>
</div>
<div class="card p-3">
<div class="table-responsive">
<table class="table table-sm">
  <thead><tr><th>ID</th><th>RUC</th><th>Razón Social</th><th>Teléfono</th><th>Correo</th><th>Estado</th><th>Registro</th><th></th></tr></thead>
  <tbody>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?= e($r['id']) ?></td>
      <td><?= e($r['ruc']) ?></td>
      <td><?= e($r['razon_social']) ?></td>
      <td><?= e($r['telefono']) ?></td>
      <td><?= e($r['correo']) ?></td>
      <td><span class="badge bg-<?= $r['estado']=='Activo'?'success':'secondary' ?>"><?= e($r['estado']) ?></span></td>
      <td><?= e($r['fecha_registro']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-primary" href="?c=clientapi&a=edit&id=<?= $r['id'] ?>">Editar</a>
        <a class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')" href="?c=clientapi&a=delete&id=<?= $r['id'] ?>">Eliminar</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
