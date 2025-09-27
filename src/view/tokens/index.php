<?php ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Tokens</h3>
  <a class="btn btn-primary" href="?c=tokens&a=create">Nuevo</a>
</div>
<div class="card p-3">
<div class="table-responsive">
<table class="table table-sm">
  <thead><tr><th>ID</th><th>Cliente</th><th>Token</th><th>Estado</th><th>Fecha</th><th></th></tr></thead>
  <tbody>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?= e($r['id']) ?></td>
      <td><?= e($r['razon_social']) ?></td>
      <td><code><?= e($r['token']) ?></code></td>
      <td><span class="badge bg-<?= $r['estado']=='Activo'?'success':'secondary' ?>"><?= e($r['estado']) ?></span></td>
      <td><?= e($r['fecha_reg']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-primary" href="?c=tokens&a=edit&id=<?= $r['id'] ?>">Editar</a>
        <a class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')" href="?c=tokens&a=delete&id=<?= $r['id'] ?>">Eliminar</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
