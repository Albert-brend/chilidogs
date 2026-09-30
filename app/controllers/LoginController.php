<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/auth.php';   // ← agregar esta línea
require_once __DIR__ . '/../models/Usuarios.php';

class LoginController {
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuarios();
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['contrasena'];

            $usuarioR = $this->usuario->obtenerUsuarioPorUsuario($usuario);

            if ($usuarioR && password_verify($contrasena, $usuarioR['contrasena'])) {
                iniciarSesion();
                $_SESSION['id_usuario'] = $usuarioR['id_usuario'];
                $_SESSION['usuario']    = $usuarioR['usuario'];
                $_SESSION['nombre']     = $usuarioR['nombre'];
                $_SESSION['rol']        = $usuarioR['rol'];

                header("Location: " . BASE_URL . "/registrarVenta");
                exit;
            }
        }
        require_once __DIR__ . '/../views/login.php';
    }
}