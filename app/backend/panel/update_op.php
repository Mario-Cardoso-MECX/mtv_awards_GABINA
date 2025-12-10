<?php
echo 'Validating...';

//Importar libreria modelo
require_once '../../models/Tabla_usuarios.php';

//Inciar la sesion
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Instancia del modelo
    $tabla_usuario = new Tabla_usuarios();

    if (
        isset($_POST["nombre"]) && isset($_POST["apellido_paterno"]) && isset($_POST["apellido_materno"]) &&
        isset($_POST["sexo"])

    ) {
        $id_usuario = $_POST["id_usuario"];
        $name = $_POST["nombre"];
        $ap = $_POST["apellido_paterno"];
        $am = $_POST["apellido_materno"];
        $sexo = $_POST["sexo"];
        $email = $_POST["email"];
        $pass = (empty($_POST["password"])) ? null : $_POST["password"];
        $repass = (empty($_POST["repassword"])) ? null : $_POST["repassword"];
        $rol = 8;

        if ($pass != $repass) {
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "Las contraseñas no coinciden",
                "title" => "¡ERROR!"
            );

            header('Location: ../../views/portal/miPerfil.php?id=' . $id_usuario);
            exit();
        }

        $data = array(
            // "field" => "value",
            "nombre_usuario" => $name,
            "ap_usuario" => $ap,
            "am_usuario" => $am,
            "sexo_usuario" => $sexo,
            "correo_usuario" => $email,
            "id_rol" => $rol,
        );

        if ($pass != null) {
            $data['password_usuario'] = $pass;
        }//end

        //Declarate a vairiable to FILE
        $img = $_FILES["foto_perfil"];
        $file_name = NULL;

        if (!empty($img["name"])) {
            //Validate the extention
            $temp = explode(".", $img["name"]);
            $exten = end($temp);

            if (($exten != "jpg") && ($exten != "png")) {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "La imagen que desea capturar no corresponde a la extensión establecida (jpg o png)...",
                    "title" => "¡ERROR!"
                );

                header('Location: ../../views/portal/miPerfil.php?id=' . $id_usuario);
                exit();
            }//end 

            $oldImg = $_SERVER['DOCUMENT_ROOT'] . "/mtv_awards/recursos/img/users/" . $_POST["perfil_aterior"];

            if ($_POST['perfil_aterior'] != null) {
                if (file_exists("../../../recursos/img/users/" . $_POST["perfil_aterior"])) {
                    unlink($oldImg);
                    if (move_uploaded_file($img['tmp_name'], "../../../recursos/img/users/" . $img['name'])) {
                        $file_name = $img['name'];
                        $data['imagen_usuario'] = $file_name;
                    }//end if
                    else {
                        $_SESSION['message'] = array(
                            "type" => "warning",
                            "description" => "La foto de perfil no fué actualizada, intentelo más tarde...",
                            "title" => "¡ERROR!"
                        );
                        header('Location: ../../views/portal/miPerfil.php?id=' . $id_usuario);
                        exit();
                    }//end else
                }//end if file_exists
                else {
                    $_SESSION['message'] = array(
                        "type" => "warning",
                        "description" => "La foto de perfil no fué actualizada, intentelo más tarde...",
                        "title" => "¡ERROR!"
                    );

                    header('Location: ../../views/portal/miPerfil.php?id=' . $id_usuario);
                    exit();
                }//end else
            }//end if
            else {
                if (move_uploaded_file($img['tmp_name'], "../../../recursos/img/users/" . $img['name'])) {
                    $file_name = $img['name'];
                    $data['imagen_usuario'] = $file_name;
                }//end move_uploaded_file
            }//end else
        }//end if

        //STAMENT QUERY - UPDATE
        if ($tabla_usuario->updateUser($id_usuario, $data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El usuario ha sido actualizado de manera correcta...",
                "title" => "¡Edición Éxitosa!"
            );
            header('Location: ../../views/portal/index.php');
            exit();
        }//end if
        else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar actualizar al ususario...",
                "title" => "¡Ocurrio Error!"
            );
            header('Location: ../../views/portal/miPerfil.php?id=' . $id_usuario);
            exit();
        }//end else
    }//end if 
    else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrio un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../views/portal/miPerfil.php?id=' . $id_usuario);
        exit();
    }//end else
}//end REQUEST_METHOD
else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrio un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../views/portal/miPerfil.php?id=' . $id_usuario);
    exit();
}//end else 