<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../models/Tabla_artista.php';

// Iniciar la sesión
session_start();

if (isset($_GET['id'])) {
    $id_artista = $_GET['id'];

    // Instancia del modelo
    $tabla_artista = new Tabla_artista();
    $artista = $tabla_artista->readGetArtist($id_artista);

    echo print ("<pre>" . print_r($artista, true) . "</pre>");

    if (!empty($artista)) {
        // Intentar eliminar el registro
        if ($tabla_artista->deleteArtist($id_artista)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El artista ha sido eliminado correctamente.",
                "title" => "¡Eliminación Exitosa!"
            );
            header('Location: ../../views/panel/artistas.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar eliminar el artista.",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../views/panel/artistas.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "warning",
            "description" => "El artista no existe o no se pudo encontrar.",
            "title" => "¡Ocurrió un Error!"
        );
        header('Location: ../../views/panel/artistas.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la solicitud.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../views/panel/artistas.php');
    exit();
}
?>