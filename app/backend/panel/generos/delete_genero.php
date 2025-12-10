<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../../models/Tabla_generos.php';

// Iniciar la sesión
session_start();

if (isset($_GET['id'])) {
    $id_genero = $_GET['id'];
    // Instancia del modelo
    $tabla_generos = new Tabla_generos();
    $genero = $tabla_generos->readGetGenero($id_genero);

    echo print ("<pre>" . print_r($genero, true) . "</pre>");
    if (!empty($genero)) {
        if ($tabla_generos->deleteGenero($id_genero)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El género ha sido eliminado de manera correcta.",
                "title" => "¡Eliminación Exitosa!"
            );
            header('Location: ../../../views/panel/generos.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar eliminar el género.",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../../views/panel/generos.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "warning",
            "description" => "El género no existe o no pudo ser encontrado.",
            "title" => "¡Error!"
        );
        header('Location: ../../../views/panel/generos.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../../views/panel/generos.php');
    exit();
}
?>