<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<?php requerirRol("admin"); ?>

<style>
    :root {
        --naranja-1: #e2542a;
        --naranja-2: #c1440e;
        --amarillo: #f7d354;
        --amarillo-oscuro: #f0c93e;
        --texto-oscuro: #5c3d00;
    }

    .productos-contenedor {
        max-width: 900px;
        margin: 0 auto;
        padding: 10px 20px 60px;
    }

    .productos-encabezado {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin: 10px 0 24px;
    }

    .productos-titulo {
        font-size: 32px;
        font-weight: 800;
        color: var(--texto-oscuro);
        margin: 0;
    }

    .btn-agregar-producto {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border: none;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--naranja-1), var(--naranja-2));
        color: #ffffff;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        transition: filter 0.15s ease, transform 0.1s ease;
    }

    .btn-agregar-producto:hover {
        filter: brightness(1.05);
        color: #ffffff;
    }

    .btn-agregar-producto:active {
        transform: scale(0.97);
    }

    /* Cuadro que envuelve la tabla */
    .productos-cuadro {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(92, 61, 0, 0.10);
        overflow: hidden;
        border: 1px solid #f1e6c8;
    }

    table.productos-tabla {
        width: 100%;
        border-collapse: collapse;
    }

    .productos-tabla thead th {
        text-align: left;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: var(--texto-oscuro);
        background: #fff6da;
        padding: 14px 18px;
        border-bottom: 2px solid var(--amarillo);
        white-space: nowrap;
    }

    .productos-tabla tbody td {
        padding: 14px 18px;
        font-size: 14px;
        color: #3a3a3a;
        border-bottom: 1px solid #f1ecdd;
        vertical-align: middle;
    }

    .productos-tabla tbody tr:hover {
        background: #fffaf0;
    }

    .productos-tabla tbody tr:last-child td {
        border-bottom: none;
    }

    .productos-tabla td.col-precio {
        font-weight: 700;
        color: var(--naranja-2);
    }

    /* ---------- Botones de acción tipo pill ---------- */
    .acciones {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-accion {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        transition: filter 0.15s ease, transform 0.1s ease;
    }

    .btn-accion:hover { filter: brightness(0.95); }
    .btn-accion:active { transform: scale(0.97); }

    .btn-editar {
        background: var(--amarillo);
        color: var(--texto-oscuro);
    }
    .btn-editar:hover { background: var(--amarillo-oscuro); color: var(--texto-oscuro); }

    .btn-eliminar {
        background: var(--naranja-1);
        color: #ffffff;
    }
    .btn-eliminar:hover { background: var(--naranja-2); color: #fff; }

    /* =========================================================
       RESPONSIVE: tabla -> tarjetas en pantallas pequeñas
       ========================================================= */
    @media (max-width: 600px) {
        .productos-cuadro {
            background: transparent;
            box-shadow: none;
            border: none;
        }

        .productos-tabla,
        .productos-tabla thead,
        .productos-tabla tbody,
        .productos-tabla tr,
        .productos-tabla td {
            display: block;
            width: 100%;
        }

        .productos-tabla thead {
            display: none;
        }

        .productos-tabla tbody tr {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(92, 61, 0, 0.10);
            border: 1px solid #f1e6c8;
            margin-bottom: 16px;
            padding: 14px 16px 16px;
        }

        .productos-tabla tbody td {
            border-bottom: 1px dashed #f1ecdd;
            padding: 10px 0;
            display: flex;
            gap: 10px;
            justify-content: space-between;
            align-items: center;
            text-align: right;
        }

        .productos-tabla tbody td:last-child {
            border-bottom: none;
        }

        .productos-tabla tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--texto-oscuro);
            text-align: left;
            flex-shrink: 0;
        }

        .productos-tabla tbody td[data-label="Id"] {
            border-bottom: 2px solid var(--amarillo);
            margin-bottom: 6px;
            padding-bottom: 10px;
            font-weight: 800;
            font-size: 15px;
            color: var(--naranja-2);
        }

        .productos-tabla tbody td[data-label="Id"]::before {
            content: "Producto #";
            font-size: 13px;
        }

        .productos-tabla tbody td[data-label="Acciones"] {
            flex-direction: column;
            align-items: stretch;
            text-align: left;
        }

        .productos-tabla tbody td[data-label="Acciones"]::before {
            margin-bottom: 6px;
        }

        .acciones {
            justify-content: flex-start;
        }

        .btn-accion {
            flex: 1 1 auto;
        }
    }
</style>

<div class="productos-contenedor">
    <div class="productos-encabezado">
        <h1 class="productos-titulo">Productos</h1>
        <a href="<?php echo BASE_URL . '/productos/agregar'; ?>" class="btn-agregar-producto">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Agregar Producto
        </a>
    </div>

    <div class="productos-cuadro">
        <table class="productos-tabla">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td data-label="Id"><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                        <td data-label="Nombre"><?php echo htmlspecialchars($producto['producto']); ?></td>
                        <td data-label="Precio" class="col-precio">$<?php echo htmlspecialchars(number_format((float) $producto['precio'], 2)); ?></td>
                        <td data-label="Acciones">
                            <div class="acciones">
                                <a href="<?php echo BASE_URL . '/productos/editar/' . $producto['id_producto']; ?>" class="btn-accion btn-editar">Editar</a>
                                <a href="<?php echo BASE_URL . '/productos/eliminar/' . $producto['id_producto']; ?>" class="btn-accion btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>