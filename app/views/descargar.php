<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php requerirRol("admin"); ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lilita+One&display=swap" rel="stylesheet">

<style>
.desc-wrap {
    font-family: 'Inter', sans-serif;
    max-width: 600px;
    margin: 0 auto;
    padding: 30px 20px 40px;
    box-sizing: border-box;
}
.desc-titulo {
    font-family: 'Lilita One', sans-serif;
    font-weight: 400;
    font-size: 28px;
    color: #5a3000;
    margin: 0 0 20px;
}
.desc-card {
    background: #fff;
    border: 1px solid #e3e3e3;
    border-radius: 18px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
    padding: 24px;
}
.desc-card p { margin: 0 0 12px; font-size: 14px; color: #1f1f1f; }
.desc-card ul { margin: 0 0 20px; padding-left: 20px; font-size: 14px; color: #6b6b6b; }
.desc-acciones { display: flex; flex-wrap: wrap; gap: 10px; }
.btn-excel, .btn-volver {
    display: inline-block;
    padding: 11px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
}
.btn-excel { background: #f04e14; color: #fff; }
.btn-excel:hover { background: #d9441c; }
.btn-volver { background: #f0f0f0; color: #1f1f1f; }
.btn-volver:hover { background: #e3e3e3; }
</style>

<main class="desc-wrap">
    <h1 class="desc-titulo">Descargar cronograma</h1>

    <section class="desc-card">
        <p>Se descargará un archivo Excel (.xlsx) con las secciones visitadas.
           Actualmente hay <strong><?php echo (int) $totalFilas; ?></strong> registros.</p>
        <p>Columnas incluidas:</p>
        <ul>
            <li>Fecha</li>
            <li>Año</li>
            <li>Especialidad</li>
            <li>Sección</li>
        </ul>

        <div class="desc-acciones">
            <a class="btn-excel" href="<?= BASE_URL ?>/descargar/excel">Descargar Excel</a>
            <a class="btn-volver" href="<?= BASE_URL ?>/dashboard">Volver al dashboard</a>
        </div>
    </section>
</main>