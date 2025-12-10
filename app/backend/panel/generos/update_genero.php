<?php
echo 'Validating...';

//Importar libreria modelo
require_once '../../../models/Tabla_generos.php';

//Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Instancia del modelo
    $tabla_genero = new Tabla_generos();

    if (isset($_POST["nombre_genero"])) {
        $id_genero = $_POST["id_genero"];
        $nombre_genero = $_POST["nombre_genero"];

        $data = array(
            "nombre_genero" => $nombre_genero,
        );

        //STAMENT QUERY - UPDATE
        if ($tabla_genero->updateGenero($id_genero, $data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El género ha sido actualizado de manera correcta...",
                "title" => "¡Edición Exitosa!"
            );
            header('Location: ../../../views/panel/generos.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar actualizar el género...",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../../views/panel/genero_detalles.php?id=' . $id_genero);
            exit();
        }//end else
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../../views/panel/genero_detalles.php?id=' . $id_genero);
        exit();
    }//end else
}//end REQUEST_METHOD
else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/genero_detalles.php');
    exit();
}//end else
