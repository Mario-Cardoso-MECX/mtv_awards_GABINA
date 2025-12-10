<?php
// Reinstanciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

// Incluir la clase con la función `getArtistAlbumDetails`
require_once '../../models/Tabla_artista.php';

// Instanciar la clase
$tabla_artista = new Tabla_artista();

// Verificar si se ha recibido `id_album` a través de GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_album = $_GET['id'];

    // Llamar al método para obtener los detalles del álbum y artista
    $artistas = $tabla_artista->getArtistAlbumDetails($id_album);

    // Verificar si se obtuvieron detalles para el álbum
    if ($artistas === null || empty($artistas)) {
        die("No se encontraron detalles para este álbum.");
    }
} else {
    die("ID del álbum no proporcionado.");
}
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
    <title>MTV | Awards</title>

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

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>See what’s new</p>
            <h2>Events</h2>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <!-- Mostrar los detalles del álbum -->
                        <?php foreach ($artistas as $album): ?>
                            <img src="../../../recursos/img/albums/<?= htmlspecialchars($album->imagen_album) ?>"
                                 class="card-img-top" alt="Imagen del álbum">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($album->titulo_album) ?></h5>
                                <p class="card-text"><strong>Artista:</strong> <?= htmlspecialchars($album->pseudonimo_artista) ?></p>
                                <p class="card-text"><strong>Género:</strong> <?= htmlspecialchars($album->genero_artista) ?></p>
                                <p class="card-text"><strong>Fecha de lanzamiento:</strong>
                                    <?= htmlspecialchars($album->fecha_lanzamiento_album) ?></p>
                                <p class="card-text"><strong>Descripción:</strong>
                                    <?= htmlspecialchars($album->descripcion_album) ?></p>
                                <a href="#" class="btn btn-primary">Ver más detalles</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Events Area Start ##### -->
    <section class="events-area section-padding-100">
        <div class="container">
            <div class="row">
                <!-- Sección para otros contenidos o eventos si es necesario -->
            </div>
        </div>
    </section>
    <!-- ##### Events Area End ##### -->

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
