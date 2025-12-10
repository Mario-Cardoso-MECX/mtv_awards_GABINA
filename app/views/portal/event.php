<?php
//reinstanciar la variable
session_start();

if (!isset($_SESSION["is_logged"]) || isset($_SESSION["is_logged"]) == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
}
//debbugear un array
//print ("<pre>" . print_r($_SESSION) . "</pre>")
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
            <p>Proximos Eventos</p>
            <h2>Eventos</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

<section class="events-area section-padding-100">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e1.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>Noche de DJ</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Sala VIP</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e2.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>La Misión</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Arena Dorada</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e3.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>Planeta Ibiza</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Space Ibiza</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e4.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>Noche de DJ</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Sala VIP</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
+                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e5.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>La Misión</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Arena Dorada</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e6.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>Planeta Ibiza</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Space Ibiza</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e7.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>Noche de DJ</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Sala VIP</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e8.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>La Misión</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Arena Dorada</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/e9.jpg" alt="">
                        </div>
                        <div class="event-text">
                            <h4>Planeta Ibiza</h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place">Space Ibiza</a>
                                <a href="#" class="event-date">15 de Junio, 2026</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <section class="newsletter-testimonials-area">
        <div class="container">
            <div class="row">


            </div>
        </div>
    </section>
    <section class="contact-area section-padding-100 bg-img bg-overlay bg-fixed has-bg-img"
        style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-2.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading white">
                        <p>Vea las novedades</p>
                    </div>
                </div>
            </div>

            
        </div>
    </section>
    ```

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
</body>

</html>