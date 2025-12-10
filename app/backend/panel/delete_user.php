<?php 
    echo 'Validating...';

    //Importar libreria modelo
    require_once '../../models/Tabla_usuarios.php';

    //Inciar la sesion
    session_start();

    if(isset($_GET['id'])){
        $id_usuario = $_GET['id'];
        //Instancia de mi Modelo
        $tabla_usuario = new Tabla_usuarios();
        $user = $tabla_usuario->readGetUser($id_usuario);
        echo print("<pre>".print_r($user, true)."</pre>");
        if(!empty($user)){
            if($user->imagen_usuario != null){
                if(file_exists('../../../recursos/img/users/'.$user->imagen_usuario)){
                    if(unlink('../../../recursos/img/users/'.$user->imagen_usuario)){
                        if($tabla_usuario->deleteUser($_GET['id'])){
                            $_SESSION['message'] = array(
                                            "type" => "success", 
                                            "description" => "El usuario ha sido eliminado de manera correcta...",
                                            "title" => "¡Edición Éxitosa!"
                                        );
                            header('Location: ../../views/panel/usuarios.php');
                            exit();
                        }//end 
                        else{
                            $_SESSION['message'] = array(
                                            "type" => "warning", 
                                            "description" => "Error al intentar eliminar el ususario...",
                                            "title" => "¡Ocurrio Error!"
                                        );
                            header('Location: ../../views/panel/usuarios.php');
                            exit();
                        }//end else
                    }//end if unlik
                    else{
                        $_SESSION['message'] = array(
                                        "type" => "warning", 
                                        "description" => "Error al intentar eliminar el ususario...",
                                        "title" => "¡Ocurrio Error!"
                                    );
                        header('Location: ../../views/panel/usuarios.php');
                        exit();
                    }//end else
                }//end if file_exists
                else{
                    if($tabla_usuario->deleteUser($_GET['id'])){
                        $_SESSION['message'] = array(
                                        "type" => "success", 
                                        "description" => "El usuario ha sido eliminado de manera correcta...",
                                        "title" => "¡Edición Éxitosa!"
                                    );
                        header('Location: ../../views/panel/usuarios.php');
                        exit();
                    }//end 
                    else{
                        $_SESSION['message'] = array(
                                        "type" => "warning", 
                                        "description" => "Error al intentar eliminar el ususario...",
                                        "title" => "¡Ocurrio Error!"
                                    );
                        header('Location: ../../views/panel/usuarios.php');
                        exit();
                    }//end else
                }//end else
            }//end if 
            else{
                if($tabla_usuario->deleteUser($_GET['id'])){
                    $_SESSION['message'] = array(
                                    "type" => "success", 
                                    "description" => "El usuario ha sido eliminado de manera correcta...",
                                    "title" => "¡Edición Éxitosa!"
                                );
                    header('Location: ../../views/panel/usuarios.php');
                    exit();
                }//end 
                else{
                    $_SESSION['message'] = array(
                                    "type" => "warning", 
                                    "description" => "Error al intentar eliminar el ususario...",
                                    "title" => "¡Ocurrio Error!"
                                );
                    header('Location: ../../views/panel/usuarios.php');
                    exit();
                }//end else
            }
        }//end if
        else{
            $_SESSION['message'] = array(
                                "type" => "warning", 
                                "description" => "Error al intentar eliminar el ususario...",
                                "title" => "¡Ocurrio Error!"
                            );
                header('Location: ../../views/panel/usuarios.php');
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