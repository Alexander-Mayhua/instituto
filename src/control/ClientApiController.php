<?php
// src/control/ClientApiController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/ClientApi.php';
class ClientApiController
{
    public function index()
    {
        require_login();
        $rows = ClientApi::all();
        view('client_api/index', compact('rows'));
    }
    public function create()
    {
        require_login();
        view('client_api/form', ['row' => null]);
    }
    public function store()
    {
        require_login();
        ClientApi::create($_POST);
        set_flash('success', 'Cliente creado');
        redirect('?c=clientapi');
    }
    public function edit()
    {
        require_login();
        $row = ClientApi::find($_GET['id'] ?? 0);
        view('client_api/form', compact('row'));
    }
    public function update()
    {
        require_login();
        ClientApi::update($_POST['id'], $_POST);
        set_flash('success', 'Cliente actualizado');
        redirect('?c=clientapi');
    }
    public function delete()
    {
        require_login();
        ClientApi::delete($_GET['id'] ?? 0);
        set_flash('success', 'Cliente eliminado');
        redirect('?c=clientapi');
    }


    public function verClienteApiByNombre()
    {
        //require_login();

        $tipo = $_POST['tipo'] ?? '';
        $token = $_POST['token'] ?? '';
        $data  = $_POST['data'] ?? '';

        if ($tipo == "verclienteapiByNombre") {
            $token_arr = explode("-", $token);
            $id_cliente = $token_arr[2] ?? null;

            if (!$id_cliente) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Token inválido o incompleto'
                ]);
                return;
            }

            $arr_Cliente = ClientApi::buscarClienteById($id_cliente);

            if ($arr_Cliente && $arr_Cliente['estado'] === 'Activo') {
                $arr_clientes = ClientApi::buscarClienteByDenominacion($data);
                $arr_Respuesta = [
                    'status' => true,
                    'msg' => '',
                    'contenido' => $arr_clientes
                ];
            } else {
                $arr_Respuesta = [
                    'status' => false,
                    'msg' => 'Error, cliente no activo o no encontrado'
                ];
            }

            echo json_encode($arr_Respuesta);
        }
    }
}
/*
if($tipo=="verclienteapiByNonmbre"){
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2];
    $arr_Cliente = $objApi->buscarClienteById($id_cliente);
    if($arr_Cliente->estado){
        $data = $_POST['data'];
        $arr_bienes = $objApi->buscarclienteByDenominacion($data);
        $arr_Respuesta=array('status' => true,'msg'='', 'contenido' =>$arr_bioenes);
    }else{
        $arr_Respuesta=array('status' => false,'msg'='Error, cliente no activo');
    }
    echo json_enconde ($arr_Respuesta);
}*/