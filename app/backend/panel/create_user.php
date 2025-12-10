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
        isset($_POST["sexo"]) && isset($_POST["rol"]) && isset($_POST["password"])
    ) {
        $name = $_POST["nombre"];
        $ap = $_POST["apellido_paterno"];
        $am = $_POST["apellido_materno"];
        $sexo = $_POST["sexo"];
        $email = $_POST["email"];
        $pass = $_POST["password"];
        $repass = $_POST["repassword"];
        $rol = $_POST["rol"];

        if ($pass != $repass) {
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "Las contraseñas no coinciden",
                "title" => "¡ERROR!"
            );

            header('Location: ../../views/panel/usuario_nuevo.php?id=' . $id_usuario);
            exit();
        }

        if (empty($rol)) {
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "Rol invalido",
                "title" => "¡ERROR!"
            );

            header('Location: ../../views/panel/usuario_nuevo.php?id=' . $id_usuario);
            exit();
        }

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

                header('Location: ../../views/panel/usuarios.php');
                exit();
            }//end 

            if (move_uploaded_file($img['tmp_name'], "../../../recursos/img/users/" . $img['name'])) {
                $file_name = $img['name'];
            }//end move_uploaded_file

        }//end if

        $data = array(
            // "field" => "value",
            "nombre_usuario" => $name,
            "ap_usuario" => $ap,
            "am_usuario" => $am,
            "sexo_usuario" => $sexo,
            "correo_usuario" => $email,
            "password_usuario" => $pass,
            "imagen_usuario" => ($file_name == null) ? null : $file_name,
            "id_rol" => $rol,
        );

        echo print ("<pre>" . print_r($data, true) . "</pre>");

        //STAMENT QUERY - INSERT
        if ($tabla_usuario->createUser($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El usuario ha sido registrado de manera correcta...",
                "title" => "¡Registro Éxitoso!"
            );
            header('Location: ../../views/panel/usuarios.php');
            exit();
        }//end if
        else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar registrar al ususario...",
                "title" => "¡Ocurrio Error!"
            );
            header('Location: ../../views/panel/usuario_nuevo.php');
            exit();
        }//end else
    }//end if 
    else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrio un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../views/panel/usuarios.php');
        exit();
    }//end else
}//end REQUEST_METHOD
else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrio un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../views/panel/usuario_nuevo.php');
    exit();
}//end else 