<?php
// Iniciar la sesión
session_start();

// Mensajes de validación
$message = '';
$type = '';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Verificar si el id_album está presente en la solicitud y es un valor válido
    if (isset($_GET['id_album']) && !empty($_GET['id_album']) && is_numeric($_GET['id_album'])) {
        $id_album = (int) $_GET['id_album'];

        header("Location: ../../views/portal/detalles-artista.php");
        exit();
    } else {
        // Si el id_album no es válido, redirigir con un mensaje de error
        $type = 'warning';
        $message = 'El ID del álbum es inválido o no se ha proporcionado.';
        header('Location: ../../../index.php?error=' . $message . '&type=' . $type);
        exit();
    }
} else {
    // Método de solicitud no válido
    $type = 'warning';
    $message = 'Error al procesar los datos...';
    header('Location: ../../../index.php?error=' . $message . '&type=' . $type);
    exit();
}
?>
