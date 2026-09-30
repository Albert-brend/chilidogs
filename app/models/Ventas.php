<?php
class Ventas {
    private $conexion;

    public function __construct() {
        require_once __DIR__ . '/../../config/conexion.php';
        $this->conexion = conectar();
    }

    public function obtenerVersion() {
        $sql = "SELECT 
              (SELECT COUNT(*) FROM ventas) AS c1,
              (SELECT MAX(updated_at) FROM ventas) AS m1,
              (SELECT COUNT(*) FROM detalles_venta) AS c2,
              (SELECT MAX(updated_at) FROM detalles_venta) AS m2";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return md5(json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
    }

    private function determinarEstado($abono, $total, $estadoActual = null) {
        if ($estadoActual === 'Entregada') {
            return 'Entregada';
        }
        return ((float) $abono >= (float) $total) ? 'Pagado' : 'Pendiente';
    }

    private function registrarAuditoria($tabla, $operacion, $registroId, array $datos, array $usuarioSesion) {
        $sql = "INSERT INTO auditoria 
                (tabla, operacion, registro_id, datos_anteriores, id_usuario, usuario, rol)
                VALUES 
                (:tabla, :operacion, :registro_id, :datos, :id_usuario, :usuario, :rol)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ':tabla'       => $tabla,
            ':operacion'   => $operacion,
            ':registro_id' => $registroId,
            ':datos'       => json_encode($datos, JSON_UNESCAPED_UNICODE),
            ':id_usuario'  => $usuarioSesion['id_usuario'] ?? null,
            ':usuario'     => $usuarioSesion['usuario'] ?? null,
            ':rol'         => $usuarioSesion['rol'] ?? null,
        ]);
    }

    public function registrarVenta($datosPedido, array $productos) {
        try {
            $this->conexion->beginTransaction();

            $estado = $this->determinarEstado($datosPedido['abono'], $datosPedido['total']);

            $sqlVenta = "INSERT INTO ventas 
                (cliente, correo, id_especialidad, anio, seccion, total, estado, abono) 
                VALUES 
                (:cliente, :correo, :id_especialidad, :anio, :seccion, :total, :estado, :abono)";

            $stmtVenta = $this->conexion->prepare($sqlVenta);
            $stmtVenta->execute([
                ':cliente'         => $datosPedido['cliente'],
                ':correo'          => $datosPedido['correo'],
                ':id_especialidad' => $datosPedido['id_especialidad'],
                ':anio'            => $datosPedido['anio'],
                ':seccion'         => $datosPedido['seccion'],
                ':total'           => $datosPedido['total'],
                ':estado'          => $estado,
                ':abono'           => $datosPedido['abono'],
            ]);

            $id_venta = $this->conexion->lastInsertId();

            $sqlDetalle = "INSERT INTO detalles_venta 
                (id_venta, id_producto, cantidad) 
                VALUES 
                (:id_venta, :id_producto, :cantidad)";
            $stmtDetalle = $this->conexion->prepare($sqlDetalle);

            foreach ($productos as $item) {
                $stmtDetalle->execute([
                    ':id_venta'    => $id_venta,
                    ':id_producto' => $item['id_producto'],
                    ':cantidad'    => $item['cantidad'],
                ]);
            }

            $this->conexion->commit();
            return $id_venta;

        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log('Error registrarVenta: ' . $e->getMessage());
            return false;
        }
    }

    public function actualizarVenta($id_venta, $datosPedido, array $productos) {
        try {
            $this->conexion->beginTransaction();

            $sqlEstadoActual = "SELECT estado FROM ventas WHERE id_venta = :id_venta";
            $stmtEstadoActual = $this->conexion->prepare($sqlEstadoActual);
            $stmtEstadoActual->execute([':id_venta' => $id_venta]);
            $estadoActual = $stmtEstadoActual->fetchColumn();

            $estado = $this->determinarEstado($datosPedido['abono'], $datosPedido['total'], $estadoActual);

            $sqlVenta = "UPDATE ventas SET
                cliente = :cliente,
                correo = :correo,
                id_especialidad = :id_especialidad,
                anio = :anio,
                seccion = :seccion,
                total = :total,
                estado = :estado,
                abono = :abono
                WHERE id_venta = :id_venta";

            $stmtVenta = $this->conexion->prepare($sqlVenta);
            $stmtVenta->execute([
                ':cliente'         => $datosPedido['cliente'],
                ':correo'          => $datosPedido['correo'],
                ':id_especialidad' => $datosPedido['id_especialidad'],
                ':anio'            => $datosPedido['anio'],
                ':seccion'         => $datosPedido['seccion'],
                ':total'           => $datosPedido['total'],
                ':estado'          => $estado,
                ':abono'           => $datosPedido['abono'],
                ':id_venta'        => $id_venta,
            ]);

            $sqlBorrarDetalle = "DELETE FROM detalles_venta WHERE id_venta = :id_venta";
            $stmtBorrar = $this->conexion->prepare($sqlBorrarDetalle);
            $stmtBorrar->execute([':id_venta' => $id_venta]);

            if (!empty($productos)) {
                $sqlDetalle = "INSERT INTO detalles_venta 
                    (id_venta, id_producto, cantidad) 
                    VALUES 
                    (:id_venta, :id_producto, :cantidad)";
                $stmtDetalle = $this->conexion->prepare($sqlDetalle);

                foreach ($productos as $item) {
                    $stmtDetalle->execute([
                        ':id_venta'    => $id_venta,
                        ':id_producto' => $item['id_producto'],
                        ':cantidad'    => $item['cantidad'],
                    ]);
                }
            }

            $this->conexion->commit();
            return true;

        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log('Error actualizarVenta: ' . $e->getMessage());
            return false;
        }
    }

    public function obtenerVentas() {
        $sql = "SELECT v.*, e.nombre AS especialidad 
                FROM ventas v
                LEFT JOIN especialidades e ON v.id_especialidad = e.id_especialidad
                ORDER BY v.id_venta DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDetallesVenta() {
        $sql = "SELECT dv.*, p.producto AS producto 
                FROM detalles_venta dv
                LEFT JOIN productos p ON dv.id_producto = p.id_producto
                ORDER BY dv.id_detalle DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerVentaPorId($id_venta) {
        $sql = "SELECT * FROM ventas WHERE id_venta = :id_venta";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id_venta' => $id_venta]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerDetallesVentaPorId($id_venta) {
        $sql = "SELECT dv.*, p.producto AS producto 
                FROM detalles_venta dv
                LEFT JOIN productos p ON dv.id_producto = p.id_producto
                WHERE dv.id_venta = :id_venta";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id_venta' => $id_venta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function marcarVentaEntregada($id_venta) {
        $sqlBuscar = "SELECT total FROM ventas WHERE id_venta = :id_venta";
        $stmtBuscar = $this->conexion->prepare($sqlBuscar);
        $stmtBuscar->execute([':id_venta' => $id_venta]);
        $venta = $stmtBuscar->fetch(PDO::FETCH_ASSOC);
        $total = $venta['total'];

        $sql = "UPDATE ventas SET estado = 'Entregada', abono = :total WHERE id_venta = :id_venta";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':total'    => $total,
            ':id_venta' => $id_venta
        ]);
    }

    public function actualizarAbono($id_venta, $abono) {
        $sqlVenta = "SELECT total, estado FROM ventas WHERE id_venta = :id_venta";
        $stmtVenta = $this->conexion->prepare($sqlVenta);
        $stmtVenta->execute([':id_venta' => $id_venta]);
        $venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);

        if (!$venta) {
            return false;
        }

        $estado = $this->determinarEstado($abono, $venta['total'], $venta['estado']);

        $sql = "UPDATE ventas SET abono = :abono, estado = :estado WHERE id_venta = :id_venta";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':abono'    => $abono,
            ':estado'   => $estado,
            ':id_venta' => $id_venta
        ]);
    }

    public function eliminarVenta($id_venta, array $usuarioSesion) {
        try {
            $this->conexion->beginTransaction();

            $stmtVenta = $this->conexion->prepare("SELECT * FROM ventas WHERE id_venta = :id_venta");
            $stmtVenta->execute([':id_venta' => $id_venta]);
            $venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);

            if (!$venta) {
                $this->conexion->rollBack();
                return false;
            }

            $stmtDet = $this->conexion->prepare("SELECT * FROM detalles_venta WHERE id_venta = :id_venta");
            $stmtDet->execute([':id_venta' => $id_venta]);
            $detalles = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

            foreach ($detalles as $detalle) {
                $this->registrarAuditoria('detalles_venta', 'DELETE', $detalle['id_detalle'], $detalle, $usuarioSesion);
            }
            $this->registrarAuditoria('ventas', 'DELETE', $id_venta, $venta, $usuarioSesion);

            $stmtEliminarDetalles = $this->conexion->prepare("DELETE FROM detalles_venta WHERE id_venta = :id_venta");
            $stmtEliminarDetalles->execute([':id_venta' => $id_venta]);

            $stmtEliminarVenta = $this->conexion->prepare("DELETE FROM ventas WHERE id_venta = :id_venta");
            $stmtEliminarVenta->execute([':id_venta' => $id_venta]);

            $this->conexion->commit();
            return true;

        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log('Error eliminarVenta: ' . $e->getMessage());
            return false;
        }
    }

    public function contarPrecioVentas() {
        $sql = "SELECT
                    COALESCE(SUM(abono), 0) AS total_abonado,
                    COALESCE(SUM(total), 0) AS total_ventas,
                    COALESCE(COUNT(total), 0) AS total_numero
                FROM ventas";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contarVentas() {
        $sql = "SELECT
                    COALESCE(SUM(CASE WHEN id_producto IN (1, 4) THEN cantidad ELSE 0 END), 0) AS total_chilli_dogs,
                    COALESCE(SUM(CASE WHEN id_producto IN (2, 4) THEN cantidad ELSE 0 END), 0) AS total_jugos
                FROM detalles_venta;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contarEstados() {
        $sql = "SELECT 
                    SUM(estado = 'Pendiente') AS estado_pendiente,
                    SUM(estado = 'Pagado')    AS estado_pagado,
                    SUM(estado = 'Entregada') AS estado_entregada
                FROM ventas;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function topEspecialidades($limit = 8) {
        $sql = "SELECT e.nombre AS especialidad,
                    COUNT(v.id_venta) AS total_ventas
                FROM ventas v
                JOIN especialidades e ON v.id_especialidad = e.id_especialidad
                GROUP BY e.id_especialidad, e.nombre
                ORDER BY total_ventas DESC
                LIMIT :limit";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cronogramaSecciones() {
        $sql = "SELECT DATE(v.updated_at) AS fecha,
                    v.anio,
                    COALESCE(e.nombre, 'Sin especialidad') AS especialidad,
                    v.seccion,
                    COUNT(*) AS ventas,
                    COALESCE(SUM(v.total), 0) AS total,
                    COALESCE(SUM(v.abono), 0) AS abonado
                FROM ventas v
                LEFT JOIN especialidades e ON v.id_especialidad = e.id_especialidad
                GROUP BY DATE(v.updated_at), v.anio, e.id_especialidad, e.nombre, v.seccion
                ORDER BY fecha ASC,
                         FIELD(v.anio, 'Primero', 'Segundo', 'Tercero'),
                         especialidad ASC,
                         v.seccion ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cronogramaParaExcel() {
        $sql = "SELECT DATE(v.updated_at) AS fecha,
                    v.anio,
                    COALESCE(e.nombre, 'Sin especialidad') AS especialidad,
                    v.seccion
                FROM ventas v
                LEFT JOIN especialidades e ON v.id_especialidad = e.id_especialidad
                GROUP BY DATE(v.updated_at), v.anio, e.id_especialidad, e.nombre, v.seccion
                ORDER BY fecha ASC,
                         FIELD(v.anio, 'Primero', 'Segundo', 'Tercero'),
                         especialidad ASC,
                         v.seccion ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}