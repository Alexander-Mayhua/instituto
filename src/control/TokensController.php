<?php
// src/control/TokensController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/Token.php';
class TokensController {
    public function index(){ require_login(); $rows = Token::all(); view('tokens/index', compact('rows')); }
    public function create(){ require_login(); $clients = Token::clients(); view('tokens/form', ['row'=>null, 'clients'=>$clients]); }
    public function store(){ require_login(); Token::create($_POST); set_flash('success','Token creado'); redirect('?c=tokens'); }
    public function edit(){ require_login(); $row = Token::find($_GET['id']??0); $clients = Token::clients(); view('tokens/form', compact('row','clients')); }
    public function update(){ require_login(); Token::update($_POST['id'], $_POST); set_flash('success','Token actualizado'); redirect('?c=tokens'); }
    public function delete(){ require_login(); Token::delete($_GET['id']??0); set_flash('success','Token eliminado'); redirect('?c=tokens'); }

   

}
