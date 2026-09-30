<?php
class Usuarios {
    private $conexion;

    public function __construct() {
        require_once __DIR__ . '/../../config/conexion.php';
        $this->conexion = conectar();
    }

    public function crear($usuario, $contrasena, $nombre, $rol) {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (usuario, contrasena, nombre, rol)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario, $hash, $nombre, $rol]);
        return $this->conexion->lastInsertId();
    }

    public function actualizar($id_usuario, $usuario, $nombre, $rol, $contrasena = null) {
        if (!empty($contrasena)) {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios
                    SET usuario = ?, nombre = ?, rol = ?, contrasena = ?
                    WHERE id_usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario, $nombre, $rol, $hash, $id_usuario]);
        } else {
            $sql = "UPDATE usuarios
                    SET usuario = ?, nombre = ?, rol = ?
                    WHERE id_usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario, $nombre, $rol, $id_usuario]);
        }
    }

    public function eliminar($id_usuario) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_usuario]);
    }

    public function obtenerTodos() {
        $sql = "SELECT id_usuario, usuario, nombre, rol FROM usuarios";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id_usuario) {
        $sql = "SELECT id_usuario, usuario, nombre, rol
                FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuarioPorUsuario($usuario) {
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}