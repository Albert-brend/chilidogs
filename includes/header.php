<?php requerirLogin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChiliDog´s</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding-top: 64px;
        }

        .chilidog-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            padding: 12px 20px;
            background: linear-gradient(135deg, #e2542a, #c1440e);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .chilidog-nav a {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: #f7d354;
            color: #5c3d00;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            border-radius: 999px;
            transition: background 0.15s ease;
        }

        .chilidog-nav a:hover {
            background: #f0c93e;
            color: #5c3d00;
        }

        .chilidog-nav a.chilidog-nav-salir {
            background: transparent;
            color: #f7d354;
            border: 1px solid #f7d354;
        }

        .chilidog-nav a.chilidog-nav-salir:hover {
            background: rgba(247, 211, 84, 0.15);
        }

        .chilidog-nav-logo {
            height: 44px;
            width: auto;
            order: -1;
        }

        /* Botón hamburguesa: oculto en desktop */
        .chilidog-nav-toggle {
            display: none;
            order: -1;
            background: transparent;
            border: none;
            padding: 6px;
            cursor: pointer;
        }

        .chilidog-nav-toggle span {
            display: block;
            width: 26px;
            height: 3px;
            margin: 5px 0;
            background: #f7d354;
            border-radius: 2px;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .chilidog-nav-toggle.is-open span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .chilidog-nav-toggle.is-open span:nth-child(2) {
            opacity: 0;
        }

        .chilidog-nav-toggle.is-open span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        .chilidog-nav-links {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 480px) {
            .chilidog-nav {
                justify-content: space-between;
            }

            .chilidog-nav-toggle {
                display: block;
            }

            .chilidog-nav-logo {
                margin-left: 0;
                height: 32px;
                order: 2;
            }

            .chilidog-nav-links {
                order: 3;
                flex-direction: column;
                align-items: stretch;
                width: 100%;
                max-height: 0;
                overflow: hidden;
                opacity: 0;
                gap: 8px;
                transition: max-height 0.25s ease, opacity 0.2s ease, margin-top 0.25s ease;
                margin-top: 0;
            }

            .chilidog-nav-links.is-open {
                max-height: 300px;
                opacity: 1;
                margin-top: 10px;
            }

            .chilidog-nav-links a {
                justify-content: center;
                width: 100%;
            }

            body {
                padding-top: 64px;
            }
        }
    </style>
</head>

<body>
    <nav class="chilidog-nav">
        <button type="button" class="chilidog-nav-toggle" id="chilidogNavToggle" aria-label="Abrir menú" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <img src="<?= BASE_URL ?>/images/logo.png" alt="logo" class="chilidog-nav-logo">

        <div class="chilidog-nav-links" id="chilidogNavLinks">
            <a href="<?= BASE_URL ?>/registrarVenta">Registrar Venta</a>
            <a href="<?= BASE_URL ?>/ventas">Ventas</a>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/productos">Productos</a>
                <a href="<?= BASE_URL ?>/usuarios">Usuarios</a>
                <a href="<?= BASE_URL ?>/dashboard">Dashboard</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/logout" class="chilidog-nav-salir">Cerrar Sesión</a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var toggle = document.getElementById('chilidogNavToggle');
            var links = document.getElementById('chilidogNavLinks');
            if (!toggle || !links) return;

            toggle.addEventListener('click', function () {
                var isOpen = links.classList.toggle('is-open');
                toggle.classList.toggle('is-open', isOpen);
                toggle.setAttribute('aria-expanded', isOpen);
            });

            links.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', function () {
                    links.classList.remove('is-open');
                    toggle.classList.remove('is-open');
                    toggle.setAttribute('aria-expanded', false);
                });
            });
        })();
    </script>
</body>
</html>