<?php ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Docentes</h3>
  <a class="btn btn-primary" href="?c=docentes&a=create">Nuevo</a>
</div>
<div class="card p-3">
  <div class="table-responsive">
  <table class="table table-sm align-middle">
    <thead><tr>
      <th>ID</th><th>DNI</th><th>Nombres</th><th>Apellidos</th><th>Correo</th><th>Teléfono</th><th>Especialidad</th><th>Grado</th><th>Estado</th><th></th>
    </tr></thead>
    <tbody>
      <?php foreach($rows as $r): ?>
      <tr>
        <td><?= e($r['id_docente']) ?></td>
        <td><?= e($r['dni']) ?></td>
        <td><?= e($r['nombres']) ?></td>
        <td><?= e($r['apellidos']) ?></td>
        <td><?= e($r['correo']) ?></td>
        <td><?= e($r['telefono']) ?></td>
        <td><?= e($r['especialidad']) ?></td>
        <td><?= e($r['grado_academico']) ?></td>
        <td><span class="badge bg-<?= $r['estado']=='Activo'?'success':'secondary' ?>"><?= e($r['estado']) ?></span></td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-primary" href="?c=docentes&a=edit&id=<?= $r['id_docente'] ?>">Editar</a>
          <a class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')" href="?c=docentes&a=delete&id=<?= $r['id_docente'] ?>">Eliminar</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>
