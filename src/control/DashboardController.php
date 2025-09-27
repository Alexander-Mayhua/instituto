<?php
// src/control/DashboardController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/Dashboard.php';

class DashboardController {
    public function index() {
        require_login();
        $metrics = Dashboard::metrics();
        $byEstado = Dashboard::docentesByEstado();
        $byGrado  = Dashboard::docentesByGrado();
        view('dashboard/index', compact('metrics','byEstado','byGrado'));
    }
}
