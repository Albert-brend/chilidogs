<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php requerirRol("admin"); ?>

<?php
// ---- Presupuesto (independiente de las metas) ----
$presupuestoMeta = 158;               // "Dinero esperado" de la dona

// ---- Metas monetarias (independientes del presupuesto) ----
$metas    = [250, 300, 350];          // hitos de la barra
$metaMax  = max($metas);              // tope de la barra

$abonado  = (float) ($precios['total_abonado'] ?? 0);

// Dona: abonado vs presupuesto
$pctPresupuesto = $presupuestoMeta > 0 ? min(100, (int) round($abonado / $presupuestoMeta * 100)) : 0;

// Barra y ganancia esperada: abonado vs meta máxima
$pctMetas    = $metaMax > 0 ? min(100, (int) round($abonado / $metaMax * 100)) : 0;
$pctGanancia = $metaMax > 0 ? (int) round($abonado / $metaMax * 100) : 0;
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lilita+One&display=swap" rel="stylesheet">

<style>
:root {
    --naranja: #f04e14;
    --naranja-oscuro: #d9441c;
    --amarillo: #ffd600;
    --cafe: #5a3000;
    --gris-pista: #d9d9d9;
    --texto: #1f1f1f;
    --texto-suave: #6b6b6b;
    --borde: #e3e3e3;
}

.dash-wrap {
    font-family: 'Inter', sans-serif;
    color: var(--texto);
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 24px 40px;
    box-sizing: border-box;
}
.dash-wrap * { box-sizing: border-box; }

.dash-titulo {
    font-family: 'Lilita One', sans-serif;
    font-weight: 400;
    font-size: 28px;
    color: var(--cafe);
    margin: 0 0 20px;
}

/* ---------- Grid PC ---------- */
.dash-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    grid-template-areas:
        "presupuesto metas"
        "estadisticas top";
    gap: 20px;
    align-items: start;
}
.card-presupuesto  { grid-area: presupuesto; }
.card-metas        { grid-area: metas; }
.card-estadisticas { grid-area: estadisticas; }
.card-top          { grid-area: top; }

.dash-card {
    background: #fff;
    border: 1px solid var(--borde);
    border-radius: 18px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
    padding: 22px 24px;
}
.dash-card h2 {
    font-size: 15px;
    font-weight: 600;
    margin: 0 0 16px;
}

/* ---------- Presupuesto (dona) ---------- */
.presupuesto-body {
    display: flex;
    align-items: center;
    gap: 16px;
}
.dona {
    --pct: 0;
    width: 110px;
    height: 110px;
    flex-shrink: 0;
    border-radius: 50%;
    background: conic-gradient(var(--naranja-oscuro) calc(var(--pct) * 1%), #e6e6e6 0);
    display: grid;
    place-items: center;
    position: relative;
}
.dona::before {
    content: '';
    position: absolute;
    inset: 15px;
    background: #fff;
    border-radius: 50%;
}
.dona span {
    position: relative;
    font-size: 20px;
    font-weight: 600;
}
.presupuesto-datos { flex: 1; font-size: 14px; }
.presupuesto-datos .dato-titulo { font-weight: 500; }
.presupuesto-datos .dato-valor {
    font-size: 13px;
    color: var(--texto-suave);
    margin: 4px 0 0;
}
.presupuesto-datos hr {
    border: 0;
    border-top: 1px dashed #b5b5b5;
    margin: 10px 0;
}

/* ---------- Metas (barra) ---------- */
.metas-pista {
    position: relative;
    height: 26px;
    background: var(--gris-pista);
    border-radius: 13px;
    margin: 36px 10px 56px;
}
.metas-relleno {
    height: 100%;
    background: var(--naranja);
    border-radius: 13px;
    transition: width .6s ease;
}
.meta-hito {
    position: absolute;
    top: -11px;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.meta-hito i {
    display: block;
    width: 16px;
    height: 48px;
    background: var(--amarillo);
    border-radius: 2px;
}
.meta-hito span {
    margin-top: 6px;
    font-size: 14px;
    font-weight: 700;
}
.metas-info {
    display: flex;
    flex-wrap: wrap;
    gap: 6px 10px;
    font-size: 14px;
}
.meta-item strong { font-weight: 700; }
.meta-sep { font-weight: 700; }

/* ---------- Estadísticas ---------- */
.stat-lista { list-style: none; margin: 0; padding: 0; }
.stat-fila {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 13px 0;
    border-bottom: 1px solid var(--borde);
}
.stat-fila:last-child { border-bottom: 0; padding-bottom: 0; }
.stat-fila .etiqueta { font-size: 12px; color: var(--texto-suave); }
.stat-fila .valor { font-size: 16px; font-weight: 700; }

/* ---------- Top especialidades ---------- */
#dash-especialidades { list-style: none; margin: 0; padding: 0; }
#dash-especialidades li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px solid var(--borde);
    font-size: 12px;
    color: var(--texto-suave);
}
#dash-especialidades li:last-child { border-bottom: 0; }
#dash-especialidades .esp-ventas {
    font-weight: 700;
    color: var(--texto);
}

/* ---------- Cronograma ---------- */
.card-cronograma { margin-top: 20px; padding: 22px 0 8px; }
.card-cronograma h2 {
    font-family: 'Lilita One', sans-serif;
    font-weight: 400;
    font-size: 22px;
    color: var(--cafe);
}
.cron-encabezado {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    padding: 0 24px;
    margin-bottom: 14px;
}
.cron-encabezado h2 { padding: 0; margin: 0; }
.btn-descargar {
    display: inline-block;
    background: var(--naranja);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    padding: 9px 16px;
    border-radius: 10px;
}
.btn-descargar:hover { background: var(--naranja-oscuro); }

.cron-scroll {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
#cron-tabla {
    width: 100%;
    min-width: 680px;
    border-collapse: collapse;
    font-size: 13px;
}
#cron-tabla thead th {
    background: linear-gradient(90deg, var(--naranja), var(--naranja-oscuro));
    color: #fff;
    font-weight: 600;
    text-align: left;
    padding: 12px 16px;
    white-space: nowrap;
}
#cron-tabla thead th:first-child { padding-left: 24px; }
#cron-tabla thead th:last-child  { padding-right: 24px; }
#cron-tabla thead th.num { text-align: right; }

#cron-tabla tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid var(--borde);
    color: var(--texto);
}
#cron-tabla tbody td:first-child { padding-left: 24px; }
#cron-tabla tbody td:last-child  { padding-right: 24px; }
#cron-tabla tbody tr:nth-child(even) { background: #fafafa; }
#cron-tabla tbody tr:hover { background: #fff6e0; }
#cron-tabla tbody td.num {
    text-align: right;
    font-weight: 600;
    font-variant-numeric: tabular-nums;
}
#cron-tabla tbody td.cron-vacio {
    text-align: center;
    color: var(--texto-suave);
    padding: 28px 16px;
}
#cron-tabla tbody tr:last-child td { border-bottom: 0; }

/* ---------- Celular ---------- */
@media (max-width: 768px) {
    .dash-wrap { padding: 16px 14px 32px; }

    .dash-titulo {
        text-align: center;
        font-size: 30px;
        margin-bottom: 18px;
    }
    .dash-grid {
        grid-template-columns: 1fr;
        grid-template-areas:
            "presupuesto"
            "metas"
            "estadisticas"
            "top";
        gap: 16px;
    }
    .dash-card { padding: 18px 20px; }
    .card-cronograma { padding: 18px 0 6px; margin-top: 16px; }
    .cron-encabezado { padding: 0 20px; }
    .card-cronograma h2 { font-size: 20px; }

    /* En celular la info de metas va arriba de la barra y apilada */
    .card-metas { display: flex; flex-direction: column; }
    .card-metas h2 { display: none; }
    .metas-info { order: -1; flex-direction: column; gap: 6px; margin-bottom: 18px; }
    .meta-item strong, .meta-item span.meta-valor { display: block; }
    .meta-item { margin-bottom: 4px; }
    .meta-sep { display: none; }
    .metas-pista { margin: 20px 4px 44px; }

    .card-top h2 { font-size: 16px; font-weight: 700; }
    #dash-especialidades li { font-size: 13px; }
}
</style>

<main class="dash-wrap">
    <h1 class="dash-titulo">Dashboard de Ventas</h1>

    <div class="dash-grid">

        <!-- Presupuesto alcanzado -->
        <section class="dash-card card-presupuesto">
            <h2>Presupuesto alcanzado</h2>
            <div class="presupuesto-body">
                <div class="dona" id="dash-dona" style="--pct: <?php echo $pctPresupuesto; ?>">
                    <span id="dash-dona-pct"><?php echo $pctPresupuesto; ?>%</span>
                </div>
                <div class="presupuesto-datos">
                    <div class="dato-titulo">Dinero recaudado:</div>
                    <p class="dato-valor" id="dash-recaudado"><?php echo "$" . number_format($abonado, 2); ?></p>
                    <hr>
                    <div class="dato-titulo">Dinero esperado:</div>
                    <p class="dato-valor" id="dash-esperado"><?php echo "$" . number_format($presupuestoMeta, 2); ?></p>
                </div>
            </div>
        </section>

        <!-- Metas monetarias -->
        <section class="dash-card card-metas">
            <h2>Metas monetarias:</h2>

            <div class="metas-pista">
                <div class="metas-relleno" id="dash-meta-relleno"
                     style="width: <?php echo $pctMetas; ?>%"></div>
                <?php foreach ($metas as $meta): ?>
                    <div class="meta-hito" style="left: <?php echo ($meta / $metaMax) * 100; ?>%">
                        <i></i>
                        <span><?php echo "$" . number_format($meta, 0); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="metas-info">
                <div class="meta-item">
                    <strong>Total en tesorería:</strong>
                    <span class="meta-valor"><strong id="dash-meta-tesoreria"><?php echo "$" . number_format($abonado, 2); ?></strong></span>
                </div>
                <span class="meta-sep">-</span>
                <div class="meta-item">
                    <strong>Porcentaje de ganancia esperada:</strong>
                    <span class="meta-valor"><strong id="dash-meta-ganancia"><?php echo $pctGanancia; ?>%</strong></span>
                </div>
            </div>
        </section>

        <!-- Estadísticas -->
        <section class="dash-card card-estadisticas">
            <h2>Estadísticas</h2>
            <ul class="stat-lista">
                <li class="stat-fila">
                    <span class="etiqueta">Total en tesorería</span>
                    <span class="valor" id="dash-total-abonado"><?php echo "$" . number_format($precios['total_abonado'], 2); ?></span>
                </li>
                <li class="stat-fila">
                    <span class="etiqueta">Total en Ventas</span>
                    <span class="valor" id="dash-total-ventas"><?php echo "$" . number_format($precios['total_ventas'], 2); ?></span>
                </li>
                <li class="stat-fila">
                    <span class="etiqueta">Ventas totales</span>
                    <span class="valor" id="dash-total-numero"><?php echo $precios['total_numero']; ?></span>
                </li>
                <li class="stat-fila">
                    <span class="etiqueta">Total de ChiliDogs</span>
                    <span class="valor" id="dash-chilli-dogs"><?php echo $totalVentas['total_chilli_dogs']; ?></span>
                </li>
                <li class="stat-fila">
                    <span class="etiqueta">Total de Jugos</span>
                    <span class="valor" id="dash-jugos"><?php echo $totalVentas['total_jugos']; ?></span>
                </li>
                <li class="stat-fila">
                    <span class="etiqueta">Ventas Pendientes</span>
                    <span class="valor" id="dash-estado-pendiente"><?php echo (int) ($estados['estado_pendiente'] ?? 0); ?></span>
                </li>
                <li class="stat-fila">
                    <span class="etiqueta">Ventas Pagadas</span>
                    <span class="valor" id="dash-estado-pagado"><?php echo (int) ($estados['estado_pagado'] ?? 0); ?></span>
                </li>
                <li class="stat-fila">
                    <span class="etiqueta">Ventas Entregadas</span>
                    <span class="valor" id="dash-estado-entregada"><?php echo (int) ($estados['estado_entregada'] ?? 0); ?></span>
                </li>
            </ul>
        </section>

        <!-- Top especialidades -->
        <section class="dash-card card-top">
            <h2>Top Especialidades</h2>
            <ul id="dash-especialidades">
                <?php foreach ($especialidades as $especialidad): ?>
                    <li>
                        <span class="esp-nombre"><?php echo htmlspecialchars($especialidad['especialidad']); ?></span>
                        <span class="esp-ventas"><?php echo (int) $especialidad['total_ventas']; ?> ventas</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

    </div>

    <!-- Cronograma de secciones visitadas -->
    <section class="dash-card card-cronograma">
        <div class="cron-encabezado">
            <h2>Cronograma de secciones visitadas</h2>
            <a class="btn-descargar" href="<?= BASE_URL ?>/descargar">Descargar Excel</a>
        </div>
        <div class="cron-scroll">
            <table id="cron-tabla">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Año</th>
                        <th>Especialidad</th>
                        <th>Sección</th>
                        <th class="num">Ventas</th>
                        <th class="num">Total</th>
                        <th class="num">Abonado</th>
                    </tr>
                </thead>
                <tbody id="cron-cuerpo">
                    <tr><td colspan="7" class="cron-vacio">Cargando...</td></tr>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
const PRESUPUESTO_META = <?php echo (float) $presupuestoMeta; ?>;
const METAS_MAX        = <?php echo (float) $metaMax; ?>;

let ultimaVersionDashboard = null;
let actualizandoDashboard = false;

function formatoDinero(valor) {
    return '$' + Number(valor || 0).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function setTexto(id, valor) {
    const el = document.getElementById(id);
    if (el) el.textContent = valor;
}

function actualizarGraficas(abonado) {
    // Dona: abonado vs presupuesto
    const pctPresupuesto = PRESUPUESTO_META > 0
        ? Math.min(100, Math.round(abonado / PRESUPUESTO_META * 100)) : 0;

    const dona = document.getElementById('dash-dona');
    if (dona) dona.style.setProperty('--pct', pctPresupuesto);
    setTexto('dash-dona-pct', pctPresupuesto + '%');
    setTexto('dash-recaudado', formatoDinero(abonado));

    // Barra de metas y ganancia esperada: abonado vs meta máxima
    const pctReal = METAS_MAX > 0 ? Math.round(abonado / METAS_MAX * 100) : 0;

    const relleno = document.getElementById('dash-meta-relleno');
    if (relleno) relleno.style.width = Math.min(100, pctReal) + '%';

    setTexto('dash-meta-tesoreria', formatoDinero(abonado));
    setTexto('dash-meta-ganancia', pctReal + '%');
}

function revisarCambiosDashboard() {
    fetch('<?= BASE_URL ?>/dashboard/version')
        .then(res => res.json())
        .then(data => {
            if (ultimaVersionDashboard === null) {
                ultimaVersionDashboard = data.version;
                return;
            }
            if (data.version !== ultimaVersionDashboard) {
                ultimaVersionDashboard = data.version;
                actualizarDashboard();
            }
        })
        .catch(err => console.error('Error revisando cambios del dashboard:', err));
}

function actualizarDashboard() {
    if (actualizandoDashboard) return;
    actualizandoDashboard = true;

    fetch('<?= BASE_URL ?>/dashboard/datosAjax')
        .then(res => res.json())
        .then(d => {
            // Dinero y conteos generales
            setTexto('dash-total-abonado', formatoDinero(d.precios.total_abonado));
            setTexto('dash-total-ventas',  formatoDinero(d.precios.total_ventas));
            setTexto('dash-total-numero',  d.precios.total_numero ?? 0);

            // Gráficas de presupuesto y metas
            actualizarGraficas(Number(d.precios.total_abonado || 0));

            // Productos
            setTexto('dash-chilli-dogs', d.totales.total_chilli_dogs ?? 0);
            setTexto('dash-jugos',       d.totales.total_jugos ?? 0);

            // Estados
            setTexto('dash-estado-pendiente', d.estados.estado_pendiente ?? 0);
            setTexto('dash-estado-pagado',    d.estados.estado_pagado ?? 0);
            setTexto('dash-estado-entregada', d.estados.estado_entregada ?? 0);

            // Top especialidades (textContent evita inyección de HTML)
            const lista = document.getElementById('dash-especialidades');
            if (lista) {
                lista.innerHTML = '';
                d.especialidades.forEach(function (e) {
                    const li = document.createElement('li');

                    const nombre = document.createElement('span');
                    nombre.className = 'esp-nombre';
                    nombre.textContent = e.especialidad;

                    const ventas = document.createElement('span');
                    ventas.className = 'esp-ventas';
                    ventas.textContent = e.total_ventas + ' ventas';

                    li.appendChild(nombre);
                    li.appendChild(ventas);
                    lista.appendChild(li);
                });
            }
        })
        .catch(err => console.error('Error actualizando el dashboard:', err))
        .finally(() => { actualizandoDashboard = false; });
}

document.addEventListener('DOMContentLoaded', function () {
    revisarCambiosDashboard();
    setInterval(revisarCambiosDashboard, 3000);
});

// ---------- Cronograma ----------
function cargarCronograma() {
    fetch('<?= BASE_URL ?>/dashboard/cronograma')
        .then(res => res.json())
        .then(d => {
            const cuerpo = document.getElementById('cron-cuerpo');
            if (!cuerpo) return;
            cuerpo.innerHTML = '';

            if (!d.cronograma.length) {
                const tr = document.createElement('tr');
                const td = document.createElement('td');
                td.colSpan = 7;
                td.className = 'cron-vacio';
                td.textContent = 'Aún no hay secciones visitadas.';
                tr.appendChild(td);
                cuerpo.appendChild(tr);
                return;
            }

            d.cronograma.forEach(function (f) {
                const tr = document.createElement('tr');
                [
                    { v: f.fecha,                 num: false },
                    { v: f.anio,                  num: false },
                    { v: f.especialidad,          num: false },
                    { v: f.seccion,               num: false },
                    { v: f.ventas,                num: true  },
                    { v: formatoDinero(f.total),   num: true  },
                    { v: formatoDinero(f.abonado), num: true  }
                ].forEach(function (c) {
                    const td = document.createElement('td');
                    if (c.num) td.className = 'num';
                    td.textContent = c.v;
                    tr.appendChild(td);
                });
                cuerpo.appendChild(tr);
            });
        })
        .catch(err => console.error('Error cargando el cronograma:', err));
}

document.addEventListener('DOMContentLoaded', function () {
    cargarCronograma();
    setInterval(cargarCronograma, 5000);
});
</script>