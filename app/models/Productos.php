<?php
class Productos {
    private $conexion;

    public function __construct() {
        require_once __DIR__ . '/../../config/conexion.php';
        $this->conexion = conectar();
    }

    public function agregarProducto($producto, $precio) {
        $sql = "INSERT INTO productos (producto, precio) VALUES (:producto, :precio)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':producto' => $producto, ':precio' => $precio]);
    }

    public function actualizarProducto($id_producto, $producto, $precio) {
        $sql = "UPDATE productos SET producto = :producto, precio = :precio WHERE id_producto = :id_producto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':producto' => $producto, ':precio' => $precio, ':id_producto' => $id_producto]);
    }

    public function eliminarProducto($id_producto) {
        $sql = "DELETE FROM productos WHERE id_producto = :id_producto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id_producto' => $id_producto]);
    }

    public function obtenerProductos() {
        $sql = "SELECT * FROM productos";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($id_producto) {
        $sql = "SELECT * FROM productos WHERE id_producto = :id_producto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id_producto' => $id_producto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerTodosLosProductos() {
        $sql = "SELECT * FROM productos";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}