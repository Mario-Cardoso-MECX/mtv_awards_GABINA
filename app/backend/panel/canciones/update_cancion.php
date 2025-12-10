<?php
echo 'Validating...';

// Importar librerías
require_once '../../../models/Tabla_canciones.php';
require_once '../../../models/Tabla_artista.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia de los modelos
    $tabla_cancion = new Tabla_canciones();
    $tabla_artista = new Tabla_artista();

    // Obtener el id_artista relacionado con el usuario actual
    $id_usuario = $_SESSION['id_usuario'];
    $artista = $tabla_artista->getArtistaByUsuario($id_usuario);

    if (!$artista || empty($artista->id_artista)) {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "El usuario no está vinculado a un artista válido.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../../views/panel/canciones.php');
        exit();
    }

    $id_artista = $artista->id_artista;

    // Validar los campos requeridos
    if (isset($_POST["id_cancion"], $_POST["nombre_cancion"], $_POST["duracion_cancion"], $_POST["id_genero"], $_POST["id_album"])) {
        $id_cancion = $_POST["id_cancion"];
        $nombre_cancion = $_POST["nombre_cancion"];
        $fecha_lanzamiento = !empty($_POST["fecha_lanzamiento_cancion"]) ? $_POST["fecha_lanzamiento_cancion"] : null;
        $duracion_cancion = $_POST["duracion_cancion"];
        $id_genero = $_POST["id_genero"];
        $id_album = $_POST["id_album"];

        // Manejar el archivo MP3
        $mp3 = $_FILES["mp3_cancion"];
        $file_name = null;

        //Ruta del anterior archivo mp3.
        $oldMp3 = $_SERVER['DOCUMENT_ROOT'] . "/mtv_awards/recursos/audio/" . $_POST["mp3_anterior"];


        if (!empty($mp3["name"])) {
            $temp = explode(".", $mp3["name"]);
            $exten = strtolower(end($temp));

            if ($exten !== "mp3") {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "El archivo debe tener una extensión válida (mp3).",
                    "title" => "¡ERROR!"
                );
                header('Location: ../../../views/panel/cancion_detalles.php?id=' . $id_cancion);
                exit();
            }

            // Eliminar la cancion anterior si existe
            if (!empty($_POST['mp3_anterior']) && file_exists($oldMp3)) {
                unlink($oldMp3);
            }

            //Mueve la nueva cancion a la ruta
            if (move_uploaded_file($mp3['tmp_name'], "../../../../recursos/audio/" . $mp3['name'])) {
                $file_name = $mp3['name'];
            } else {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "Error al guardar el archivo MP3.",
                    "title" => "¡ERROR!"
                );
                header('Location: ../../../views/panel/cancion_detalles.php?id=' . $id_cancion);
                exit();
            }
        }

        // Procesar URL opcionales
        $url_cancion = !empty($_POST["url_cancion"]) ? $_POST["url_cancion"] : null;
        $url_video_cancion = !empty($_POST["url_video_cancion"]) ? $_POST["url_video_cancion"] : null;

        // Preparar los datos
        $data = array(
            "nombre_cancion" => $nombre_cancion,
            "fecha_lanzamiento_cancion" => $fecha_lanzamiento,
            "duracion_cancion" => $duracion_cancion,
            "mp3_cancion" => $file_name, // Si no se seleccionó archivo, será null
            "url_cancion" => $url_cancion,
            "url_video_cancion" => $url_video_cancion,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero,
            "id_album" => $id_album,
        );

        // Filtrar campos vacíos para evitar sobreescritura con valores NULL no deseados
        $data = array_filter($data, fn($value) => $value !== null);

        // Intentar actualizar la canción
        if ($tabla_cancion->updateCancion($id_cancion, $data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "La canción ha sido actualizada correctamente.",
                "title" => "¡Actualización Exitosa!"
            );
            header('Location: ../../../views/panel/canciones.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "Ocurrió un error al intentar actualizar la canción.",
                "title" => "¡ERROR!"
            );
            header('Location: ../../../views/panel/cancion_detalles.php?id=' . $id_cancion);
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Faltan datos requeridos para actualizar la canción.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../../views/panel/cancion_detalles.php?id=' . $_POST["id_cancion"]);
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Método no permitido.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../../views/panel/canciones.php');
    exit();
}
?>