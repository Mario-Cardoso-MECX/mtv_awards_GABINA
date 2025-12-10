<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../../models/Tabla_albumes.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_album = new Tabla_albumes();

    if (
        isset($_POST["titulo_album"], $_POST["fecha_lanzamiento_album"], $_POST["id_genero"]) &&
        isset($_POST["id_album"])
    ) {
        $id_album = $_POST["id_album"];
        $titulo = $_POST["titulo_album"];
        $descripcion = $_POST["descripcion_album"] ?? null;
        $fecha_lanzamiento = $_POST["fecha_lanzamiento_album"];
        $id_genero = $_POST["id_genero"];

        //Prepara la ruta de la imagen anterior:
        $oldImg = $_SERVER['DOCUMENT_ROOT'] . "/mtv_awards/recursos/img/albums/" . $_POST["imagen_anterior"];

        // Preparar datos para la actualización
        $data = array(
            "titulo_album" => $titulo,
            "descripcion_album" => $descripcion,
            "fecha_lanzamiento_album" => $fecha_lanzamiento,
            "id_genero" => $id_genero,
            "imagen_album" => null,
        );

        // Manejo de la imagen
        $img = $_FILES["imagen_album"];
        $file_name = null;

        //Verifica que exista una imagen que actualizar
        if (!empty($img["name"])) {
            // Validar la extensión
            $temp = explode(".", $img["name"]);
            $exten = strtolower(end($temp));

            if (!in_array($exten, ["jpg", "png"])) {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "La imagen no corresponde a las extensiones permitidas (jpg o png).",
                    "title" => "¡ERROR!"
                );

                header('Location: ../../../views/panel/album_detalles.php?id=' . $id_album);
                exit();
            }

            // Eliminar la imagen anterior si existe
            if (!empty($_POST['imagen_anterior']) && file_exists($oldImg)) {
                unlink($oldImg);
            }

            // Guardar la nueva imagen y asigna su ruta al update
            if (move_uploaded_file($img['tmp_name'], "../../../../recursos/img/albums/" . $img['name'])) {
                $file_name = $img['name'];
                $data["imagen_album"] = $file_name;

            } else {
                $_SESSION['message'] = array(
                    "type" => "warning",
                    "description" => "La imagen no pudo ser actualizada, intentelo más tarde.",
                    "title" => "¡ERROR!"
                );

                header('Location: ../../../views/panel/album_detalles.php?id=' . $id_album);
                exit();
            }
        }

        // Ejecutar la actualización
        if ($tabla_album->updateAlbum($id_album, $data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El álbum ha sido actualizado de manera correcta.",
                "title" => "¡Edición Exitosa!"
            );
            header('Location: ../../../views/panel/albumes.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar actualizar el álbum.",
                "title" => "¡ERROR!"
            );
            header('Location: ../../../views/panel/album_detalles.php?id=' . $id_album);
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Faltan datos para actualizar el álbum.",
            "title" => "¡ERROR!"
        );

        header('Location: ../../../views/panel/album_detalles.php?id=' . $id_album);
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Método no permitido.",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/albumes.php');
    exit();
}
