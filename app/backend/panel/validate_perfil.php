<?php
// Inicia la sesión
session_start();

// Verifica si la sesión está activa
if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true) {
    // Si no hay sesión activa, redirige al inicio de sesión
    header('Location: ../../../index.php?error=Acceso denegado. Por favor, inicia sesión.');
    exit();
}

// Obtiene el rol del usuario desde la sesión
$rol = $_SESSION['rol'];

// Redirige según el rol del usuario
switch ($rol) {
    case 128: // Administrador
        header('Location: ../../views/panel/dashboard.php');
        exit();
    case 85: // Artista
        header('Location: ../../views/panel/dashboard_artista.php');
        exit();
    case 8: // Operador u otro tipo de usuario
        header('Location: ../../views/portal/miPerfil.php');
        exit();
    default:
        // Si el rol no es reconocido, destruye la sesión y redirige al inicio de sesión
        session_unset();
        session_destroy();
        header('Location: ../../../index.php?error=Rol de usuario no reconocido.');
        exit();
}
?>