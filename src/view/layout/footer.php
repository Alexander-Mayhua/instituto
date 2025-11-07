<?php
if (session_status()===PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../library/helpers.php';

$controller = strtolower($_GET['c'] ?? '');
$action     = strtolower($_GET['a'] ?? 'index');
$hideChrome = ($controller === 'consumoapi'); 
// mismo criterio que en header.php
?>

<?php if (!$hideChrome && is_logged()): ?>
    </main>
  </div>
</div>
<?php else: ?>
</div> <!-- cierra <div class="container py-4"> del modo sin chrome -->
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
