<?php
// src/control/consumoApiController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/ClientApi.php';
require_once __DIR__ . '/../model/ConsumoApi.php';
require_once __DIR__ . '/../model/Token.php';  // ✅ se agrega para validar token activo

class ConsumoApiController
{
    public function index()
    {
        view('consumoapi/index');
    }

    // Ruta: ?c=consumoapi&a=verDocenteApiByNombreODni
    // Espera: POST { tipo:'verdocenteapibynombreodni', token, data }
    public function verDocenteApiByNombreODni()
    {
        header('Content-Type: application/json; charset=utf-8');

        $tipo  = strtolower($_POST['tipo'] ?? '');
        $term  = trim((string)($_POST['data'] ?? ''));
        $token = trim((string)($_POST['token'] ?? ''));

        if ($tipo !== 'verdocenteapibynombreodni') {
            echo json_encode(['status' => false, 'msg' => '❌ Parámetro tipo inválido']);
            return;
        }

        // ✅ Validar token: ahora es obligatorio y debe estar activo
        if ($token === '') {
            echo json_encode(['status' => false, 'msg' => '❌ Token requerido']);
            return;
        }

        $validacion = Token::validarTokenActivo($token);
        if (!$validacion['valido']) {
            echo json_encode(['status' => false, 'msg' => '❌ ' . $validacion['msg']]);
            return;
        }

        // Si el término está vacío, no buscamos nada
        if ($term === '') {
            echo json_encode(['status' => true, 'msg' => '', 'contenido' => []]);
            return;
        }

        // ✅ Buscar docentes
        try {
            $docentes = ConsumoApi::buscarDocentes($term, 50, 0);
            echo json_encode([
                'status' => true,
                'msg' => '',
                'contenido' => $docentes,
                'cliente' => $validacion['data']['razon_social'] ?? null
            ]);
        } catch (\Throwable $e) {
            echo json_encode(['status' => false, 'msg' => 'Error interno del servidor']);
        }
    }
}
