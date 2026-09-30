<?php
function iniciarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        $rutaSesiones = __DIR__ . '/../sessions';

        if (!is_dir($rutaSesiones)) {
            mkdir($rutaSesiones, 0700, true);
        }

        session_save_path($rutaSesiones);
        session_start();
    }
}

function requerirLogin() {
    iniciarSesion();
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: " . BASE_URL . "/login");
        exit();
    }
}

function requerirRol(string $rolPermitido) {
    requerirLogin();
    if ($_SESSION['rol'] !== $rolPermitido) {
        http_response_code(403);
        echo "No tienes permiso para acceder a esta sección.";
        exit();
    }
}