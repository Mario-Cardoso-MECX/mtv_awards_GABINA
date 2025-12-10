<?php
//Importar Modelo
require_once '../../models/Tabla_usuarios.php';
require_once '../../helpers/funciones_globales.php';

//reinstanciar la variable
session_start();

if (!isset($_SESSION["is_logged"]) || isset($_SESSION["is_logged"]) == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
}
//debbugear un array
//print ("<pre>" . print_r($_SESSION) . "</pre>")


if (!isset($_GET["id"])) {
    print_r("No se envio ninguna id");
    header("location: ./index.php");
    exit();
}//end 

//Instanciar el modelo
$tabla_usuario = new Tabla_usuarios();
$usuario = $tabla_usuario->readGetUser($_GET["id"]);
// echo print("<pre>".print_r($usuario,true)."</pre>");

if (empty($usuario)) {
    print_r("No se encontro ningun usuario con esa id");
    header("location: ./index.php");
    exit();
}//end if 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>MTV | awards</title>

    <!-- Favicon -->
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Navbar Area -->
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">

                        <!-- Nav brand -->
                        <a href="./index.php" class="nav-brand"><img
                                src="../../../recursos/img/system/mtv-logo-blanco.png" width="50%" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="./index.php">Inicio</a></li>
                                    <li><a href="./event.php">Eventos</a></li>
                                    <li><a href="./albums-store.php">Albums</a></li>
                                    <li><a href="./artistas.php">Artistas</a></li>
                                    <li><a href="./votar.php">Votar</a></li>
                                </ul>

                                <!-- Login/Register & Cart Button -->
                                <div class="login-register-cart-button d-flex align-items-center">
                                    <!-- Login/Register -->
                                    <div class="login-register-btn mr-50">
                                        <?php if (isset($_SESSION["nickname"])): ?>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <?= htmlspecialchars($_SESSION["nickname"]) ?>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                                    <a class="dropdown-item text-dark"
                                                        href="../../backend/panel/validate_perfil.php">Mi
                                                        perfil</a>
                                                    <a class="dropdown-item text-dark"
                                                        href="../../backend/panel/liberate_user.php">Cerrar sesión</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a href="../../../login.php">Iniciar sesión / Registrarse</a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Cart Button -->
                                </div>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>Edita tu informacion</p>
            <h2>Mi Perfil</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->
    <section>
        <!-- form start -->
        <form id="form-usuario" action="../../backend/panel/update_op.php" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <img src="../../../recursos/img/users/<?= ($usuario->imagen_usuario == '') ? 'user.png' : $usuario->imagen_usuario; ?>"
                                class="img-rounded" alt="" id="img-preview" width="20%">
                        </center>
                    </div>
                </div>
                <input type="hidden" name="id_usuario" class="form-control" id="id_usuario" placeholder="Nombre(s)"
                    value="<?= $usuario->id_usuario ?>">

                <input type="hidden" name="perfil_aterior" class="form-control" id="perfil_aterior"
                    placeholder="Nombre(s)"
                    value="<?= ($usuario->imagen_usuario != NULL) ? $usuario->imagen_usuario : '' ?>">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre(s)</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre(s)"
                                value="<?= $usuario->nombre_usuario ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" class="form-control" id="apellido_paterno"
                                placeholder="Apelldio Paterno" value="<?= $usuario->ap_usuario ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Apellido Materno</label>
                            <input type="text" name="apellido_materno" class="form-control" id="apellido_materno"
                                placeholder="Apelldio Paterno" value="<?= $usuario->am_usuario ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sexo</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexo" value="1"
                                    <?= $usuario->sexo_usuario == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label">Femenino</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexo" value="0"
                                    <?= $usuario->sexo_usuario == 0 ? 'checked' : '' ?>>
                                <label class="form-check-label">Masculino</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Correo electrónico</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Correo electrónico" value="<?= $usuario->correo_usuario ?>">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Contraseña</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="***********">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Repetir Contraseña</label>
                            <input type="password" name="repassword" class="form-control" id="repassword"
                                placeholder="***********">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1">Foto perfil</label>
                        <input type="file" name="foto_perfil"
                            onchange="previsualizar_imagen('previsualizar_imagen','foto-input')" class="form-control"
                            id="foto-input">
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Actualizar</button>
                <a href="./index.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </section>

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                    <a href="./dashboard.php"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="15%"
                            alt=""></a>
                </div>

                <div class="col-12 col-md-6">
                    <div class="footer-nav">
                        <ul>
                            <li><a href="./index.php">Inicio</a></li>
                            <li><a href="./event.php">Eventos</a></li>
                            <li><a href="./albums-store.php">Albums</a></li>
                            <li><a href="./artistas.php">Artistas</a></li>
                            <li><a href="./votar.php">Votar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->

    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="../../../recursos/recursos_portal/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="../../../recursos/recursos_portal/js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="../../../recursos/recursos_portal/js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="../../../recursos/recursos_portal/js/active.js"></script>
    <!-- Mensaje Notificación -->
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            <?php
            if (isset($_SESSION['message'])) {
                echo mostrar_alerta_mensaje($_SESSION['message']["type"], $_SESSION['message']["description"], $_SESSION['message']["title"]);
                unset($_SESSION['message']);
            }
            ?>
        });
    </script>
</body>

</html>