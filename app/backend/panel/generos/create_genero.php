<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../../models/Tabla_generos.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_generos = new Tabla_generos();

    if (isset($_POST["nombre_genero"]) && !empty(trim($_POST["nombre_genero"]))) {
        $nombre_genero = trim($_POST["nombre_genero"]);

        // Preparar los datos
        $data = array(
            "nombre_genero" => $nombre_genero,
        );

        // Consulta para insertar
        if ($tabla_generos->createGenero($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El género ha sido registrado correctamente.",
                "title" => "¡Registro Exitoso!"
            );
            header('Location: ../../../views/panel/generos.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar registrar el género.",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../../views/panel/genero_nuevo.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "El campo 'nombre del género' es obligatorio.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../../views/panel/genero_nuevo.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la solicitud.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../../views/panel/genero_nuevo.php');
    exit();
}
?>
