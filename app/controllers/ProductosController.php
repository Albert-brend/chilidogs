<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Productos.php';

class ProductosController {
    private $productos;

    public function __construct() {
        $this->productos = new Productos();
    }

    public function index() {
        $productos = $this->productos->obtenerTodosLosProductos();
        require_once __DIR__ . '/../views/productos/listar.php';
    }

    public function agregar() {
        require_once __DIR__ . '/../views/productos/agregar.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = $_POST['producto'];
            $precio = $_POST['precio'];
            $this->productos->agregarProducto($producto, $precio);
            header("Location: " . BASE_URL . "/productos");
            exit();
        }
    }

    public function editar($id_producto) {
        $producto = $this->productos->obtenerProductoPorId($id_producto);
        require_once __DIR__ . '/../views/productos/editar.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_producto = $_POST['id_producto'];
            $producto = $_POST['producto'];
            $precio = $_POST['precio'];
            $this->productos->actualizarProducto($id_producto, $producto, $precio);
            header("Location: " . BASE_URL . "/productos");
            exit();
        }
    }

    public function eliminar($id_producto) {
        $this->productos->eliminarProducto($id_producto);
        header("Location: " . BASE_URL . "/productos");
        exit();
    }
}