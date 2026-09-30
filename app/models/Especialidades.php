<?php
class Especialidades {
    private $conexion;

    public function __construct() {
        require_once __DIR__ . '/../../config/conexion.php';
        $this->conexion = conectar();
    }

    public function obtenerEspecialidades() {
        $sql = "SELECT * FROM especialidades";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}