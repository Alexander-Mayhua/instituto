<?php
// index.php
session_start();
require_once __DIR__ . '/src/config/config.php';
require_once __DIR__ . '/src/library/helpers.php';

$c = strtolower($_GET['c'] ?? 'dashboard');
$a = strtolower($_GET['a'] ?? 'index');

$map = [
  'auth' => 'AuthController',
  'dashboard' => 'DashboardController',
  'docentes' => 'DocentesController',
  'usuarios' => 'UsuariosController',
  'clientapi' => 'ClientApiController',
  'tokens' => 'TokensController',
  'consumoapi' =>'consumoApiController'
];

if (!isset($map[$c])) { http_response_code(404); echo 'Controlador no encontrado'; exit; }

require_once __DIR__ . '/src/control/' . $map[$c] . '.php';
$controller = new $map[$c]();

if (!method_exists($controller, $a)) { http_response_code(404); echo 'Acción no encontrada'; exit; }

$controller->$a();
