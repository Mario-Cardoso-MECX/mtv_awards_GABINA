<?php
//Importar Modelo
require_once '../../models/Tabla_usuarios.php';
require_once '../../models/Tabla_artista.php';
require_once '../../models/Tabla_albumes.php';
require_once '../../helpers/funciones_globales.php';


//instanciar modelo artista
$tabla_artista = new Tabla_artista();
$artistas = $tabla_artista->readAllArtists();
$interpretes = $tabla_artista->getAllAlbumDetails();

//instanciar modelo albumes
$tabla_album = new Tabla_albumes();
$albums = $tabla_album->readAllAlbumsG();
//Reintancias la variable
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
}//end if 

//Instancia del Objeto
$tabla_usuarios = new Tabla_usuarios();
$usuarios = $tabla_usuarios->readAllUsers();
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
                                                        href="./miPerfil.php?id=<?php echo $_SESSION['id_usuario']; ?>">Mi
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

    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img"
                    style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-1.jpg);"></div>
                <!-- Slide Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">Participa ahora</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms">Vota por tu álbum favorito <span>¡Haz
                                        tu elección!</span>
                                </h2>
                                <a data-animation="fadeInUp" data-delay="500ms" href="./votar.php"
                                    class="btn oneMusic-btn mt-50">Vota por tu artista <i
                                        class="fa fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img"
                    style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-2.jpg);"></div>
                <!-- Slide Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">Descubre al mejor</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms">El artista más escuchado<span>¡No te lo
                                        pierdas!</span></h2>
                                <a data-animation="fadeInUp" data-delay="500ms" href="./artistas.php"
                                    class="btn oneMusic-btn mt-50">Ver artistas <i
                                        class="fa fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Latest Albums Area Start ##### -->
    <section class="latest-albums-area section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading style-2">
                        <p>Descubre la música</p>
                        <h2>Artistas y sus géneros</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <div class="ablums-text text-center mb-70">
                        <p>Explora nuestra amplia colección de artistas, desde las icónicas leyendas del rock hasta las
                            voces emergentes del pop y el indie. Cada género tiene una historia única que contar, y
                            nuestros artistas lo llevan a otro nivel. Encuentra tus favoritos o descubre nuevos sonidos
                            que te inspiren. ¡Sumérgete en un viaje musical sin igual!</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="albums-slideshow owl-carousel">

                        <!-- Single Album -->
                        <?php foreach ($artistas as $artista): ?>
                            <div class="single-album">
                                <img src="../../img/bg-img/a7.jpg" alt="">
                                <div class="album-info">
                                    <a href="#">
                                        <h5><?= $artista->pseudonimo_artista ?></h5>
                                    </a>
                                    <p><?= $artista->nombre_genero ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Latest Albums Area End ##### -->

    <!-- ##### Buy Now Area Start ##### -->
    <section class="oneMusic-buy-now-area has-fluid bg-gray section-padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading style-2">
                        <p>Explora lo mejor</p>
                        <h2>Álbumes destacados</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <div class="albums-text text-center mb-70">
                        <p>Descubre los álbumes que están marcando tendencia. Desde las producciones más votadas por la
                            comunidad hasta los lanzamientos que redefinen los géneros musicales, cada álbum cuenta una
                            historia única. Explora tus favoritos o déjate sorprender por nuevos ritmos y sonidos. ¡La
                            música está esperando por ti!</p>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Single Album Area -->
                <?php foreach ($albums as $album): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="single-album-area wow fadeInUp" data-wow-delay="300ms">
                            <div class="album-thumb">
                                <img src="../../img/bg-img/b3.jpg" alt="">
                            </div>
                            <div class="album-info">
                                <a href="#">
                                    <h5><?= $album->titulo_album ?></h5>
                                </a>
                                <!-- <p> $album->fecha_lanzamiento_album</p>-->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="load-more-btn text-center wow fadeInUp" data-wow-delay="300ms">
                        <a href="./albums-store.php" class="btn oneMusic-btn">Ver Albums <i
                                class="fa fa-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Buy Now Area End ##### -->


    <!-- ##### Miscellaneous Area Start ##### -->
    <section class="miscellaneous-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <?php
                $contador = 0;
                foreach ($interpretes as $interprete):
                    if ($contador >= 4)
                        break; // Detener después de los primeros 2 álbumes
                    $contador++;
                    ?>
                    <div class="col-12 col-lg-4">
                        <div class="new-hits-area mb-100">
                            <!-- Album Details -->
                            <div class="section-heading text-left mb-50 wow fadeInUp" data-wow-delay="50ms">
                                <p><?= htmlspecialchars($interprete['Artista']) ?></p>
                                <h2><?= htmlspecialchars($interprete['Album']) ?></h2>
                            </div>

                            <!-- Songs List -->
                            <?php foreach ($interprete['Canciones'] as $cancion): ?>
                                <div class="single-new-item d-flex align-items-center justify-content-between wow fadeInUp"
                                    data-wow-delay="250ms">
                                    <div class="first-part d-flex align-items-center">
                                        <div class="thumbnail">
                                            <img src="../../../recursos/img/musica.png" alt="img">
                                        </div>
                                        <div class="content-">
                                            <h6><?= htmlspecialchars($cancion['nombre_cancion']) ?></h6>
                                            <p><?= htmlspecialchars($interprete['Album']) ?></p>
                                        </div>
                                    </div>
                                    <audio preload="auto" controls>
                                        <source src="<?= '../../../recursos/audio/' . $cancion['mp3_cancion'] ?>">
                                    </audio>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- ##### Miscellaneous Area End ##### -->

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