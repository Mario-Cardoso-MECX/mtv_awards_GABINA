<?php
// Mensaje de validación
echo 'Validating...';

// Importar el modelo
require_once '../../../models/Tabla_albumes.php';
require_once '../../../models/Tabla_artista.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_album = new Tabla_albumes();
    $tabla_artista = new Tabla_artista();

    // Verificar que los datos requeridos estén presentes
    if (isset($_POST["titulo_album"], $_POST["fecha_lanzamiento_album"], $_POST["id_genero"])) {
        $titulo = $_POST["titulo_album"];
        $fecha_lanzamiento = $_POST["fecha_lanzamiento_album"];
        $descripcion = isset($_POST["descripcion_album"]) ? $_POST["descripcion_album"] : null;
        $id_artista = $tabla_artista->getArtistaByUsuario($_SESSION['id_usuario'])->id_artista; // Usar la ID del usuario autenticado como ID del artista
        $id_genero = $_POST["id_genero"];

        // Manejar la imagen del álbum
        $img = $_FILES["imagen_album"];
        $file_name = NULL;

        if (!empty($img["name"])) {
            // Validar la extensión del archivo
            $temp = explode(".", $img["name"]);
            $exten = end($temp);

            if (($exten != "jpg") && ($exten != "png")) {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "La imagen debe tener una extensión válida (jpg o png).",
                    "title" => "¡ERROR!"
                );

                header('Location: ../../../views/panel/album_nuevo.php');
                exit();
            }

            // Mover el archivo cargado
            if (move_uploaded_file($img['tmp_name'], "../../../../recursos/img/albums/" . $img['name'])) {
                $file_name = $img['name'];
            }
        }

        // Preparar los datos para el registro
        $data = array(

            "titulo_album" => $titulo,
            "fecha_lanzamiento_album" => $fecha_lanzamiento,
            "descripcion_album" => $descripcion,
            "imagen_album" => ($file_name == null) ? null : $file_name,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero
        );
        echo print ("<pre>" . print_r($data, true) . "</pre>");


        // Intentar registrar el álbum
        if ($tabla_album->createAlbum($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El álbum se ha registrado correctamente.",
                "title" => "¡Registro Exitoso!"
            );
            header('Location: ../../../views/panel/albumes.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "Ocurrió un error al registrar el álbum.",
                "title" => "¡ERROR!"
            );
            //header('Location: ../../../views/panel/album_nuevo.php');
            print_r($data);
            exit();
        }

    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Faltan datos requeridos para registrar el álbum.",
            "title" => "¡ERROR!"
        );

        header('Location: ../../../views/panel/album_nuevo.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Método no permitido.",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/album_nuevo.php');
    exit();
}
