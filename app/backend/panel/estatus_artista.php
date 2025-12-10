<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../models/Tabla_artista.php';

// Iniciar la sesión
session_start();

if (isset($_GET['id']) && isset($_GET['estatus'])) {
    $id = $_GET['id'];
    $estatus = intval($_GET['estatus']);
    echo $estatus;

    // Instancia del modelo
    $tabla_artista = new Tabla_artista();

    // Sentencia de actualización
    if ($tabla_artista->updateArtist($id, array('estatus_artista' => $estatus))) {
        $_SESSION['message'] = array(
            "type" => "success",
            "description" => "El estatus del artista ha sido actualizado correctamente.",
            "title" => "¡Edición Exitosa!"
        );
        header('Location: ../../views/panel/artistas.php');
        exit();
    } else {
        $_SESSION['message'] = array(
            "type" => "warning",
            "description" => "Error al intentar actualizar el estatus del artista.",
            "title" => "¡Ocurrió un Error!"
        );
        header('Location: ../../views/panel/artistas.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información.",
        "title" => "¡ERROR!"
    );

    header('Location: ../../views/panel/artistas.php');
    exit();
}
?>