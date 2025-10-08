<?php
// src/control/TokensController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/Token.php';

class TokensController {
    public function index(){
        require_login();
        $rows = Token::all();
        view('tokens/index', compact('rows'));
    }

    public function create(){
        require_login();
        $clients = Token::clients();
        view('tokens/form', ['row'=>null, 'clients'=>$clients]);
    }

    public function store(){
        require_login();

        $idClient = (int)($_POST['id_client_api'] ?? 0);
        if ($idClient <= 0) {
            set_flash('danger','Seleccione un cliente');
            redirect('?c=tokens&a=create');
        }

        // Generar token: randomhex-YYMMDD-idCliente
        $random = bin2hex(random_bytes(16)); // 32 chars hex
        $fecha  = date('ymd');               // YYMMDD
        $token  = $random . '-' . $fecha . '-' . $idClient;

        Token::create([
            'id_client_api' => $idClient,
            'token'         => $token,
            'estado'        => $_POST['estado'] ?? 'Activo'
        ]);

        set_flash('success','Token creado: ' . $token);
        redirect('?c=tokens');
    }

    public function edit(){
        require_login();
        $row = Token::find($_GET['id']??0);
        $clients = Token::clients();
        view('tokens/form', compact('row','clients'));
    }

    public function update(){
    require_login();

    $id       = (int)($_POST['id'] ?? 0);
    $idClient = (int)($_POST['id_client_api'] ?? 0);
    $estado   = $_POST['estado'] ?? 'Activo';

    if ($idClient <= 0) {
        set_flash('danger','Seleccione un cliente');
        redirect('?c=tokens&a=edit&id='.$id);
    }

    // Regenera SIEMPRE el token con el nuevo id del cliente
    $random = bin2hex(random_bytes(16)); // 32 chars hex
    $fecha  = date('ymd');               // YYMMDD
    $token  = $random . '-' . $fecha . '-' . $idClient;

    Token::update($id, [
        'id_client_api' => $idClient,
        'token'         => $token,
        'estado'        => $estado
    ]);

    set_flash('success','Token actualizado y regenerado');
    redirect('?c=tokens');
}


    public function delete(){
        require_login();
        Token::delete($_GET['id']??0);
        set_flash('success','Token eliminado');
        redirect('?c=tokens');
    }
}
