<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Ventas.php';
require_once __DIR__ . '/../models/Especialidades.php';
require_once __DIR__ . '/../models/Productos.php';

class VentasController {
    private $ventas;
    private $especialidades;
    private $productos;

    public function __construct() {
        $this->ventas = new Ventas();
        $this->especialidades = new Especialidades();
        $this->productos = new Productos();
    }

    public function index() {
        $selectVentas = $this->ventas->obtenerVentas();
        $selectDetalles = $this->ventas->obtenerDetallesVenta();
        require_once __DIR__ . '/../views/ventas/listar.php';
    }

    public function marcarEntregada($id_venta) {
        $resultado = $this->ventas->marcarVentaEntregada($id_venta);
        if ($resultado) {
            header("Location: " . BASE_URL . "/ventas");
            exit();
        } else {
            echo "Error al marcar la venta como entregada.";
        }
    }

    public function actualizarAbono() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_venta = $_POST['id_venta'];
            $abono = $_POST['abono'];

            $resultado = $this->ventas->actualizarAbono($id_venta, $abono);
            if ($resultado) {
                header("Location: " . BASE_URL . "/ventas");
                exit();
            } else {
                echo "Error al actualizar el abono.";
            }
        }
    }

    public function editar($id_venta) {
        $venta = $this->ventas->obtenerVentaPorId($id_venta);
        $selectDetalles = $this->ventas->obtenerDetallesVentaPorId($id_venta);
        $especialidades = $this->especialidades->obtenerEspecialidades();
        $productos = $this->productos->obtenerProductos();
        require_once __DIR__ . '/../views/ventas/editar.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_venta = $_POST['id_venta'];

            $productosJson = $_POST['productos_json'] ?? '[]';
            $productosSeleccionados = json_decode($productosJson, true) ?: [];

            $productos = [];
            foreach ($productosSeleccionados as $id_producto => $item) {
                $productos[] = [
                    'id_producto' => $id_producto,
                    'cantidad'    => $item['cantidad'],
                ];
            }

            $datosPedido = [
                'cliente'         => $_POST['nombre_cliente'],
                'correo'          => $_POST['correo'] !== '' ? $_POST['correo'] : null,
                'id_especialidad' => $_POST['especialidad'],
                'anio'            => $_POST['anio'],
                'seccion'         => $_POST['seccion'],
                'total'           => $_POST['total'],
                'abono'           => $_POST['abono'],
            ];

            $resultado = $this->ventas->actualizarVenta($id_venta, $datosPedido, $productos);

            if ($resultado) {
                header("Location: " . BASE_URL . "/ventas");
                exit();
            } else {
                echo "Error al actualizar la venta.";
            }
        }
    }

    public function eliminar($id_venta) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id_usuario'])) {
            header("Location: " . BASE_URL . "/login");
            exit();
        }

        $usuarioSesion = [
            'id_usuario' => $_SESSION['id_usuario'],
            'usuario'    => $_SESSION['usuario'],
            'rol'        => $_SESSION['rol'],
        ];

        $resultado = $this->ventas->eliminarVenta($id_venta, $usuarioSesion);
        if ($resultado) {
            header("Location: " . BASE_URL . "/ventas");
            exit();
        } else {
            echo "Error al eliminar la venta.";
        }
    }

    public function version() {
        header('Content-Type: application/json');
        echo json_encode(['version' => $this->ventas->obtenerVersion()]);
        exit;
    }

    public function tablaAjax() {
        $selectVentas   = $this->ventas->obtenerVentas();
        $selectDetalles = $this->ventas->obtenerDetallesVenta();
        require __DIR__ . '/../views/ventas/_filasVentas.php';
        exit;
    }
}