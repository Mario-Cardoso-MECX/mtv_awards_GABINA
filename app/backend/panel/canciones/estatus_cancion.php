<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../../models/Tabla_canciones.php';

// Iniciar la sesión
session_start();

// Validar que los parámetros sean enviados
if (isset($_GET['id']) && isset($_GET['estatus'])) {
    $id = intval($_GET['id']);
    $estatus = intval($_GET['estatus']);

    // Validar que el estatus sea válido (0 o 1)
    if (!in_array($estatus, [0, 1])) {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Estatus no válido proporcionado.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../../views/panel/canciones.php');
        exit();
    }

    // Instancia del modelo
    $tabla_cancion = new Tabla_canciones();

    // Intentar actualizar el estatus de la canción
    try {
        // Se utiliza el campo correcto de la tabla `id_acancion`
        if ($tabla_cancion->updateCancion($id, array('estatus_cancion' => $estatus))) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El estatus de la canción ha sido actualizado de manera correcta.",
                "title" => "¡Edición Exitosa!"
            );
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "No se pudo actualizar el estatus de la canción. Verifica que exista el ID proporcionado.",
                "title" => "¡Advertencia!"
            );
        }
    } catch (Exception $e) {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Error al intentar actualizar el estatus: " . $e->getMessage(),
            "title" => "¡ERROR!"
        );
    }

    // Redirigir de vuelta a la lista de canciones
    header('Location: ../../../views/panel/canciones.php');
    exit();
} else {
    // Manejar caso en que falten parámetros
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Faltan datos requeridos para procesar la solicitud.",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/canciones.php');
    exit();
}
?>