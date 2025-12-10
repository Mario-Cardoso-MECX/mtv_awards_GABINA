<?php
echo 'Validating...';

// Corregir la ruta al modelo
require_once '../../../models/Tabla_generos.php';

// Iniciar la sesión
session_start();

if (isset($_GET['id']) && isset($_GET['estatus'])) {
    $id = $_GET['id'];
    $estatus = $_GET['estatus'];

    // Instancia del modelo
    $tabla_genero = new Tabla_generos();

    // Actualizar estatus del género
    if ($tabla_genero->updateGenero($id, array('estatus_genero' => intval($estatus)))) {
        $_SESSION['message'] = array(
            "type" => "success",
            "description" => "El estatus del género ha sido actualizado de manera correcta...",
            "title" => "¡Edición Exitosa!"
        );
        header('Location: ../../../views/panel/generos.php');
        exit();
    } else {
        $_SESSION['message'] = array(
            "type" => "warning",
            "description" => "Error al intentar actualizar el estatus del género...",
            "title" => "¡Ocurrió un Error!"
        );
        header('Location: ../../../views/panel/generos.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/generos.php');
}
?>