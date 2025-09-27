<?php
// src/library/helpers.php
function view($path, $data = []) {
    extract($data);
    $viewFile = __DIR__ . '/../view/' . $path . '.php';
    if (!file_exists($viewFile)) {
        http_response_code(404);
        echo 'Vista no encontrada: ' . htmlspecialchars($path);
        exit;
    }
    require __DIR__ . '/../view/layout/header.php';
    require $viewFile;
    require __DIR__ . '/../view/layout/footer.php';
}
function partial($path, $data = []) {
    extract($data);
    require __DIR__ . '/../view/' . $path . '.php';
}
function redirect($url) {
    header('Location: ' . $url); exit;
}
function is_logged() {
    return !empty($_SESSION['user']);
}
function require_login() {
    if (!is_logged()) redirect('?c=auth&a=login');
}
function set_flash($type, $msg) {
    $_SESSION['flash'][$type] = $msg;
}
function get_flash($type) {
    if (!empty($_SESSION['flash'][$type])) {
        $m = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $m;
    }
    return null;
}
function e($str){ return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }
