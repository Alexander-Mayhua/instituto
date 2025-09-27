<?php
// src/control/DocentesController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/Docente.php';

class DocentesController {
    public function index() { require_login(); $rows = Docente::all(); view('docentes/index', compact('rows')); }
    public function create() { require_login(); view('docentes/form', ['row'=>null]); }
    public function store() {
        require_login();
        Docente::create($_POST);
        set_flash('success','Docente creado');
        redirect('?c=docentes');
    }
    public function edit() { require_login(); $row = Docente::find($_GET['id'] ?? 0); view('docentes/form', compact('row')); }
    public function update() { require_login(); Docente::update($_POST['id'], $_POST); set_flash('success','Docente actualizado'); redirect('?c=docentes'); }
    public function delete() { require_login(); Docente::delete($_GET['id'] ?? 0); set_flash('success','Docente eliminado'); redirect('?c=docentes'); }
}
