<?php foreach ($selectVentas as $venta): ?>
    <tr>
        <td data-label="ID Venta"><?= $venta['id_venta'] ?></td>
        <td data-label="Cliente"><?= $venta['cliente'] ?></td>
        <td data-label="Correo"><?= $venta['correo'] ?></td>
        <td data-label="Especialidad"><?= $venta['especialidad'] ?></td>
        <td data-label="Año"><?= $venta['anio'] ?></td>
        <td data-label="Sección"><?= $venta['seccion'] ?></td>
        <td data-label="Detalles de productos">
            <?php
            foreach ($selectDetalles as $detalle) {
                if ($detalle['id_venta'] == $venta['id_venta']) {
                    echo "Producto: " . $detalle['producto'] . ", Cantidad: " . $detalle['cantidad'] . "<br>";
                }
            }
            ?>
        </td>
        <td data-label="Total">$<?= number_format((float) $venta['total'], 2) ?></td>
        <td data-label="Estado">
            <?php
                $estadoTexto = $venta['estado'];
                $estadoClase = 'pendiente';
                if (strtolower($estadoTexto) === 'pagado')    $estadoClase = 'pagado';
                if (strtolower($estadoTexto) === 'entregada') $estadoClase = 'entregada';
            ?>
            <span class="badge-estado <?= $estadoClase ?>"><?= $estadoTexto ?></span>
        </td>
        <td data-label="Abono">$<?= number_format((float) $venta['abono'], 2) ?></td>
        <td data-label="Acciones">
            <div class="acciones">
                <a href="<?= BASE_URL ?>/ventas/marcarEntregada/<?= $venta['id_venta'] ?>"
                   class="btn-accion btn-entregada"
                   onclick="return confirm('¿Estás seguro que desear marcar esta venta como entregada?')">
                    Marcar como entregada
                </a>
                <a href="#"
                   class="btn-accion btn-abonar"
                   data-bs-toggle="modal"
                   data-bs-target="#modalAbono"
                   data-id="<?= $venta['id_venta'] ?>"
                   data-cliente="<?= htmlspecialchars($venta['cliente']) ?>"
                   data-total="<?= htmlspecialchars($venta['total']) ?>"
                   data-abono="<?= htmlspecialchars($venta['abono']) ?>">
                    Abonar
                </a>
                <a href="<?= BASE_URL ?>/ventas/editar/<?= $venta['id_venta'] ?>" class="btn-accion btn-editar">Editar</a>
                <a href="<?= BASE_URL ?>/ventas/eliminar/<?= $venta['id_venta'] ?>"
                   class="btn-accion btn-eliminar"
                   onclick="return confirm('¿Estás seguro de eliminar esta venta?')">
                    Eliminar
                </a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>