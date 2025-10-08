<?php $isEdit = !empty($row); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><?= $isEdit?'Editar':'Nuevo' ?> Token</h3>
  <a class="btn btn-outline-secondary" href="?c=tokens">Volver</a>
</div>
<div class="card p-3">
<form method="post" action="?c=tokens&a=<?= $isEdit?'update':'store' ?>">
  <?php if($isEdit): ?><input type="hidden" name="id" value="<?= e($row['id']) ?>"><?php endif; ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Cliente</label>
      <select name="id_client_api" class="form-select" required id="id_client_api">
        <option value="">Seleccione…</option>
        <?php foreach($clients as $c): ?>
          <option value="<?= e($c['id']) ?>" <?= ($row['id_client_api']??'')==$c['id']?'selected':'' ?>><?= e($c['razon_social']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Token</label>
      <input id="token_field"
             name="token"
             value="<?= e($row['token']??'') ?>"
             class="form-control"
             placeholder="Se genera automáticamente"
             readonly>
    </div>

    <div class="col-md-4">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select">
        <?php foreach(['Activo','Inactivo'] as $g): ?>
        <option value="<?= $g ?>" <?= ($row['estado']??'')===$g?'selected':'' ?>><?= $g ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mt-3"><button class="btn btn-primary"><?= $isEdit?'Actualizar':'Guardar' ?></button></div>
</form>
</div>

<script>
(function () {
  const sel = document.getElementById('id_client_api');
  const tokenField = document.getElementById('token_field');

  function randHex(len) {
    const bytes = new Uint8Array(len / 2);
    if (window.crypto && window.crypto.getRandomValues) {
      window.crypto.getRandomValues(bytes);
    } else {
      for (let i=0;i<bytes.length;i++) bytes[i] = Math.floor(Math.random()*256);
    }
    return Array.from(bytes).map(b => b.toString(16).padStart(2,'0')).join('');
  }

  function ymd() {
    const d = new Date();
    const yy = String(d.getFullYear()).slice(2);
    const mm = String(d.getMonth()+1).padStart(2,'0');
    const dd = String(d.getDate()).padStart(2,'0');
    return yy+mm+dd;
  }

  function makeToken(idCliente) {
    return randHex(32) + '-' + ymd() + '-' + idCliente;
  }

  // Al cambiar cliente, refrescar token mostrado (UX)
  sel.addEventListener('change', function () {
    if (this.value) tokenField.value = makeToken(this.value);
    else tokenField.value = '';
  });

  // Si es "Nuevo" y ya hay cliente seleccionado al cargar, pre-generar
  <?php if(!$isEdit): ?>
  if (sel.value) tokenField.value = makeToken(sel.value);
  <?php endif; ?>
})();
</script>
