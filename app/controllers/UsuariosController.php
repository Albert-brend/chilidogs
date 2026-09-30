<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Usuarios.php';

class UsuariosController {
    private $usuarios;

    public function __construct() {
        $this->usuarios = new Usuarios();
    }

    public function index() {
        $usuarios = $this->usuarios->obtenerTodos();
        require_once __DIR__ . '/../views/usuarios/listar.php';
    }

    public function agregar() {
        require_once __DIR__ . '/../views/usuarios/agregar.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['contrasena'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $this->usuarios->crear($usuario, $contrasena, $nombre, $rol);
            header("Location: " . BASE_URL . "/usuarios");
            exit();
        }
    }

    public function editar($id_usuario) {
        $usuario = $this->usuarios->obtenerPorId($id_usuario);

        if (!$usuario) {
            header("Location: " . BASE_URL . "/usuarios");
            exit();
        }

        if ($usuario['rol'] === 'admin') {
            header("Location: " . BASE_URL . "/usuarios");
            exit();
        }

        require_once __DIR__ . '/../views/usuarios/editar.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_POST['id_usuario'];

            $usuarioActual = $this->usuarios->obtenerPorId($id_usuario);

            if (!$usuarioActual || $usuarioActual['rol'] === 'admin') {
                header("Location: " . BASE_URL . "/usuarios");
                exit();
            }

            $usuario = $_POST['usuario'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $contrasena = $_POST['contrasena'] ?? '';
            $this->usuarios->actualizar($id_usuario, $usuario, $nombre, $rol, $contrasena);
            header("Location: " . BASE_URL . "/usuarios");
            exit();
        }
    }

    public function eliminar($id_usuario) {
        $usuario = $this->usuarios->obtenerPorId($id_usuario);

        if (!$usuario || $usuario['rol'] === 'admin') {
            header("Location: " . BASE_URL . "/usuarios");
            exit();
        }

        $this->usuarios->eliminar($id_usuario);
        header("Location: " . BASE_URL . "/usuarios");
        exit();
    }
}