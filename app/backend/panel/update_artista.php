<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../models/Tabla_artista.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_artista = new Tabla_artista();

    if (
        isset($_POST["pseudonimo_artista"]) &&
        isset($_POST["nacionalidad_artista"]) &&
        isset($_POST["id_usuario"]) &&
        isset($_POST["id_genero"])
    ) {
        $id_artista = $_POST["id_artista"];
        $pseudonimo = $_POST["pseudonimo_artista"];
        $nacionalidad = $_POST["nacionalidad_artista"];
        $biografia = !empty($_POST["biografia_artista"]) ? $_POST["biografia_artista"] : null;
        $id_usuario = $_POST["id_usuario"];
        $id_genero = $_POST["id_genero"];

        $data = array(
            "pseudonimo_artista" => $pseudonimo,
            "nacionalidad_artista" => $nacionalidad,
            "biografia_artista" => $biografia,
            "id_usuario" => $id_usuario,
            "id_genero" => $id_genero
        );

        // Sentencia de actualización
        if ($tabla_artista->updateArtist($id_artista, $data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El artista ha sido actualizado correctamente.",
                "title" => "¡Edición Exitosa!"
            );
            header('Location: ../../views/panel/artistas.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar actualizar los datos del artista.",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../views/panel/artista_detalles.php?id=' . $id_artista);
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información. Por favor, completa todos los campos requeridos.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../views/panel/artista_detalles.php?id=' . $_POST["id_artista"]);
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Método de solicitud no permitido.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../views/panel/artistas.php');
    exit();
}
?>