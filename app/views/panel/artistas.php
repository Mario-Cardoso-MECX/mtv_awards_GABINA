<?php
// Importar librerías
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';

// Importar Modelo
require_once '../../models/Tabla_artista.php';

// Reinstancia la variable
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
} //end if 

// Instancia del Objeto
$tabla_artista = new Tabla_artista();
$artistas = $tabla_artista->readAllArtists();

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

    <!-- DataTables -->
    <link rel="stylesheet"
        href="../../../recursos/recursos_panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="../../../recursos/recursos_panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="../../../recursos/recursos_panel/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./dashboard.php" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../backend/panel/liberate_user.php" class="nav-link">Cerrar Sesión</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/event.php" class="nav-link">Eventos</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/albums-store.php" class="nav-link">Generos</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/artistas.php" class="nav-link">Artistas</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/votar.php" class="nav-link">Votar</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../backend/panel/liberate_user.php" role="button" data-toggle="tooltip"
                        data-placement="top" title="Cerrar Sesión">
                        <i class="fa fa-window-close"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

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

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="¿Qué deseas buscar?"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?= mostrar_menu_lateral("ARTISTAS") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <?php
            $breadcrumb = array(
                array(
                    'tarea' => 'Artistas',
                    'href' => '#'
                )
            );
            echo mostrar_breadcrumb('Artistas', $breadcrumb);
            ?>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <a href="./artista_nuevo.php" class="btn btn-block btn-dark">
                            <i class="fa fa-plus-circle"></i> Agregar
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="card-title ">Lista de Artistas</h3>
                            </div>
                            <div class="card-body">
                                <table id="table-artistas" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pseudónimo</th>
                                            <th>Género</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $html = '';
                                        if (!empty($artistas)) {
                                            $count = 0;
                                            foreach ($artistas as $artista) {
                                                $html .= '
                                                        <tr>
                                                            <td>' . ++$count . '</td>
                                                            <td>' . $artista->pseudonimo_artista . '</td>
                                                            <td>' . $artista->nombre_genero . '</td>';
                                                if ($artista->estatus_artista == 0) {
                                                    $html .= '<td><a href="../../backend/panel/estatus_artista.php?id=' . $artista->id_artista . '&estatus=1" type="button" class="btn btn-block btn-info">Habilitar</a></td>';
                                                } else {
                                                    $html .= '<td><a href="../../backend/panel/estatus_artista.php?id=' . $artista->id_artista . '&estatus=0" type="button" class="btn btn-block btn-outline-success">Deshabilitar</a></td>';
                                                }
                                                $html .= '<td>
                                                                <a href="../../backend/panel/delete_artista.php?id=' . $artista->id_artista . '" type="button" class="btn btn-block btn-xs bg-gradient-danger">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="./artista_detalles.php?id=' . $artista->id_artista . '" type="button" class="btn btn-block btn-xs text-white bg-gradient-warning">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    ';
                                            }
                                        }
                                        echo $html;
                                        ?>
                                    </tbody>
                                </table>
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

    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
    <script src="../../../recursos/recursos_panel/js/demo.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script
        src="../../../recursos/recursos_panel/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script
        src="../../../recursos/recursos_panel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>


        
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