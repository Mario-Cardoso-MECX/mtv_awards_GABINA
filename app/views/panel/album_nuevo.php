<?php
// Importar librerías
require_once '../../helpers/menu_lateral_artista.php';
require_once '../../helpers/funciones_globales.php';
require_once '../../models/Tabla_generos.php';

// Reinstancias la variable
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit;
}

// Instanciar el modelo de géneros
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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php
                $breadcrumb = array(
                    array(
                        'tarea' => 'Álbumes',
                        'href' => './albumes.php'
                    ),
                    array(
                        'tarea' => 'Álbum Nuevo',
                        'href' => '#'
                    ),
                );
                echo mostrar_breadcrumb_art('Álbum Nuevo', $breadcrumb);
                ?>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Formulario de Álbum Nuevo</h3>
                                    </div>
                                    <!-- form start -->
                                    <form id="form-album" action="../../backend/panel/albumes/create_album.php"
                                        method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="titulo_album">Título del Álbum</label>
                                                        <input type="text" name="titulo_album" class="form-control"
                                                            id="titulo_album" placeholder="Título del Álbum" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="fecha_lanzamiento">Fecha de Lanzamiento</label>
                                                        <input type="date" name="fecha_lanzamiento_album"
                                                            class="form-control" id="fecha_lanzamiento" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="id_genero">Género</label>
                                                        <select class="form-control" name="id_genero" id="id_genero"
                                                            required>
                                                            <option value="">Seleccionar un género</option>
                                                            <?php foreach ($generos as $genero): ?>
                                                                <option value="<?= $genero->id_genero ?>">
                                                                    <?= $genero->nombre_genero ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion_album">Descripción</label>
                                                <textarea name="descripcion_album" class="form-control"
                                                    id="descripcion_album" rows="3"
                                                    placeholder="Descripción del Álbum"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="imagen_album">Imagen del Álbum</label>
                                                <input type="file" name="imagen_album" class="form-control"
                                                    id="imagen_album">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info">Registrar</button>
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