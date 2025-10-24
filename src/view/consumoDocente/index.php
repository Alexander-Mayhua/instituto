<?php
// src/view/consumoDocente/index.php
$tokenValue = $_POST['token'] ?? ($_GET['token'] ?? '');
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Buscar Docentes (Consumo API)</h3>
  <a class="btn btn-outline-secondary" href="?c=home">Volver</a>
</div>

<?php include __DIR__ . '/form.php'; ?>

<div class="card p-3 mt-4">
  <h5 class="mb-3">Resultados</h5>
  <div class="table-responsive">
    <table class="table table-sm table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>DNI</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Especialidad</th>
          <th>Grado Académico</th>
          <th>Estado</th>
          <th>Fecha Registro</th>
        </tr>
      </thead>
      <tbody id="contenido">
        <tr><td colspan="9" class="text-muted">Ingrese un nombre, apellido o DNI y presione Buscar.</td></tr>
      </tbody>
    </table>
  </div>
</div>

<script>
document.getElementById('frmApiDocente').addEventListener('submit', async function(e) {
  e.preventDefault();
  const datos  = new FormData(this);
  const $tbody = document.getElementById('contenido');

  const tokenVal = (datos.get('token') || '').trim();
  if (!tokenVal) {
    $tbody.innerHTML = `<tr><td colspan="9" class="text-danger">Falta el token. No se puede buscar.</td></tr>`;
    return;
  }

  $tbody.innerHTML = `<tr><td colspan="9" class="text-muted">Consultando...</td></tr>`;

  try {
    const res  = await fetch('?c=consumodocente&a=buscar', { method:'POST', body: datos });
    const json = await res.json().catch(() => null);

    if (!res.ok || !json) {
      $tbody.innerHTML = `<tr><td colspan="9" class="text-danger">Error en la consulta${res.status ? ' (HTTP '+res.status+')' : ''}.</td></tr>`;
      return;
    }
    if (json.status === false) {
      $tbody.innerHTML = `<tr><td colspan="9" class="text-danger">${esc(json.msg || 'Error en la consulta.')}</td></tr>`;
      return;
    }

    const lista = Array.isArray(json.contenido) ? json.contenido : [];
    if (lista.length === 0) {
      $tbody.innerHTML = `<tr><td colspan="9" class="text-warning">No se encontraron resultados.</td></tr>`;
      return;
    }

    let html = '';
    let i = 0;
    for (const d of lista) {
      i++;
      const activo = (d.estado === 'Activo');
      html += `
        <tr>
          <td>${i}</td>
          <td>${esc(d.id_docente)}</td>
          <td>${esc(d.dni)}</td>
          <td>${esc(d.nombres)}</td>
          <td>${esc(d.apellidos)}</td>
          <td>${esc(d.especialidad || '-')}</td>
          <td>${esc(d.grado_academico)}</td>
          <td><span class="badge text-bg-${activo ? 'success' : 'secondary'}">${esc(d.estado || '')}</span></td>
          <td>${esc(d.fecha_registro || '')}</td>
        </tr>`;
    }
    $tbody.innerHTML = html;

  } catch (err) {
    console.error(err);
    $tbody.innerHTML = `<tr><td colspan="9" class="text-danger">Error al conectar con el servidor.</td></tr>`;
  }
});

document.getElementById('btnLimpiarDoc').addEventListener('click', () => {
  document.getElementById('data').value = '';
  document.getElementById('contenido').innerHTML =
    `<tr><td colspan="9" class="text-muted">Ingrese un nombre, apellido o DNI y presione Buscar.</td></tr>`;
});

function esc(v) {
  if (v === null || v === undefined) return '';
  return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
