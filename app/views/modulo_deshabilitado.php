<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<style>
    .aviso-contenedor {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        padding: 20px;
    }

    .aviso-tarjeta {
        max-width: 520px;
        width: 100%;
        background: #ffffff;
        border-radius: 14px;
        border-top: 6px solid #e0a800;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        padding: 40px 32px;
        text-align: center;
        animation: aviso-entrada 0.4s ease-out;
    }

    .aviso-icono {
        width: 72px;
        height: 72px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #fff3cd;
        color: #b58100;
        font-size: 38px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .aviso-tarjeta h1 {
        font-size: 1.5rem;
        color: #2b2b2b;
        margin: 0 0 14px;
    }

    .aviso-tarjeta p {
        font-size: 1rem;
        line-height: 1.6;
        color: #5c5c5c;
        margin: 0 0 28px;
    }

    .aviso-boton {
        display: inline-block;
        padding: 10px 26px;
        background: #2b2b2b;
        color: #ffffff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .aviso-boton:hover {
        background: #444444;
        transform: translateY(-1px);
    }

    @keyframes aviso-entrada {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
        .aviso-tarjeta { padding: 28px 20px; }
        .aviso-tarjeta h1 { font-size: 1.25rem; }
    }
</style>

<div class="aviso-contenedor">
    <div class="aviso-tarjeta">
        <div class="aviso-icono">!</div>

        <h1>Esta acción no está permitida por el momento</h1>

        <p>
            Se ha llegado al máximo de ventas previstas en el presupuesto.
            No se podrán registrar nuevas ventas hasta nuevo aviso.
            Los demás apartados siguen funcionando con normalidad
        </p>
    </div>
</div>