<?php
    //Inciar la sesion
    session_start();

    //Desasignar los valores de la variable de sesion
    session_unset();

    //Destruir la variable de sesion
    session_destroy();

    //Redireccionar al login
    header('location: ../../../index.php');