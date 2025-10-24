<?php
// Vista: buscar DOCENTES con token oculto (validación en backend)
// Toma el token del servidor (sesión o querystring). El usuario NO lo ve ni lo completa.
if (session_status() === PHP_SESSION_NONE) session_start();
$tokenValue = $_SESSION['api_token'] ?? ($_GET['token'] ?? ''); // <- ajusta si usas otra fuente
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Consumo de API - Buscar Docentes</h3>
  <a class="btn btn-outline-secondary" href="?">Volver</a>
</div>

<div class="card p-4 mb-4">
  <form id="formBuscarDocente">
    <div class="row g-3 align-items-end">
      <!-- 🔒 Token oculto (no se muestra ni se pide) -->
      <input type="hidden" name="token" id="token"
             value="<?= htmlspecialchars($tokenValue, ENT_QUOTES, 'UTF-8') ?>">

      <div class="col-md-8">
        <label class="form-label">Nombre / Apellido / DNI</label>
        <input type="text" name="data" id="data" class="form-control" placeholder="Ej.: Ana, Pérez o 12345678">
        <input type="hidden" name="tipo" value="verdocenteapibynombreodni">
      </div>

      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100">Buscar</button>
      </div>
    </div>
  </form>
</div>

<div class="card p-3">
  <h5 class="mb-3">Resultados</h5>
  <div id="resultado">
    <div class="text-muted">Escriba un nombre/apellido o un DNI para buscar.</div>
  </div>
</div>

<script>
document.getElementById('formBuscarDocente').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  // No pedimos token al usuario: se envía el oculto. (El backend valida.)
  document.getElementById('resultado').innerHTML =
    '<div class="text-center text-muted p-3">Consultando API...</div>';

  fetch('?c=consumoapi&a=verDocenteApiByNombreODni', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (!data || data.status === false) {
      document.getElementById('resultado').innerHTML =
        `<div class="alert alert-danger">${(data && data.msg) ? data.msg : 'Error en la consulta.'}</div>`;
      return;
    }

    const docentes = data.contenido || [];
    if (docentes.length === 0) {
      document.getElementById('resultado').innerHTML =
        '<div class="alert alert-warning">No se encontraron resultados.</div>';
      return;
    }

    let html = `
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
          <tbody>
    `;
    let i = 0;
    docentes.forEach(d => {
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
          <td>${esc(d.grado_academico || '')}</td>
          <td><span class="badge bg-${activo ? 'success' : 'secondary'}">${esc(d.estado || '')}</span></td>
          <td>${esc(d.fecha_registro || '')}</td>
        </tr>`;
    });
    html += '</tbody></table></div>';

    document.getElementById('resultado').innerHTML = html;
  })
  .catch(err => {
    console.error(err);
    document.getElementById('resultado').innerHTML =
      '<div class="alert alert-danger">Error al conectar con el servidor.</div>';
  });
});

function esc(v){
  if (v === null || v === undefined) return '';
  return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
