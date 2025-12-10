<?php
// Importar librerías
require_once '../../helpers/menu_lateral_artista.php';
require_once '../../helpers/funciones_globales.php';
require_once '../../models/Tabla_albumes.php';
require_once '../../models/Tabla_generos.php';

// Reinstancias la variable
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

if (!isset($_GET["id"])) {
    $_SESSION['message'] = array(
        "type" => "warning",
        "description" => "El álbum que intentas encontrar no existe en la Base de Datos.",
        "title" => "¡Advertencia!"
    );
    header("location: ./albumes.php");
    exit();
}

// Instanciar el modelo
$tabla_album = new Tabla_albumes();
$album = $tabla_album->readGetAlbum($_GET["id"]);

if (empty($album)) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "El álbum que intentas editar no existe en la Base de Datos.",
        "title" => "¡ERROR!"
    );
    header("location: ./albumes.php");
    exit();
}

// Obtener los géneros
$tabla_generos = new Tabla_generos();
$generos = $tabla_generos->readAllGeneros();
?>

<!DOCTYPE html>
<html lang="en">

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
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="./dashboard.php" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="../../backend/panel/liberate_user.php" class="nav-link">Cerrar Sesión</a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">

                    <!-- Maximizar -->
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <!-- Cerrar Sesión -->
                    <li class="nav-item">
                        <a class="nav-link" href="../../backend/panel/liberate_user.php" role="button"
                            data-toggle="tooltip" data-placement="top" title="Cerrar Sesión">
                            <i class="fa fa-window-close"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="../../index3.html" class="brand-link">
                    <img src="../../../recursos/img/system/mtv-logo.jpg" alt="AdminLTE Logo"
                        class="brand-image elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">MTV Awards</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>"
                                class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a>
                        </div>
                    </div>

                    <!-- SidebarSearch Form -->
                    <div class="form-inline">
                        <div class="input-group" data-widget="sidebar-search">
                            <input class="form-control form-control-sidebar" type="search"
                                placeholder="¿Qué deseas buscar?" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <?= mostrar_menu_lateral("ALBUMES") ?>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>


            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Content Header -->
                <?php
                $breadcrumb = array(
                    array(
                        'tarea' => 'Álbumes',
                        'href' => './albumes.php'
                    ),
                    array(
                        'tarea' => 'Detalles del Álbum',
                        'href' => '#'
                    ),
                );
                echo mostrar_breadcrumb_art('Detalles del Álbum', $breadcrumb);
                ?>
                <!-- Content Header -->

                <!-- Main Content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Detalles del Álbum</h3>
                                    </div>
                                    <!-- Formulario -->
                                    <form id="form-album" action="../../backend/panel/albumes/update_album.php"
                                        method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <img src="../../../recursos/img/albums/<?= ($album->imagen_album == '') ? 'default.png' : $album->imagen_album; ?>"
                                                        class="img-rounded" alt="" id="img-preview" width="20%">
                                                </div>
                                            </div>
                                            <input type="hidden" name="id_album" value="<?= $album->id_album ?>">
                                            <input type="hidden" name="imagen_anterior"
                                                value="<?= $album->imagen_album ?>">

                                            <div class="form-group">
                                                <label for="titulo_album">Título del Álbum</label>
                                                <input type="text" name="titulo_album" class="form-control"
                                                    id="titulo_album" value="<?= $album->titulo_album ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_lanzamiento_album">Fecha de Lanzamiento</label>
                                                <input type="date" name="fecha_lanzamiento_album" class="form-control"
                                                    id="fecha_lanzamiento_album"
                                                    value="<?= $album->fecha_lanzamiento_album ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_genero">Género</label>
                                                <select class="form-control" name="id_genero" id="id_genero" required>
                                                    <option value="">Seleccionar un género</option>
                                                    <?php foreach ($generos as $genero): ?>
                                                        <option value="<?= $genero->id_genero ?>"
                                                            <?= $album->id_genero == $genero->id_genero ? 'selected' : '' ?>>
                                                            <?= $genero->nombre_genero ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion_album">Descripción</label>
                                                <textarea name="descripcion_album" class="form-control"
                                                    id="descripcion_album"
                                                    rows="3"><?= $album->descripcion_album ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="imagen_album">Imagen del Álbum</label>
                                                <input type="file" name="imagen_album" class="form-control"
                                                    id="imagen_album">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info">Actualizar</button>
                                            <a href="./albumes.php" class="btn btn-danger">Cancelar</a>
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
                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
                reserved.
            </footer>
        </div>

        <!-- Scripts -->
        <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
        <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
        <script src="../../../recursos/recursos_panel/js/demo.js"></script>
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