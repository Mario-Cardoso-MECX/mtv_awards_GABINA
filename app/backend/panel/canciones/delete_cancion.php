<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../../models/Tabla_canciones.php';
require_once '../../../models/Tabla_artista.php'; // Para validar relación usuario-artista

// Iniciar la sesión
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "ID de la canción no válido.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../../views/panel/canciones.php');
    exit();
}

$id_cancion = intval($_GET['id']);

// Instancias de los modelos
$tabla_cancion = new Tabla_canciones();
$tabla_artista = new Tabla_artista();

// Validar que el usuario actual esté relacionado con la canción
$id_usuario = $_SESSION['id_usuario'];
$id_artista = $tabla_artista->getArtistaByUsuario($id_usuario)->id_artista;

if (!$id_artista) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "No se pudo verificar la relación del usuario con un artista válido.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../../views/panel/canciones.php');
    exit();
}

// Verificar que la canción exista y pertenezca al artista actual
$cancion = $tabla_cancion->readGetCancion($id_cancion, $id_artista);

if (empty($cancion)) {
    $_SESSION['message'] = array(
        "type" => "warning",
        "description" => "La canción no existe o no tienes permisos para eliminarla.",
        "title" => "¡Advertencia!"
    );
    header('Location: ../../../views/panel/canciones.php');
    exit();
}

// Verificar si la canción tiene un archivo MP3 asociado y eliminarlo
if (!empty($cancion->mp3_cancion)) {
    $mp3_path = $_SERVER['DOCUMENT_ROOT'] . "/mtv_awards/recursos/audio/" . $cancion->mp3_cancion;
    if (file_exists($mp3_path)) {
        if (!unlink($mp3_path)) {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "No se pudo eliminar el archivo MP3, pero se continuará con la eliminación de la canción.",
                "title" => "¡Advertencia!"
            );
        }
    }
}

// Intentar eliminar la canción de la base de datos
if ($tabla_cancion->deleteCancion($id_cancion)) {
    $_SESSION['message'] = array(
        "type" => "success",
        "description" => "La canción ha sido eliminada correctamente.",
        "title" => "¡Eliminación Exitosa!"
    );
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Error al intentar eliminar la canción de la base de datos.",
        "title" => "¡ERROR!"
    );
}

header('Location: ../../../views/panel/canciones.php');
exit();
?>