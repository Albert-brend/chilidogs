<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<?php if ($id): ?>
<style>
#modalVentaExitosa .modal-dialog {
    max-width: 340px;
}

#modalVentaExitosa .modal-content {
    border: none;
    background: transparent;
}

.venta-exito-card {
    background: #fff;
    border: 2px solid #f5a83c;
    border-radius: 26px;
    padding: 36px 24px 24px;
    text-align: center;
}

.venta-exito-icon {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #f0a93a;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.venta-exito-icon svg {
    width: 34px;
    height: 34px;
    color: #fff;
}

.venta-exito-card h2 {
    font-size: 21px;
    font-weight: 700;
    margin: 0 0 8px;
    color: #1c1c1c;
}

.venta-exito-sub {
    font-size: 14px;
    color: #7a7a7a;
    margin: 0 0 26px;
}

.venta-exito-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #1c1c1c;
}

.venta-exito-estado {
    color: #c1440e;
    font-weight: 700;
}

.venta-exito-id {
    font-size: 56px;
    font-weight: 800;
    color: #1c1c1c;
    margin: 6px 0 2px;
    line-height: 1;
}

.venta-exito-caption {
    font-size: 13px;
    color: #8a8a8a;
    margin-bottom: 26px;
}

.venta-exito-btn {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 14px;
    background: #c1440e;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
}

.venta-exito-btn:active {
    background: #a83a0c;
}
</style>

<div class="modal" tabindex="-1" id="modalVentaExitosa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="venta-exito-card">
        <div class="venta-exito-icon">
          <svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h2>Venta registrada con éxito</h2>
        <p class="venta-exito-sub">Tu operación se completó correctamente.</p>
        <div class="venta-exito-row">
          <span>Ticket</span>
          <span class="venta-exito-estado">Activo</span>
        </div>
        <div class="venta-exito-id"><?= htmlspecialchars($id) ?></div>
        <div class="venta-exito-caption">Número de venta</div>
        <button type="button" class="venta-exito-btn" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = new bootstrap.Modal(document.getElementById('modalVentaExitosa'));
    modal.show();
});
</script>
<?php endif; ?>

<style>
.venta-mobile {
    max-width: 420px;
    margin: 0 auto;
    background: #f7f5f2;
    min-height: 100vh;
    padding-bottom: 32px;
    font-family: -apple-system, blinkmacsystemfont, "Segoe UI", roboto, sans-serif;
    color: #1c1c1c;
}

@media (min-width: 480px) {
    .venta-mobile {
        max-height: 100vh;
        overflow-y: auto;
        margin: 24px auto;
        border-radius: 24px;
        box-shadow: 0 0 24px rgba(0, 0, 0, 0.12);
    }
}

.venta-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    background: #fff;
    position: sticky;
    top: 0;
    z-index: 5;
}

.venta-back {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: none;
    border: none;
    cursor: pointer;
    color: #1c1c1c;
}

.venta-header h1 {
    font-size: 17px;
    font-weight: 600;
    margin: 0 32px 0 0;
    flex: 1;
    text-align: center;
}

.venta-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 16px 20px;
    padding: 10px 14px;
    background: #fdece3;
    border-radius: 10px;
    font-size: 13px;
    color: #c1440e;
}

.venta-badge svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.venta-form {
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.venta-field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #4a4a4a;
    margin-bottom: 6px;
}

.venta-optional {
    font-weight: 400;
    color: #9a9a9a;
}

.venta-field select,
.venta-field input[type=text],
.venta-field input[type=email],
.venta-field input[type=number] {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e3e0db;
    border-radius: 10px;
    font-size: 15px;
    background: #fff;
    box-sizing: border-box;
}

.venta-row {
    display: flex;
    gap: 12px;
}

.venta-row .venta-field {
    flex: 1;
}

.venta-stepper {
    display: flex;
    align-items: center;
    border: 1px solid #e3e0db;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

.venta-stepper button {
    width: 40px;
    height: 44px;
    border: none;
    background: #f2f0ec;
    font-size: 18px;
    cursor: pointer;
}

.venta-stepper input {
    flex: 1;
    border: none;
    text-align: center;
    font-size: 15px;
    padding: 0;
}

.venta-stepper input::-webkit-outer-spin-button,
.venta-stepper input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.venta-precio {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border: 1px solid #e3e0db;
    border-radius: 10px;
    background: #fbfaf8;
    font-size: 15px;
    color: #6b6b6b;
}

.venta-precio svg {
    width: 15px;
    height: 15px;
}

.venta-add-btn {
    padding: 10px;
    border: 1px dashed #c1440e;
    border-radius: 10px;
    background: #fff;
    color: #c1440e;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}

.venta-lista {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.venta-lista-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    background: #fff;
    border: 1px solid #e3e0db;
    border-radius: 10px;
    font-size: 14px;
}

.venta-quitar {
    border: none;
    background: none;
    color: #c1440e;
    font-size: 13px;
    cursor: pointer;
}

.venta-total {
    background: linear-gradient(135deg, #e2542a, #c1440e);
    border-radius: 14px;
    padding: 16px 18px;
    color: #fff;
}

.venta-total-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11px;
    letter-spacing: 0.04em;
    font-weight: 700;
    opacity: 0.9;
}

.venta-badge-count {
    background: #f7d354;
    color: #5c3d00;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
}

.venta-total-amount {
    font-size: 32px;
    font-weight: 700;
    margin-top: 6px;
}

.venta-input-icon {
    position: relative;
}

.venta-input-icon input {
    padding-right: 40px;
}

.venta-input-icon svg {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: #9a9a9a;
}

.venta-abono {
    border-color: #c1440e !important;
}

.venta-saldo {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fdf3d6;
    color: #8a6d1e;
    border: 1px solid #f0dfa0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
}

.venta-saldo svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.venta-submit {
    margin-top: 4px;
    padding: 15px;
    border: none;
    border-radius: 12px;
    background: #e2542a;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
}

.venta-submit:active {
    background: #c1440e;
}
</style>

<div class="venta-mobile">
    <div class="venta-header">
        <button type="button" class="venta-back" onclick="history.back()">
            <svg viewBox="0 0 24 24" fill="none" width="20" height="20"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <h1>Registrar Venta</h1>
    </div>

    <div class="venta-badge">
        <svg viewBox="0 0 24 24" fill="none"><path d="M20 12l-8 8-9-9V4h7l10 10a1.5 1.5 0 010 2z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="7" r="1.2" fill="currentColor"/></svg>
        Punto de Venta • Modo Caja Registradora
    </div>

    <form method="post" action="<?= BASE_URL ?>/RegistrarVenta" class="venta-form">
        <div class="venta-field">
            <label>Producto</label>
            <select name="producto" id="selectProducto" required>
                <option value="">--Seleccione un producto--</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['id_producto'] ?>" data-nombre="<?= htmlspecialchars($producto['producto']) ?>" data-precio="<?= $producto['precio'] ?>"><?= $producto['producto'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="venta-row">
            <div class="venta-field">
                <label>Cantidad</label>
                <div class="venta-stepper">
                    <button type="button" id="btnMenos">-</button>
                    <input type="number" name="cantidad" id="cantidadProducto" value="1" min="0.01" step="any" required>
                    <button type="button" id="btnMas">+</button>
                </div>
            </div>
            <div class="venta-field">
                <label>Precio unitario</label>
                <div class="venta-precio">
                    <span id="precioUnitario">$0.00</span>
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M6 10V8a6 6 0 1112 0v2M6 10h12v10H6V10z" stroke="currentColor" stroke-width="1.6"/></svg>
                </div>
            </div>
        </div>

        <button type="button" id="btnAgregarProducto" class="venta-add-btn">Agregar producto</button>

        <ul id="listaProductosSeleccionados" class="venta-lista"></ul>

        <input type="hidden" name="productos_json" id="productosJson">

        <div class="venta-total">
            <div class="venta-total-top">
                <span>MONTO TOTAL A COBRAR</span>
                <span class="venta-badge-count" id="badgeArticulos">0 Articulos</span>
            </div>
            <div class="venta-total-amount" id="montoTotal">$0.00</div>
        </div>
        <input type="hidden" name="total" id="totalInput" step="any" value="0">

        <div class="venta-field">
            <label>Nombre del cliente</label>
            <div class="venta-input-icon">
                <input type="text" name="nombre_cliente" required placeholder="Nombre completo">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20a8 8 0 0116 0" stroke="currentColor" stroke-width="1.6"/></svg>
            </div>
        </div>

        <div class="venta-field">
            <label>Especialidad</label>
            <select name="especialidad" required>
                <option value="">--Seleccione una especialidad--</option>
                <?php foreach ($especialidades as $especialidad): ?>
                    <option value="<?= $especialidad['id_especialidad'] ?>"><?= $especialidad['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="venta-row">
            <div class="venta-field">
                <label>Año</label>
                <select name="anio" required>
                    <option value="">--Seleccione un año--</option>
                    <option value="Primero">Primer Año</option>
                    <option value="Segundo">Segundo Año</option>
                    <option value="Tercero">Tercer Año</option>
                </select>
            </div>
            <div class="venta-field">
                <label>Sección</label>
                <select name="seccion" required>
                    <option value="">--Seleccione una sección--</option>
                    <option value="A">Sección A</option>
                    <option value="B">Sección B</option>
                    <option value="C">Sección C</option>
                    <option value="D">Sección D</option>
                    <option value="E">Sección E</option>
                </select>
            </div>
        </div>

        <div class="venta-field">
            <label>Correo electrónico <span class="venta-optional">(opcional)</span></label>
            <div class="venta-input-icon">
                <input type="email" name="correo" placeholder="correo@ejemplo.com">
                <svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16v12H4V6zm0 0l8 7 8-7" stroke="currentColor" stroke-width="1.6"/></svg>
            </div>
        </div>

        <div class="venta-field">
            <label>Cantidad abonada</label>
            <input type="number" name="abono" id="abonoInput" class="venta-abono" step="any" min="0" required placeholder="$0.00">
        </div>

        <div class="venta-saldo">
            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 8v5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="16" r="1" fill="currentColor"/></svg>
            <span id="saldoPendiente">Saldo pendiente a cobrar: $0.00</span>
        </div>

        <input type="text" name="estado" id="estadoInput" value="Pendiente" hidden>

        <button type="submit" class="venta-submit">Registrar Venta</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productosSeleccionados = {};

    const selectProducto = document.getElementById('selectProducto');
    const inputCantidad = document.getElementById('cantidadProducto');
    const btnAgregar = document.getElementById('btnAgregarProducto');
    const btnMenos = document.getElementById('btnMenos');
    const btnMas = document.getElementById('btnMas');
    const lista = document.getElementById('listaProductosSeleccionados');
    const inputJson = document.getElementById('productosJson');
    const precioUnitario = document.getElementById('precioUnitario');
    const montoTotal = document.getElementById('montoTotal');
    const totalInput = document.getElementById('totalInput');
    const badgeArticulos = document.getElementById('badgeArticulos');
    const abonoInput = document.getElementById('abonoInput');
    const saldoPendiente = document.getElementById('saldoPendiente');
    const selectEspecialidad = document.querySelector('select[name="especialidad"]');
    const selectAnio = document.querySelector('select[name="anio"]');
    const opcionTercero = selectAnio.querySelector('option[value="Tercero"]');

    function actualizarPrecioUnitario() {
        const opcion = selectProducto.options[selectProducto.selectedIndex];
        const precio = parseFloat(opcion?.dataset.precio) || 0;
        precioUnitario.textContent = '$' + precio.toFixed(2);
    }

    function calcularTotal() {
        return Object.values(productosSeleccionados).reduce((acc, p) => acc + p.precio * p.cantidad, 0);
    }

    function actualizarSaldo(total) {
        const abono = parseFloat(abonoInput.value) || 0;
        const saldo = Math.max(0, total - abono);
        saldoPendiente.textContent = 'Saldo pendiente a cobrar: $' + saldo.toFixed(2);
    }

    function actualizarLista() {
        lista.innerHTML = '';
        let articulos = 0;

        for (const id in productosSeleccionados) {
            const p = productosSeleccionados[id];
            articulos += p.cantidad;
            const li = document.createElement('li');
            li.className = 'venta-lista-item';
            li.innerHTML = `<span>${p.nombre} x${p.cantidad}</span><button type="button" class="venta-quitar" data-id="${id}">Quitar</button>`;
            lista.appendChild(li);
        }

        const total = calcularTotal();
        montoTotal.textContent = '$' + total.toFixed(2);
        totalInput.value = total.toFixed(2);
        badgeArticulos.textContent = articulos + (articulos === 1 ? ' Articulo' : ' Articulos');
        actualizarSaldo(total);

        inputJson.value = JSON.stringify(productosSeleccionados);
    }

    function actualizarAnioDisponible() {
        const texto = (selectEspecialidad.options[selectEspecialidad.selectedIndex]?.textContent || '').trim().toLowerCase();
        const esBachilleratoGeneral = texto === 'bachillerato general';
        opcionTercero.disabled = esBachilleratoGeneral;
        if (esBachilleratoGeneral && selectAnio.value === 'Tercero') {
            selectAnio.value = '';
        }
    }

    selectEspecialidad.addEventListener('change', actualizarAnioDisponible);
    actualizarAnioDisponible();

    selectProducto.addEventListener('change', actualizarPrecioUnitario);

    btnMenos.addEventListener('click', function () {
        const valor = (parseFloat(inputCantidad.value) || 1) - 1;
        inputCantidad.value = Math.max(0.01, valor);
    });

    btnMas.addEventListener('click', function () {
        inputCantidad.value = (parseFloat(inputCantidad.value) || 1) + 1;
    });

    btnAgregar.addEventListener('click', function () {
        const id = selectProducto.value;
        if (!id) return;

        const opcion = selectProducto.options[selectProducto.selectedIndex];
        const nombre = opcion.dataset.nombre;
        const precio = parseFloat(opcion.dataset.precio) || 0;
        const cantidad = parseFloat(inputCantidad.value) || 1;

        if (productosSeleccionados[id]) {
            productosSeleccionados[id].cantidad += cantidad;
        } else {
            productosSeleccionados[id] = { nombre, precio, cantidad };
        }

        actualizarLista();
    });

    lista.addEventListener('click', function (e) {
        if (e.target.classList.contains('venta-quitar')) {
            delete productosSeleccionados[e.target.dataset.id];
            actualizarLista();
        }
    });

    abonoInput.addEventListener('input', function () {
        actualizarSaldo(calcularTotal());
    });

    actualizarPrecioUnitario();
});
</script>