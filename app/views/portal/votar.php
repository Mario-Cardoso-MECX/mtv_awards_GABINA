<?php
//reinstanciar la variable
session_start();

if (!isset($_SESSION["is_logged"]) || isset($_SESSION["is_logged"]) == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}
//debbugear un array
//print ("<pre>" . print_r($_SESSION) . "</pre>")
// Importar el archivo que contiene la clase Tabla_albumes
require_once '../../models/Tabla_albumes.php';
require_once '../../models/Tabla_artista.php';
require_once '../../models/Tabla_votaciones.php';

// Instanciar la clase
$tabla_albumes = new Tabla_albumes();
$tabla_artista = new Tabla_artista();
$tabla_votaciones = new Tabla_votaciones();


$top5Albumes = $tabla_votaciones->obtenerTop5Albumes();
$artistas = $tabla_artista->readAllArtists();


// Obtener los álbumes
$albums = $tabla_albumes->readAllAlbumsG();

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
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style-votar.css">

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
        style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb.jpg);">
        <div class="bradcumbContent">
            <h2>Vota por tu Album Favorito</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Buy Now Area Start ##### -->
    <div class="oneMusic-buy-now-area mb-100">
        <div class="container p-5">
            <div class="row">

                <!-- Single Album Area -->
                <?php
                if (empty($albums)) {
                    echo "No se encontraron álbumes.";
                }
                ?>

                <div class="row">
                    <?php foreach ($albums as $album): ?>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="single-album-area">
                                <div class="album-thumb">
                                    <img src="<?= '../../../recursos/img/albums/' . $album->imagen_album ?>" alt="">
                                </div>
                                <div class="album-info">
                                    <a href="#">
                                        <!-- Título del álbum -->
                                        <h5><?= htmlspecialchars($album->titulo_album) ?></h5>
                                    </a>
                                    <center>
                                        <p><?= htmlspecialchars("Votos: " . ($tabla_votaciones->countVotacionesByAlbum($album->id_album) ?? 0)) ?></p>                                    </center>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <form action=" ../../backend/panel/procesar_votacion.php" method="post"
                                                class="text-center">
                                                <input type="hidden" name="id_al" value="<?= $album->id_album ?>">
                                                <button type="submit" class="btn oneMusic-btn">Votar</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <form 
                                                action="../../backend/panel/procesar_votacion.php" method="post"
                                                class="text-center"
                                                >
                                                <!-- <button type="submit" class="btn oneMusic-btn">Ver Detalles</button> -->
                                                <button type="button" class="btn oneMusic-btn" data-toggle="modal" data-target="#albumDetailsModal<?= $album->id_album ?>">Ver Detalless</button>
                                                </form>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>

<!-- Modal Detalles -->
<div class="modal fade" id="albumDetailsModal<?= $album->id_album ?>" tabindex="-1" role="dialog" aria-labelledby="albumDetailsModalLabel<?= $album->id_album ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="albumDetailsModalLabel<?= $album->id_album ?>">
                    <?= htmlspecialchars($album->titulo_album ?? 'Título predeterminado') ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <img src="<?= '../../../recursos/img/casete.png' . htmlspecialchars($album->imagen_album ?? 'casete.png') ?>" class="img-fluid" alt="Portada del Álbum">
                <p><strong>Artista:</strong> <?= htmlspecialchars($album->nombre_usuario ?? 'Artista genérico') ?></p>
                <p><strong>Género:</strong> <?= htmlspecialchars($album->nombre_genero ?? 'Género desconocido') ?></p>
                <p><strong>Descripción:</strong> <?= htmlspecialchars($album->descripcion_album ?? 'Sin descripción') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


                    <?php endforeach; ?>
                </div>

            </div>

        </div>
    </div>
    <!-- ##### Buy Now Area End ##### -->

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




        <!-- jQuery -->
<script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Toastr -->
<script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>

<!-- AdminLTE -->
<script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>

<?php if (isset($_SESSION['message'])): ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?=
            mostrar_alerta_mensaje(
                $_SESSION['message']["type"],
                $_SESSION['message']["description"],
                $_SESSION['message']["title"]
            );
        ?>
    });
</script>
<?php unset($_SESSION['message']); ?>
<?php endif; ?>


</body>

</html>