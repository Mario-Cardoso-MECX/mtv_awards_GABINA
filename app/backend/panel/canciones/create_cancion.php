<?php
echo 'Validating...';

// Importar librerías
require_once '../../../models/Tabla_canciones.php';
require_once '../../../models/Tabla_artista.php'; // Para manejar la relación usuarios-artistas

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia de modelos
    $tabla_cancion = new Tabla_canciones();
    $tabla_artista = new Tabla_artista();

    // Obtener id_artista relacionado con el usuario actual
    $id_usuario = $_SESSION['id_usuario'];
    $artista = $tabla_artista->getArtistaByUsuario($id_usuario);

    if (!$artista || empty($artista->id_artista)) {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "El usuario no está vinculado a un artista válido.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../../views/panel/cancion_nueva.php');
        exit();
    }

    $id_artista = $artista->id_artista;

    // Validar los campos del formulario
    if (isset($_POST["nombre_cancion"], $_POST["duracion_cancion"], $_POST["id_genero"], $_POST["id_album"])) {
        //Verifica que minimo exista un archivo mp3 o un url
        if (!empty($_POST["mp3_cancion"]) || !empty($_POST["url_cancion"])) {
            $nombre_cancion = $_POST["nombre_cancion"];
            $fecha_lanzamiento = !empty($_POST["fecha_lanzamiento_cancion"]) ? $_POST["fecha_lanzamiento_cancion"] : null;
            $duracion_cancion = $_POST["duracion_cancion"];
            $id_genero = $_POST["id_genero"];
            $id_album = $_POST["id_album"];

            // Manejar el archivo MP3
            $mp3 = $_FILES["mp3_cancion"];
            $file_name = null; // Por defecto, será null si no se selecciona un archivo

            if (!empty($mp3["name"])) {
                // Validar la extensión del archivo
                $temp = explode(".", $mp3["name"]);
                $exten = strtolower(end($temp));

                if ($exten !== "mp3") {
                    $_SESSION['message'] = array(
                        "type" => "error",
                        "description" => "El archivo debe tener una extensión válida (mp3).",
                        "title" => "¡ERROR!"
                    );
                    header('Location: ../../../views/panel/cancion_nueva.php');
                    exit();
                }

                // Mover el archivo cargado
                if (move_uploaded_file($mp3['tmp_name'], "../../../../recursos/audio/" . $mp3['name'])) {
                    $file_name = $mp3['name'];
                } else {
                    print_r($mp3);
                    $_SESSION['message'] = array(
                        "type" => "error",
                        "description" => "Error al guardar el archivo MP3.",
                        "title" => "¡ERROR!"
                    );
                    header('Location: ../../../views/panel/cancion_nueva.php');
                    exit();
                }
            }

            // Manejar las URL opcionales
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

            // Intentar registrar la canción
            if ($tabla_cancion->createCancion($data)) {
                $_SESSION['message'] = array(
                    "type" => "success",
                    "description" => "La canción ha sido registrada correctamente.",
                    "title" => "¡Registro Exitoso!"
                );
                header('Location: ../../../views/panel/canciones.php');
                exit();
            } else {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "Ocurrió un error al registrar la canción.",
                    "title" => "¡ERROR!"
                );
                header('Location: ../../../views/panel/cancion_nueva.php');
                exit();
            }
        } else {
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "Faltan datos requeridos para registrar la canción.",
                "title" => "¡ERROR!"
            );
            header('Location: ../../../views/panel/cancion_nueva.php');
            exit();
        }


    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Faltan datos requeridos para registrar la canción.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../../views/panel/cancion_nueva.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Método no permitido.",
        "title" => "¡ERROR!"
    );
    header('Location: ../../../views/panel/cancion_nueva.php');
    exit();
}
?>