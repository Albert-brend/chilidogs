<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Ventas.php';
require_once __DIR__ . '/../models/Especialidades.php';
require_once __DIR__ . '/../models/Productos.php';

class RegistrarVentaController {
    private const DESHABILITADO = false;
    private const VISTA_DESHABILITADO = __DIR__ . '/../views/modulo_deshabilitado.php';

    private $ventas;
    private $especialidades;
    private $productos;

    public function __construct() {
        if (self::DESHABILITADO) {
            $this->mostrarDeshabilitado();
        }

        $this->ventas = new Ventas();
        $this->especialidades = new Especialidades();
        $this->productos = new Productos();
    }

    private function mostrarDeshabilitado() {
        require self::VISTA_DESHABILITADO;
        exit;
    }

    public function index() {
        $id = null;
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente         = trim($_POST['nombre_cliente'] ?? '');
            $correo          = trim($_POST['correo'] ?? '');
            $id_especialidad = $_POST['especialidad'] ?? '';
            $anio            = $_POST['anio'] ?? '';
            $seccion         = $_POST['seccion'] ?? '';
            $productosJson   = $_POST['productos_json'] ?? '';
            $abono           = (float)($_POST['abono'] ?? 0);
            $estado          = trim($_POST['estado'] ?? 'Pendiente');

            // --- Validaciones de campos simples ---
            if ($cliente === '') $errores[] = 'El nombre del cliente es obligatorio.';
            if ($id_especialidad === '') $errores[] = 'Debe seleccionar una especialidad.';
            if ($anio === '') $errores[] = 'Debe seleccionar un año.';
            if ($seccion === '') $errores[] = 'Debe seleccionar una sección.';
            if ($productosJson === '') $errores[] = 'Debe agregar al menos un producto.';
            if ($abono < 0) $errores[] = 'El abono no puede ser negativo.';

            $total = 0;
            $productosValidos = [];

            if (empty($errores)) {
                $productosEnviados = json_decode($productosJson, true);

                if (!is_array($productosEnviados) || count($productosEnviados) === 0) {
                    $errores[] = 'Los productos seleccionados no son válidos.';
                } else {
                    foreach ($productosEnviados as $id_producto => $info) {
                        $cantidadProducto = (int)($info['cantidad'] ?? 0);

                        if (!ctype_digit((string)$id_producto) || $cantidadProducto <= 0) {
                            $errores[] = 'Uno de los productos seleccionados es inválido.';
                            continue;
                        }

                        $producto = $this->productos->obtenerProductoPorId($id_producto);

                        if (!$producto) {
                            $errores[] = 'Uno de los productos seleccionados ya no existe.';
                            continue;
                        }

                        $total += $producto['precio'] * $cantidadProducto;

                        $productosValidos[] = [
                            'id_producto' => (int)$id_producto,
                            'cantidad'    => $cantidadProducto,
                        ];
                    }

                    if (empty($productosValidos)) {
                        $errores[] = 'Debe agregar al menos un producto válido.';
                    }
                }
            }

            if (empty($errores) && $abono > $total) {
                $errores[] = 'El abono no puede ser mayor al total de la venta.';
            }

            // --- Guardar si no hay errores ---
            if (empty($errores)) {
                $datosPedido = [
                    'cliente'         => $cliente,
                    'correo'          => $correo,
                    'id_especialidad' => $id_especialidad,
                    'anio'            => $anio,
                    'seccion'         => $seccion,
                    'total'           => $total,
                    'estado'          => $estado,
                    'abono'           => $abono,
                ];

                $id_pedido = $this->ventas->registrarVenta($datosPedido, $productosValidos);

                if ($id_pedido) {
                    header("Location: " . BASE_URL . "/RegistrarVenta/buscarVenta/$id_pedido");
                    exit;
                } else {
                    $errores[] = 'Ocurrió un error al guardar la venta. Intente nuevamente.';
                }
            }
        }

        $especialidades = $this->especialidades->obtenerEspecialidades();
        $productos = $this->productos->obtenerProductos();
        require_once __DIR__ . '/../views/registrar_venta.php';
    }

    public function buscarVenta($id_venta) {
        $id = $id_venta;
        $errores = [];
        $especialidades = $this->especialidades->obtenerEspecialidades();
        $productos = $this->productos->obtenerProductos();
        require_once __DIR__ . '/../views/registrar_venta.php';
    }
}