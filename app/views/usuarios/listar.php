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

    .usuarios-contenedor {
        max-width: 900px;
        margin: 0 auto;
        padding: 10px 20px 60px;
    }

    .usuarios-encabezado {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin: 10px 0 24px;
    }

    .usuarios-titulo {
        font-size: 32px;
        font-weight: 800;
        color: var(--texto-oscuro);
        margin: 0;
    }

    .btn-agregar-usuario {
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

    .btn-agregar-usuario:hover {
        filter: brightness(1.05);
        color: #ffffff;
    }

    .btn-agregar-usuario:active {
        transform: scale(0.97);
    }

    /* Cuadro que envuelve la tabla */
    .usuarios-cuadro {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(92, 61, 0, 0.10);
        overflow: hidden;
        border: 1px solid #f1e6c8;
    }

    table.usuarios-tabla {
        width: 100%;
        border-collapse: collapse;
    }

    .usuarios-tabla thead th {
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

    .usuarios-tabla tbody td {
        padding: 14px 18px;
        font-size: 14px;
        color: #3a3a3a;
        border-bottom: 1px solid #f1ecdd;
        vertical-align: middle;
    }

    .usuarios-tabla tbody tr:hover {
        background: #fffaf0;
    }

    .usuarios-tabla tbody tr:last-child td {
        border-bottom: none;
    }

    /* ---------- Badge de rol ---------- */
    .badge-rol {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-rol.admin {
        background: #fdece3;
        color: var(--naranja-2);
    }

    .badge-rol.usuario {
        background: #eef1f5;
        color: #3a4a5c;
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

    .usuarios-sin-acciones {
        color: #b0a894;
        font-size: 18px;
    }

    /* =========================================================
       RESPONSIVE: tabla -> tarjetas en pantallas pequeñas
       ========================================================= */
    @media (max-width: 600px) {
        .usuarios-cuadro {
            background: transparent;
            box-shadow: none;
            border: none;
        }

        .usuarios-tabla,
        .usuarios-tabla thead,
        .usuarios-tabla tbody,
        .usuarios-tabla tr,
        .usuarios-tabla td {
            display: block;
            width: 100%;
        }

        .usuarios-tabla thead {
            display: none;
        }

        .usuarios-tabla tbody tr {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(92, 61, 0, 0.10);
            border: 1px solid #f1e6c8;
            margin-bottom: 16px;
            padding: 14px 16px 16px;
        }

        .usuarios-tabla tbody td {
            border-bottom: 1px dashed #f1ecdd;
            padding: 10px 0;
            display: flex;
            gap: 10px;
            justify-content: space-between;
            align-items: center;
            text-align: right;
        }

        .usuarios-tabla tbody td:last-child {
            border-bottom: none;
        }

        .usuarios-tabla tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--texto-oscuro);
            text-align: left;
            flex-shrink: 0;
        }

        .usuarios-tabla tbody td[data-label="Id"] {
            border-bottom: 2px solid var(--amarillo);
            margin-bottom: 6px;
            padding-bottom: 10px;
            font-weight: 800;
            font-size: 15px;
            color: var(--naranja-2);
        }

        .usuarios-tabla tbody td[data-label="Id"]::before {
            content: "Usuario #";
            font-size: 13px;
        }

        .usuarios-tabla tbody td[data-label="Acciones"] {
            flex-direction: column;
            align-items: stretch;
            text-align: left;
        }

        .usuarios-tabla tbody td[data-label="Acciones"]::before {
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

<div class="usuarios-contenedor">
    <div class="usuarios-encabezado">
        <h1 class="usuarios-titulo">Usuarios</h1>
        <a href="<?php echo BASE_URL . '/usuarios/agregar'; ?>" class="btn-agregar-usuario">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Agregar Usuario
        </a>
    </div>

    <div class="usuarios-cuadro">
        <table class="usuarios-tabla">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td data-label="Id"><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                        <td data-label="Usuario"><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                        <td data-label="Nombre"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td data-label="Rol">
                            <span class="badge-rol <?= $usuario['rol'] === 'admin' ? 'admin' : 'usuario' ?>">
                                <?php echo $usuario['rol'] === 'admin' ? 'Administrador' : 'Usuario'; ?>
                            </span>
                        </td>
                        <td data-label="Acciones">
                            <?php if ($usuario['rol'] !== 'admin'): ?>
                                <div class="acciones">
                                    <a href="<?php echo BASE_URL . '/usuarios/editar/' . $usuario['id_usuario']; ?>" class="btn-accion btn-editar">Editar</a>
                                    <a href="<?php echo BASE_URL . '/usuarios/eliminar/' . $usuario['id_usuario']; ?>" class="btn-accion btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                                </div>
                            <?php else: ?>
                                <span class="usuarios-sin-acciones">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>