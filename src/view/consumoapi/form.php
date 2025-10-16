<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Consultar Cliente API</h3>
  <a class="btn btn-outline-secondary" href="?c=home">Volver</a>
</div>

<div class="card p-4">
  <form id="formConsumoApi" method="post">
    <div class="row g-3">
      <div class="col-md-12">
        <label class="form-label">Token</label>
        <input type="text" name="token" id="token" class="form-control" placeholder="Ejemplo: API-123-1" required>
      </div>

      <div class="col-md-12">
        <label class="form-label">Tipo de consulta</label>
        <input type="text" name="tipo" id="tipo" class="form-control" value="verclienteapiByNombre" readonly>
      </div>

      <div class="col-md-12">
        <label class="form-label">Razón Social</label>
        <input type="text" name="data" id="data" class="form-control" placeholder="Ejemplo: Cielo de Vestido SAC">
      </div>
    </div>

    <div class="mt-4 text-center">
      <button type="submit" class="btn btn-primary w-50">Consultar</button>
    </div>
  </form>

  <div id="resultado" class="mt-4">
    <!-- Aquí se mostrará el resultado JSON -->
  </div>
</div>

<script>
document.getElementById('formConsumoApi').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('?c=consumoapi&a=verClienteApiByNombre', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
      document.getElementById('resultado').innerHTML =
        '<h6>Resultado:</h6><pre class="bg-light p-3 rounded">' + JSON.stringify(data, null, 2) + '</pre>';
  })
  .catch(err => {
      document.getElementById('resultado').innerHTML =
        '<div class="alert alert-danger">Error al consultar la API.</div>';
  });
});
</script>
