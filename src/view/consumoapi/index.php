<?php ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Consumo de API - Buscar Clientes</h3>
  <a class="btn btn-outline-secondary" href="?">Volver</a>
</div>

<div class="card p-4 mb-4">
  <form id="formBuscarCliente">
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Token</label>
        <input type="text" name="token" id="token" class="form-control" placeholder="Ejemplo: API-123-1" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Razón Social</label>
        <input type="text" name="data" id="data" class="form-control" placeholder="Ejemplo: Cielo de Vestido">
      </div>
      <input type="hidden" name="tipo" value="verclienteapiByNombre">
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100">Consultar</button>
      </div>
    </div>
  </form>
</div>

<div class="card p-3">
  <h5 class="mb-3">Resultados</h5>
  <div id="resultado">
    <div class="text-muted">Ingrese un token y una razón social para realizar la búsqueda.</div>
  </div>
</div>

<script>
document.getElementById('formBuscarCliente').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  document.getElementById('resultado').innerHTML =
    '<div class="text-center text-muted p-3">Consultando API...</div>';

  fetch('?c=consumoapi&a=verClienteApiByNombre', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (!data.status) {
      document.getElementById('resultado').innerHTML =
        `<div class="alert alert-danger">${data.msg || 'Error en la consulta.'}</div>`;
      return;
    }

    const clientes = data.contenido;
    if (!clientes || clientes.length === 0) {
      document.getElementById('resultado').innerHTML =
        '<div class="alert alert-warning">No se encontraron resultados.</div>';
      return;
    }

    let html = `
      <div class="table-responsive">
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>RUC</th>
              <th>Razón Social</th>
              <th>Teléfono</th>
              <th>Correo</th>
              <th>Estado</th>
              <th>Fecha Registro</th>
            </tr>
          </thead>
          <tbody>
    `;
    clientes.forEach(c => {
      html += `
        <tr>
          <td>${c.id}</td>
          <td>${c.ruc}</td>
          <td>${c.razon_social}</td>
          <td>${c.telefono || '-'}</td>
          <td>${c.correo || '-'}</td>
          <td><span class="badge bg-${c.estado === 'Activo' ? 'success' : 'secondary'}">${c.estado}</span></td>
          <td>${c.fecha_registro || ''}</td>
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
</script>
