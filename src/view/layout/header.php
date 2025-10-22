<?php
if (session_status()===PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../library/helpers.php';

// ✅ Ocultar header/footer cuando c=consumoapi (y opcionalmente por acción)
$controller = strtolower($_GET['c'] ?? '');
$action     = strtolower($_GET['a'] ?? 'index');
$hideChrome = ($controller === 'consumoapi'); // si quieres solo en index: && $action === 'index'
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<style>
body{ background:#f5f7fb; }
.card{ box-shadow:0 8px 20px rgba(0,0,0,.05); border:none; border-radius:1rem;}
.sidebar{min-height:100vh;background:#102a43;color:#fff}
.sidebar a{color:#d9e2ec;text-decoration:none;display:block;padding:.75rem 1rem;border-radius:.5rem}
.sidebar a.active,.sidebar a:hover{background:#243b53;color:#fff}
.navbar-brand{font-weight:700}
</style>
</head>
<body>

<?php if (!$hideChrome && is_logged()): ?>
<div class="container-fluid">
  <div class="row">
    <aside class="col-12 col-md-3 col-lg-2 p-3 sidebar">
      <div class="d-flex align-items-center mb-4">
        <div class="rounded-circle bg-light me-2" style="width:44px;height:44px"></div>
        <div>
          <div><?= e($_SESSION['user']['usuario']) ?></div>
          <small class="text-info text-capitalize"><?= e($_SESSION['user']['rol']) ?></small>
        </div>
      </div>
      <a class="<?= ($_GET['c']??'dashboard')==='dashboard'?'active':'' ?>" href="?">🏠 Dashboard</a>
      <a class="<?= ($_GET['c']??'')==='docentes'?'active':'' ?>" href="?c=docentes">👩‍🏫 Docentes</a>
      <a class="<?= ($_GET['c']??'')==='usuarios'?'active':'' ?>" href="?c=usuarios">👥 Usuarios</a>
      <a class="<?= ($_GET['c']??'')==='clientapi'?'active':'' ?>" href="?c=clientapi">🧩 Client API</a>
      <a class="<?= ($_GET['c']??'')==='tokens'?'active':'' ?>" href="?c=tokens">🔑 Tokens</a>
      <a class="<?= ($_GET['c']??'')==='consumoapi'?'active':'' ?>" href="?c=consumoapi">📊 Consumo API</a>
      <hr>
      <a href="?c=auth&a=logout">⏻ Salir</a>
    </aside>
    <main class="col-12 col-md-9 col-lg-10 p-4">
      <?php if($m=get_flash('success')): ?><div class="alert alert-success"><?= e($m) ?></div><?php endif; ?>
      <?php if($m=get_flash('danger')): ?><div class="alert alert-danger"><?= e($m) ?></div><?php endif; ?>
<?php else: ?>
<!-- Modo sin chrome (consumoapi o sin login): contenedor simple -->
<div class="container py-4">
<?php endif; ?>
