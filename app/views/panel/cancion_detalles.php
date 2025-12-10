<?php
// Importar librerías
require_once '../../helpers/menu_lateral_artista.php';
require_once '../../helpers/funciones_globales.php';
require_once '../../models/Tabla_canciones.php';
require_once '../../models/Tabla_albumes.php';
require_once '../../models/Tabla_generos.php';

// Iniciar la sesión
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION['message'] = array(
        "type" => "warning",
        "description" => "La canción que intentas encontrar no es válida.",
        "title" => "¡Advertencia!"
    );
    header("location: ./canciones.php");
    exit();
}

// Instanciar el modelo
$tabla_canciones = new Tabla_canciones();
$id_artista = $tabla_canciones->getIdArtistaByUsuario($_SESSION["id_usuario"]);

if (!$id_artista) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "No se pudo encontrar el artista correspondiente al usuario.",
        "title" => "¡ERROR!"
    );
    header("location: ./canciones.php");
    exit();
}

$cancion = $tabla_canciones->readGetCancion((int) $_GET["id"], $id_artista);

if (empty($cancion)) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "No tienes acceso a esta canción.",
        "title" => "¡ERROR!"
    );
    header("location: ./canciones.php");
    exit();
}

// Instanciar modelos para álbumes y géneros
$tabla_albumes = new Tabla_albumes();
$tabla_generos = new Tabla_generos();

$albumes = $tabla_albumes->readAllAlbumsG();
$generos = $tabla_generos->readAllGeneros();
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTV | awards</title>

    <!-- Icon -->
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../recursos/recursos_panel/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./dashboard_artista.php" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../backend/panel/liberate_user.php" class="nav-link">Cerrar Sesión</a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="../../index3.html" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="AdminLTE Logo" class="brand-image elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">MTV Awards</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?= mostrar_menu_lateral("CANCIONES") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Breadcrumb -->
            <?php
            $breadcrumb = array(
                array(
                    'tarea' => 'Canciones',
                    'href' => './canciones.php'
                ),
                array(
                    'tarea' => 'Detalles de la Canción',
                    'href' => '#'
                ),
            );
            echo mostrar_breadcrumb_art('Detalles de la Canción', $breadcrumb);
            ?>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Detalles de la Canción</h3>
                                </div>
                                <!-- Formulario -->
                                <form id="form-cancion" action="../../backend/panel/canciones/update_cancion.php"
                                    method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="id_cancion" value="<?= $cancion->id_acancion ?>">
                                        <input type="hidden" name="mp3_anterior" value="<?= $cancion->mp3_cancion ?>">

                                        <div class="form-group">
                                            <label for="nombre_cancion">Nombre de la Canción</label>
                                            <input type="text" name="nombre_cancion" class="form-control"
                                                id="nombre_cancion" value="<?= $cancion->nombre_cancion ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_lanzamiento_cancion">Fecha de Lanzamiento</label>
                                            <input type="date" name="fecha_lanzamiento_cancion" class="form-control"
                                                id="fecha_lanzamiento_cancion"
                                                value="<?= $cancion->fecha_lanzamiento_cancion ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="duracion_cancion">Duración (MM:SS)</label>
                                            <input type="time" name="duracion_cancion" class="form-control"
                                                id="duracion_cancion"
                                                value="<?= isset($cancion->duracion_cancion) ? $cancion->duracion_cancion : '' ?>"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="id_album">Álbum</label>
                                            <select class="form-control" name="id_album" id="id_album" required>
                                                <option value="">Seleccionar un álbum</option>
                                                <?php foreach ($albumes as $album): ?>
                                                    <option value="<?= $album->id_album ?>"
                                                        <?= $cancion->id_album == $album->id_album ? 'selected' : '' ?>>
                                                        <?= $album->titulo_album ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_genero">Género</label>
                                            <select class="form-control" name="id_genero" id="id_genero" required>
                                                <option value="">Seleccionar un género</option>
                                                <?php foreach ($generos as $genero): ?>
                                                    <option value="<?= $genero->id_genero ?>"
                                                        <?= $cancion->id_genero == $genero->id_genero ? 'selected' : '' ?>>
                                                        <?= $genero->nombre_genero ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="mp3_cancion">Archivo MP3</label>
                                            <input type="file" name="mp3_cancion" class="form-control" id="mp3_cancion">
                                            <small>Deja vacío si no deseas cambiar el archivo actual.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="url_cancion">URL de la Canción</label>
                                            <input type="text" name="url_cancion" class="form-control" id="url_cancion"
                                                value="<?= $cancion->url_cancion ?>" placeholder="URL de la Canción">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_video_cancion">URL del Video</label>
                                            <input type="text" name="url_video_cancion" class="form-control"
                                                id="url_video_cancion" value="<?= $cancion->url_video_cancion ?>"
                                                placeholder="URL del Video">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info">Actualizar</button>
                                        <a href="./canciones.php" class="btn btn-danger">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy;</strong>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>
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