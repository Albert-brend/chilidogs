<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Ventas.php';
require_once __DIR__ . '/../models/Especialidades.php';
require_once __DIR__ . '/../models/Productos.php';

class DashboardController {
    private $ventas;
    private $especialidades;
    private $productos;

    public function __construct() {
        $this->ventas = new Ventas();
        $this->especialidades = new Especialidades();
        $this->productos = new Productos();
    }

    public function index() {
        $precios = $this->ventas->contarPrecioVentas();
        $totalVentas = $this->ventas->contarVentas();
        $especialidades = $this->ventas->topEspecialidades();
        $estados = $this->ventas->contarEstados();

        require_once __DIR__ . '/../views/dashboard.php';
    }

    public function version() {
        header('Content-Type: application/json');
        echo json_encode(['version' => $this->ventas->obtenerVersion()]);
        exit;
    }

    public function datosAjax() {
        header('Content-Type: application/json');
        echo json_encode([
            'precios'        => $this->ventas->contarPrecioVentas(),
            'totales'        => $this->ventas->contarVentas(),
            'estados'        => $this->ventas->contarEstados(),
            'especialidades' => $this->ventas->topEspecialidades(),
        ]);
        exit;
    }

    public function cronograma() {
        header('Content-Type: application/json');
        echo json_encode([
            'cronograma' => $this->ventas->cronogramaSecciones(),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}