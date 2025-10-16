<?php
// src/view/dashboard/index.php
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">Dashboard</h2>
  <span class="text-muted">Bienvenido a <?= e(APP_NAME) ?></span>
</div>
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3"><div class="card p-3"><div class="small text-muted">Docentes</div><div class="h3"><?= (int)$metrics['docentes'] ?></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="card p-3"><div class="small text-muted">Usuarios</div><div class="h3"><?= (int)$metrics['usuarios'] ?></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="card p-3"><div class="small text-muted">Clientes API</div><div class="h3"><?= (int)$metrics['clientes'] ?></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="card p-3"><div class="small text-muted">Tokens</div><div class="h3"><?= (int)$metrics['tokens'] ?></div></div></div>
  <div class="col-sm-6 col-lg-3">
  <div class="card p-3">
    <div class="small text-muted">Consumo API</div>
    <div class="h3"><?= (int)$metrics['consumoapi'] ?></div>
  </div>
</div>

</div>
<div class="row g-3">
  <div class="col-lg-8">
    <div class="card p-3">
      <h5 class="mb-3">Docentes por Grado</h5>
      <canvas id="chartGrado"></canvas>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card p-3">
      <h5 class="mb-3">Estado de Docentes</h5>
      <canvas id="chartEstado"></canvas>
    </div>
  </div>
</div>
<script>
const byGrado = <?= json_encode($byGrado) ?>;
const byEstado = <?= json_encode($byEstado) ?>;
new Chart(document.getElementById('chartGrado'), {
  type: 'bar',
  data: {
    labels: byGrado.map(x=>x.grado),
    datasets: [{label:'Docentes', data: byGrado.map(x=>Number(x.total))}]
  }
});
new Chart(document.getElementById('chartEstado'), {
  type: 'doughnut',
  data: {
    labels: byEstado.map(x=>x.estado),
    datasets: [{label:'Total', data: byEstado.map(x=>Number(x.total))}]
  }
});
</script>
