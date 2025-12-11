<?php
require_once '../../models/Tabla_usuarios.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {

        $tabla_usuario = new Tabla_usuarios();

        $email = $_POST["email"];
        $pass  = $_POST["password"];

        // Validar usuario contra la base de datos
        $data = $tabla_usuario->validateUser($email, $pass);

        // Si hay datos y el usuario está activo (estatus 1)
        if ($data && intval($data->estatus_usuario) == 1) {

            // ===============================
            //  CREAR SESIÓN
            // ===============================
            $_SESSION["is_logged"] = true;
            $_SESSION["id_usuario"] = $data->id_usuario;
            $_SESSION["rol"] = $data->id_rol;
            $_SESSION["name"] = $data->nombre_usuario;
            $_SESSION["email"] = $data->correo_usuario;
            $_SESSION["nickname"] = $data->nombre_usuario;

            // Imagen por defecto si no tiene una
            $_SESSION["img"] = (empty($data->imagen_usuario))
                ? (($data->sexo_usuario == 0) ? 'woman.png' : 'man.png')
                : $data->imagen_usuario;

            // ===============================
            //  REDIRECCIÓN SEGÚN ROL (IDS 1, 2, 3, 4)
            // ===============================
            switch (intval($data->id_rol)) {

                case 1: // ADMINISTRADOR
                    header('Location: ../../views/panel/dashboard.php');
                    exit();

                case 2: // ARTISTA
                    header('Location: ../../views/panel/dashboard_artista.php');
                    exit();

                case 3:  // OPERADOR
                case 4:  // AUDIENCIA
                    header('Location: ../../views/portal/index.php');
                    exit();

                default:
                    // Rol desconocido
                    session_unset();
                    session_destroy();
                    header('Location: ../../../index.php?error=Rol no permitido&type=warning');
                    exit();
            }

        } else {
            header('Location: ../../../index.php?error=Correo o contraseña incorrectos&type=danger');
            exit();
        }

    } else {
        header('Location: ../../../index.php?error=Credenciales requeridas&type=warning');
        exit();
    }

} else {
    header('Location: ../../../index.php?error=Petición inválida&type=warning');
    exit();
}
?>