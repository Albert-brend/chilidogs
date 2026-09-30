<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<?php requerirRol("admin"); ?>

<style>
    :root {
        --naranja-1: #e2542a;
        --naranja-2: #c1440e;
        --amarillo: #f7d354;
        --texto-oscuro: #5c3d00;
    }

    .producto-form-contenedor {
        max-width: 460px;
        margin: 30px auto 60px;
        padding: 0 20px;
    }

    .producto-form-tarjeta {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(92, 61, 0, 0.10);
        border: 1px solid #f1e6c8;
        padding: 30px 28px;
    }

    .producto-form-tarjeta h1 {
        margin: 0 0 24px;
        font-size: 24px;
        font-weight: 800;
        color: var(--texto-oscuro);
        text-align: center;
    }

    .producto-campo {
        margin-bottom: 18px;
    }

    .producto-campo label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 700;
        color: var(--texto-oscuro);
    }

    .producto-campo input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #f1e6c8;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        background: #fffdf5;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .producto-campo input:focus {
        border-color: var(--naranja-1);
        box-shadow: 0 0 0 3px rgba(226, 84, 42, 0.12);
    }

    .btn-guardar-producto {
        width: 100%;
        margin-top: 6px;
        padding: 13px;
        border: none;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--naranja-1), var(--naranja-2));
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: filter 0.15s ease;
    }

    .btn-guardar-producto:hover {
        filter: brightness(1.05);
    }
</style>

<div class="producto-form-contenedor">
    <div class="producto-form-tarjeta">
        <h1>Agregar Producto</h1>

        <form action="<?php echo BASE_URL . '/productos/guardar'; ?>" method="POST">
            <div class="producto-campo">
                <label for="producto">Nombre del Producto</label>
                <input type="text" id="producto" name="producto" required>
            </div>

            <div class="producto-campo">
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>

            <button type="submit" class="btn-guardar-producto">Guardar</button>
        </form>
    </div>
</div>