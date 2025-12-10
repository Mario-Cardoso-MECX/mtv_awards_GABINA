<?php
echo 'Validating...';

//Importar librería modelo
require_once '../../../models/Tabla_albumes.php';

//Iniciar la sesión
session_start();

if (isset($_GET['id']) && isset($_GET['estatus'])) {
    $id = $_GET['id'];
    echo $_GET['estatus'];
    //Instancia del modelo
    $tabla_album = new Tabla_albumes();

    // Actualización del estatus del álbum
    if ($tabla_album->updateAlbum($id, array('estatus_album' => intval($_GET['estatus'])))) {
        $_SESSION['message'] = array(
            "type" => "success",
            "description" => "El estatus del álbum ha sido actualizado de manera correcta...",
            "title" => "¡Edición Exitosa!"
        );
        header('Location: ../../../views/panel/albumes.php');
        exit();
    } else {
        $_SESSION['message'] = array(
            "type" => "warning",
            "description" => "Error al intentar actualizar el estatus del álbum...",
            "title" => "¡Ocurrió un Error!"
        );
        header('Location: ../../../views/panel/albumes.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../views/panel/albumes.php');
    exit();
}
