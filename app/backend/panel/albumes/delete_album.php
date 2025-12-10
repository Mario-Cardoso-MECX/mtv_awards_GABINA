<?php
// Importar librería modelo
require_once '../../../models/Tabla_albumes.php';

// Iniciar la sesión
session_start();

if (isset($_GET['id'])) {
    $id_album = $_GET['id'];

    // Instancia del modelo
    $tabla_album = new Tabla_albumes();
    $album = $tabla_album->readGetAlbum($id_album);

    if (!empty($album)) {

        // Verificar si el álbum tiene una imagen asociada
        if ($album->imagen_album != null) {

            //Asignacion y verificacion de la ruta de la imagen
            $image_path = $_SERVER['DOCUMENT_ROOT'] . "/mtv_awards/recursos/img/albums/" . $album->imagen_album;
            echo "Ruta relativa: $image_path<br>";

            // Verificar si la imagen existe
            if (file_exists($image_path)) {
                print_r('la ruta si exista');
                // Intentar eliminar la imagen
                if (unlink($image_path) && $tabla_album->deleteAlbum($id_album)) {
                    $_SESSION['message'] = array(
                        "type" => "success",
                        "description" => "El álbum ha sido eliminado de manera correcta.",
                        "title" => "¡Eliminación Exitosa!"
                    );
                } else {
                    $_SESSION['message'] = array(
                        "type" => "warning",
                        "description" => "Error al eliminar el album",
                        "title" => "¡Advertencia!"
                    );
                }
            } else {
                print_r('la ruta no existe');
                $_SESSION['message'] = array(
                    "type" => "warning",
                    "description" => "La imagen asociada no se encontró en el servidor, pero se procederá a eliminar el álbum de la base de datos.",
                    "title" => "¡Advertencia!"
                );
                $tabla_album->deleteAlbum($id_album);
            }

        } else {
            // Si no tiene imagen, solo intentar eliminar el álbum
            if ($tabla_album->deleteAlbum($id_album)) {
                $_SESSION['message'] = array(
                    "type" => "success",
                    "description" => "El álbum ha sido eliminado de manera correcta.",
                    "title" => "¡Eliminación Exitosa!"
                );
            } else {
                $_SESSION['message'] = array(
                    "type" => "warning",
                    "description" => "Error al intentar eliminar el álbum de la base de datos.",
                    "title" => "¡Ocurrió Error!"
                );
            }
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "warning",
            "description" => "El álbum no existe en la base de datos.",
            "title" => "¡Ocurrió Error!"
        );
    }

    //Redirigir a la lista de álbumes
    header('Location: ../../../views/panel/albumes.php');
    exit();
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "No se proporcionó un ID válido para eliminar el álbum.",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/albumes.php');
    exit();
}
