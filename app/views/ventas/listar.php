<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<style>
    :root {
        --naranja-1: #e2542a;
        --naranja-2: #c1440e;
        --amarillo: #f7d354;
        --amarillo-oscuro: #f0c93e;
        --texto-oscuro: #5c3d00;
        --verde: #4caf7d;
        --verde-oscuro: #3d9c68;
    }

    .ventas-contenedor {
        max-width: 1300px;
        margin: 0 auto;
        padding: 10px 20px 60px;
    }

    .ventas-titulo {
        font-size: 32px;
        font-weight: 800;
        color: var(--texto-oscuro);
        margin: 10px 0 24px;
    }

    /* ---------- Buscador ---------- */
    .ventas-buscador {
        position: relative;
        width: 100%;
        margin: 0 0 14px;
    }

    .ventas-buscador input {
        width: 100%;
        padding: 12px 16px 12px 42px;
        border: 2px solid var(--amarillo);
        border-radius: 999px;
        font-size: 14px;
        outline: none;
        background: #ffffff;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .ventas-buscador input:focus {
        border-color: var(--naranja-1);
        box-shadow: 0 0 0 3px rgba(226, 84, 42, 0.12);
    }

    .ventas-buscador svg {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: #b89234;
        pointer-events: none;
    }

    /* ---------- Filtros por estado ---------- */
    .ventas-filtros {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 0 0 22px;
    }

    .chip-estado {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 999px;
        border: 2px solid var(--amarillo);
        background: #ffffff;
        color: var(--texto-oscuro);
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease, transform 0.1s ease;
    }

    .chip-estado:hover { background: #fffbe8; }
    .chip-estado:active { transform: scale(0.97); }

    .chip-estado .chip-count {
        min-width: 22px;
        padding: 1px 7px;
        border-radius: 999px;
        background: #f6efd6;
        color: var(--texto-oscuro);
        font-size: 11.5px;
        text-align: center;
    }

    /* Activo: general */
    .chip-estado.activo {
        background: var(--naranja-1);
        border-color: var(--naranja-1);
        color: #ffffff;
    }
    .chip-estado.activo .chip-count {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    /* Activo: colores por estado (coinciden con los badges) */
    .chip-estado[data-estado="pendiente"].activo { background: #f0b429; border-color: #f0b429; color: #4d3500; }
    .chip-estado[data-estado="pagado"].activo    { background: var(--verde); border-color: var(--verde); color: #ffffff; }
    .chip-estado[data-estado="entregada"].activo { background: #3b82d6; border-color: #3b82d6; color: #ffffff; }

    .chip-estado[data-estado="pendiente"].activo .chip-count { background: rgba(77, 53, 0, 0.15); color: #4d3500; }

    .ventas-sin-resultados {
        display: none;
        padding: 30px;
        text-align: center;
        color: #8a7550;
        font-size: 14px;
        background: #fff;
        border-radius: 16px;
        border: 1px dashed #f1e6c8;
    }

    .ventas-sin-resultados.visible {
        display: block;
    }

    /* El "cuadro" ahora es solo el contenedor de las tarjetas, sin fondo propio */
    .ventas-cuadro {
        background: transparent;
    }

    /* ---------- Tarjetas (mismo estilo en PC y en teléfono) ---------- */
    .ventas-tabla,
    .ventas-tabla thead,
    .ventas-tabla tbody,
    .ventas-tabla tr,
    .ventas-tabla td {
        display: block;
        width: 100%;
    }

    .ventas-tabla thead {
        display: none;
    }

    /* En pantallas grandes, las tarjetas se acomodan en una cuadrícula */
    .ventas-tabla tbody {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 18px;
        align-items: start;
    }

    .ventas-tabla tbody tr {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(92, 61, 0, 0.10);
        border: 1px solid #f1e6c8;
        padding: 14px 16px 16px;
    }

    .ventas-tabla tbody tr:hover {
        background: #fffdf6;
    }

    .ventas-tabla tbody td {
        border-bottom: 1px dashed #f1ecdd;
        padding: 10px 0;
        display: flex;
        gap: 10px;
        justify-content: space-between;
        align-items: flex-start;
        text-align: right;
        font-size: 14px;
        color: #3a3a3a;
    }

    .ventas-tabla tbody td:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .ventas-tabla tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: var(--texto-oscuro);
        text-align: left;
        flex-shrink: 0;
        min-width: 40%;
    }

    /* El ID de venta hace de "encabezado" visual de la tarjeta */
    .ventas-tabla tbody td[data-label="ID Venta"] {
        border-bottom: 2px solid var(--amarillo);
        margin-bottom: 6px;
        padding-bottom: 10px;
        font-weight: 800;
        font-size: 16px;
        color: var(--naranja-2);
    }

    .ventas-tabla tbody td[data-label="ID Venta"]::before {
        content: "Venta #";
        font-size: 13px;
    }

    /* Detalles de productos y Acciones se ven mejor en columna completa */
    .ventas-tabla tbody td[data-label="Detalles de productos"],
    .ventas-tabla tbody td[data-label="Acciones"] {
        flex-direction: column;
        align-items: stretch;
        text-align: left;
    }

    .ventas-tabla tbody td[data-label="Detalles de productos"]::before,
    .ventas-tabla tbody td[data-label="Acciones"]::before {
        margin-bottom: 6px;
    }

    .badge-estado {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-estado.pendiente { background: #fdecc8; color: #9a6a00; }
    .badge-estado.pagado    { background: #d9f2e6; color: #1f7a4d; }
    .badge-estado.entregada { background: #dcecff; color: #1a5aa8; }

    /* ---------- Botones de acción tipo pill ---------- */
    .acciones {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
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

    .btn-entregada {
        background: var(--verde);
        color: #ffffff;
    }
    .btn-entregada:hover { background: var(--verde-oscuro); color: #fff; }

    .btn-abonar {
        background: #eef1f5;
        color: #3a4a5c;
    }

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

    .btn-accion {
        flex: 1 1 auto;
    }

    /* En pantallas muy angostas, una sola columna (igual que antes) */
    @media (max-width: 480px) {
        .ventas-tabla tbody {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ventas-contenedor">
    <h1 class="ventas-titulo">Ventas</h1>

    <div class="ventas-buscador">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="buscadorVentas" placeholder="Buscar por ID, cliente, correo, especialidad...">
    </div>

    <div class="ventas-filtros" id="filtrosEstado">
        <button type="button" class="chip-estado activo" data-estado="todos">
            Todos <span class="chip-count" data-count="todos">0</span>
        </button>
        <button type="button" class="chip-estado" data-estado="pendiente">
            Pendiente <span class="chip-count" data-count="pendiente">0</span>
        </button>
        <button type="button" class="chip-estado" data-estado="pagado">
            Pagado <span class="chip-count" data-count="pagado">0</span>
        </button>
        <button type="button" class="chip-estado" data-estado="entregada">
            Entregada <span class="chip-count" data-count="entregada">0</span>
        </button>
    </div>

    <div class="ventas-cuadro">
        <table id="tablaVentas" class="ventas-tabla">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Especialidad</th>
                    <th>Año</th>
                    <th>Sección</th>
                    <th>Detalles de productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Abono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyVentas">
                <?php require __DIR__ . '/_filasVentas.php'; ?>
            </tbody>
        </table>

        <div class="ventas-sin-resultados" id="ventasSinResultados">
            No se encontraron ventas que coincidan con tu búsqueda.
        </div>
    </div>
</div>

<!-- Modal para actualizar el abono -->
<div class="modal fade" id="modalAbono" tabindex="-1" aria-labelledby="modalAbonoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAbono" method="POST" action="<?= BASE_URL ?>/ventas/actualizarAbono">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAbonoLabel">Actualizar abono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_venta" id="abono_id_venta">
                    <p id="abono_clienteTexto" class="mb-3"></p>
                    <div class="mb-3">
                        <label class="form-label">Total a pagar</label>
                        <input type="text" class="form-control" id="abono_total" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Abono</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="abono_valor" name="abono" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let ultimaVersionVentas = null;
let filtroEstadoActual = 'todos';

function inicializarBotonesAbono() {
    document.querySelectorAll('.btn-abonar').forEach(function (link) {
        link.addEventListener('click', function () {
            document.getElementById('abono_id_venta').value = this.dataset.id;
            document.getElementById('abono_total').value = this.dataset.total;
            document.getElementById('abono_valor').value = this.dataset.abono;
            document.getElementById('abono_clienteTexto').textContent = 'Cliente: ' + this.dataset.cliente;
            document.getElementById('formAbono').action =
                '<?= BASE_URL ?>/ventas/actualizarAbono/' + this.dataset.id;
        });
    });
}

function revisarCambiosVentas() {
    fetch('<?= BASE_URL ?>/ventas/version')
        .then(res => res.json())
        .then(data => {
            if (ultimaVersionVentas === null) {
                ultimaVersionVentas = data.version;
                return;
            }
            if (data.version !== ultimaVersionVentas) {
                ultimaVersionVentas = data.version;
                actualizarTablaVentas();
            }
        })
        .catch(err => console.error('Error revisando cambios de ventas:', err));
}

function actualizarTablaVentas() {
    fetch('<?= BASE_URL ?>/ventas/tablaAjax')
        .then(res => res.text())
        .then(html => {
            document.getElementById('tbodyVentas').innerHTML = html;
            inicializarBotonesAbono();
            filtrarVentas(); // mantiene el estado y el texto seleccionados
        })
        .catch(err => console.error('Error actualizando tabla de ventas:', err));
}

function obtenerEstadoFila(fila) {
    return (fila.querySelector('td[data-label="Estado"]')?.textContent || '').trim().toLowerCase();
}

// Actualiza los contadores de cada chip (siempre sobre el total de ventas)
function actualizarContadoresEstado() {
    const conteo = { todos: 0, pendiente: 0, pagado: 0, entregada: 0 };

    document.querySelectorAll('#tbodyVentas tr').forEach(function (fila) {
        conteo.todos++;
        const estado = obtenerEstadoFila(fila);
        if (estado in conteo) conteo[estado]++;
    });

    document.querySelectorAll('.chip-count').forEach(function (span) {
        span.textContent = conteo[span.dataset.count] ?? 0;
    });
}

function filtrarVentas() {
    const texto = (document.getElementById('buscadorVentas').value || '').trim().toLowerCase();
    const filas = document.querySelectorAll('#tbodyVentas tr');
    const sinResultados = document.getElementById('ventasSinResultados');
    let visibles = 0;

    // Permite escribir "#12" o "12" para buscar por ID exacto
    const textoSinNumeral = texto.replace(/^#/, '');
    const esBusquedaPorId = /^\d+$/.test(textoSinNumeral);

    filas.forEach(function (fila) {
        const idVenta = (fila.querySelector('td[data-label="ID Venta"]')?.textContent || '').trim().toLowerCase();
        const cliente = (fila.querySelector('td[data-label="Cliente"]')?.textContent || '').toLowerCase();
        const correo = (fila.querySelector('td[data-label="Correo"]')?.textContent || '').toLowerCase();
        const especialidad = (fila.querySelector('td[data-label="Especialidad"]')?.textContent || '').toLowerCase();
        const detalles = (fila.querySelector('td[data-label="Detalles de productos"]')?.textContent || '').toLowerCase();
        const estado = obtenerEstadoFila(fila);

        // 1) Filtro por chip de estado
        const coincideEstado = filtroEstadoActual === 'todos' || estado === filtroEstadoActual;

        // 2) Filtro por texto
        let coincideTexto;
        if (texto === '') {
            coincideTexto = true;
        } else if (esBusquedaPorId) {
            // Coincidencia exacta con el ID (1 no trae 10, 11, 21...)
            coincideTexto = idVenta === textoSinNumeral;
        } else {
            coincideTexto =
                estado.includes(texto) ||
                cliente.includes(texto) ||
                correo.includes(texto) ||
                especialidad.includes(texto) ||
                detalles.includes(texto);
        }

        const coincide = coincideEstado && coincideTexto;
        fila.style.display = coincide ? '' : 'none';
        if (coincide) visibles++;
    });

    sinResultados.classList.toggle('visible', visibles === 0);
    actualizarContadoresEstado();
}

document.addEventListener('DOMContentLoaded', function () {
    inicializarBotonesAbono();
    setInterval(revisarCambiosVentas, 3000);

    const buscador = document.getElementById('buscadorVentas');
    buscador.addEventListener('input', filtrarVentas);

    // Chips de estado
    document.querySelectorAll('#filtrosEstado .chip-estado').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.querySelectorAll('#filtrosEstado .chip-estado').forEach(function (c) {
                c.classList.remove('activo');
            });
            this.classList.add('activo');
            filtroEstadoActual = this.dataset.estado;
            filtrarVentas();
        });
    });

    filtrarVentas(); // calcula los contadores iniciales
});
</script>