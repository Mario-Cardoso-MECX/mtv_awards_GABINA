<?php 
    echo 'Validating...';

    //Importar libreria modelo
    require_once '../../models/Tabla_usuarios.php';

    //Inciar la sesion
    session_start();

    if(isset($_GET['id']) && isset($_GET['estatus'])){
        $id = $_GET['id'];
        echo $_GET['estatus'];
        //Instancia del modelo
        $tabla_usuario = new Tabla_usuarios();

        // $tabla_usuario->updateUser($id, array('estatus_usuario' => intval($_GET['estatus'])));

        //STAMENT QUERY - UPDATE
        if($tabla_usuario->updateUser($id, array('estatus_usuario' => intval($_GET['estatus'])))){
            $_SESSION['message'] = array(
                            "type" => "success", 
                            "description" => "El estatus del usuario ha sido actualizado de manera correcta...",
                            "title" => "¡Edición Éxitosa!"
                        );
            header('Location: ../../views/panel/usuarios.php');
            exit();
        }//end if
        else{
            $_SESSION['message'] = array(
                            "type" => "warning", 
                            "description" => "Error al intentar actualizar el estatus del ususario...",
                            "title" => "¡Ocurrio Error!"
                        );
            header('Location: ../../views/panel/usuarios.php');
            exit();
        }//end else
    }//end 
     else {
        $_SESSION['message'] = array(
                                "type" => "error", 
                                "description" => "Ocurrio un error al procesar la información...",
                                "title" => "¡ERROR!"
                            );

        header('Location: ../../views/panel/usuarios.php');
        exit();
    }//end else 