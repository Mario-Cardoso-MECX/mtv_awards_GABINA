<?php
session_start();

if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

require_once '../../models/Tabla_votaciones.php';
require_once '../../models/Tabla_artista.php';

// 1. Instanciar votaciones y pedir el TOP 5
$tabla_votaciones = new Tabla_votaciones();
$top5Albumes = $tabla_votaciones->obtenerTop5Albumes();

// 2. Instanciar artistas para la lista de abajo
$tabla_artista = new Tabla_artista();
$artistas = $tabla_artista->readAllArtists();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>MTV | awards</title>

    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <style>
        .rank-badge {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        /* Colores para 1, 2 y 3 lugar */
        .rank-1 { background-color: #FFD700; font-size: 1.2rem; width: 50px; height: 50px; } /* Oro */
        .rank-2 { background-color: #C0C0C0; } /* Plata */
        .rank-3 { background-color: #CD7F32; color: #fff;} /* Bronce */
    </style>
</head>

<body>
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>

    <header class="header-area">
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">

                        <a href="./index.php" class="nav-brand">
                            <img src="../../../recursos/img/system/mtv-logo-blanco.png" width="50%" alt="">
                        </a>

                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <div class="classy-menu">
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <div class="classynav">
                                <ul>
                                    <li><a href="./index.php">Inicio</a></li>
                                    <li><a href="./event.php">Eventos</a></li>
                                    <li><a href="./albums-store.php">Albums</a></li>
                                    <li><a href="./artistas.php">Artistas</a></li>
                                    <li><a href="./votar.php">Votar</a></li>
                                </ul>

                                <div class="login-register-cart-button d-flex align-items-center">
                                    <div class="login-register-btn mr-50">
                                        <?php if (isset($_SESSION["nickname"])): ?>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown">
                                                    <?= htmlspecialchars($_SESSION["nickname"]) ?>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-dark" href="../../backend/panel/validate_perfil.php">Mi perfil</a>
                                                    <a class="dropdown-item text-dark" href="../../backend/panel/liberate_user.php">Cerrar sesión</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a href="../../../login.php">Iniciar sesión / Registrarse</a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>Ranking Oficial</p>
            <h2>Top 5 Álbumes Más Votados</h2>
        </div>
    </section>

    <?php if (!empty($top5Albumes)): ?>
        <section class="best-album-area section-padding-100 bg-overlay"
            style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-2.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading white text-center">
                            <p>Favoritos del público</p>
                            <h2>Líderes de la votación </h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    
                    <?php foreach ($top5Albumes as $index => $album): ?>
                        <?php 
                            $lugar = $index + 1; 
                            // Clase dinámica para colorear las medallas
                            $claseRango = ($lugar == 1) ? 'rank-1' : (($lugar == 2) ? 'rank-2' : (($lugar == 3) ? 'rank-3' : ''));
                        ?>
                        
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-30">
                            <div class="single-album-area text-center" 
                                style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.2); position: relative; height: 100%;">

                                <div class="rank-badge <?= $claseRango ?>">
                                    #<?= $lugar ?>
                                </div>

                                <div class="album-thumb" style="margin-top: 15px; margin-bottom: 15px;">
                                    <img src="../../../recursos/img/albums/<?= htmlspecialchars($album->imagen_album) ?>" 
                                        alt="<?= htmlspecialchars($album->titulo_album) ?>"
                                        style="border-radius: 10px; width: 100%; aspect-ratio: 1/1; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.5);">
                                </div>

                                <div class="album-info">
                                    <h5 style="color: white; font-size: 1rem; margin-bottom: 5px;">
                                        <?= htmlspecialchars($album->titulo_album) ?>
                                    </h5>
                                    <small style="color: #ffc107;"><?= $album->total_votos ?> votos</small>
                                </div>

                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        </section>
    <?php else: ?>
        <section class="section-padding-100 bg-overlay" style="background-color: #222;">
            <div class="container text-center">
                <h3 class="text-white">Aún no hay votaciones registradas. ¡Sé el primero!</h3>
            </div>
        </section>
    <?php endif; ?>
    <section class="album-catagory section-padding-100-0">
        <div class="container">

            <div class="row oneMusic-albums">

                <?php if (!empty($artistas)): ?>
                    <?php foreach ($artistas as $artista): ?>
                        <div class="col-12 col-sm-4 col-md-3 col-lg-2 single-album-item">
                            <div class="single-album">
                                <img src="../../../recursos/recursos_portal/img/users/<?= $artista->imagen_usuario ?>" alt="">
                                <div class="album-info">
                                    <h5><?= $artista->pseudonimo_artista ?></h5>
                                    <p><?= $artista->nombre_genero ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white">No hay artistas disponibles por el momento.</p>
                <?php endif; ?>

            </div>

        </div>
    </section>

    <footer class="footer-area">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                    <a href="./dashboard.php">
                        <img src="../../../recursos/img/system/mtv-logo-blanco.png" width="15%" alt="">
                    </a>
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

    <script src="../../../recursos/recursos_portal/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/bootstrap/popper.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <script src="../../../recursos/recursos_portal/js/active.js"></script>

</body>
</html>