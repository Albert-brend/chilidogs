<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<?php requerirRol("admin"); ?>

<style>
    :root {
        --naranja-1: #e2542a;
        --naranja-2: #c1440e;
        --amarillo: #f7d354;
        --texto-oscuro: #5c3d00;
    }

    .usuario-form-contenedor {
        max-width: 460px;
        margin: 30px auto 60px;
        padding: 0 20px;
    }

    .usuario-form-tarjeta {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(92, 61, 0, 0.10);
        border: 1px solid #f1e6c8;
        padding: 30px 28px;
    }

    .usuario-form-tarjeta h1 {
        margin: 0 0 24px;
        font-size: 24px;
        font-weight: 800;
        color: var(--texto-oscuro);
        text-align: center;
    }

    .usuario-campo {
        margin-bottom: 18px;
    }

    .usuario-campo label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 700;
        color: var(--texto-oscuro);
    }

    .usuario-campo input,
    .usuario-campo select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #f1e6c8;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        background: #fffdf5;
        box-sizing: border-box;
        font-family: inherit;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        appearance: none;
        -webkit-appearance: none;
    }

    .usuario-campo select {
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%235c3d00' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 16px;
        padding-right: 40px;
        cursor: pointer;
    }

    .usuario-campo input:focus,
    .usuario-campo select:focus {
        border-color: var(--naranja-1);
        box-shadow: 0 0 0 3px rgba(226, 84, 42, 0.12);
    }

    .btn-guardar-usuario {
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

    .btn-guardar-usuario:hover {
        filter: brightness(1.05);
    }
</style>

<div class="usuario-form-contenedor">
    <div class="usuario-form-tarjeta">
        <h1>Agregar Usuario</h1>

        <form action="<?php echo BASE_URL . '/usuarios/guardar'; ?>" method="POST">
            <div class="usuario-campo">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>

            <div class="usuario-campo">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>

            <div class="usuario-campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="usuario-campo">
                <label for="rol">Rol</label>
                <select id="rol" name="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>

            <button type="submit" class="btn-guardar-usuario">Guardar</button>
        </form>
    </div>
</div>