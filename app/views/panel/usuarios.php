<?php
//Importar librerias
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';

//Importar Modelo
require_once '../../models/Tabla_usuarios.php';

//Reintancias la variable
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
}//end if 

//Instancia del Objeto
$tabla_usuarios = new Tabla_usuarios();
$usuarios = $tabla_usuarios->readAllUsers();

// echo print("<pre>".print_r($usuarios,true)."</pre>");
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

                <!-- Maximizar -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <!-- Cerrar Sesión -->
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
            <!-- Brand Logo -->
            <a href="../../index3.html" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="AdminLTE Logo" class="brand-image elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">MTV Awards</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
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

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?= mostrar_menu_lateral("USUARIOS") ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->


            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php
            $breadcrumb = array(
                array(
                    'tarea' => 'Usuarios',
                    'href' => '#'
                )
            );
            echo mostrar_breadcrumb('Usuarios', $breadcrumb);
            ?>
            <!-- Content Header (Page header) -->


            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <a href="./usuario_nuevo.php" class="btn btn-block btn-dark">
                            <i class="fa fa-plus-circle"></i> Agregar
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="card-title ">Lista de Usuarios</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-usuarios" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Rol</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $html = '';
                                        if (!empty($usuarios)) {
                                            $count = 0;
                                            foreach ($usuarios as $usuario) {
                                                if ($usuario->imagen_usuario != null) {
                                                    if (file_exists('../../../recursos/img/users/' . $usuario->imagen_usuario)) {
                                                        $img = '../../../recursos/img/users/' . $usuario->imagen_usuario;
                                                    }//end if
                                                    else {
                                                        $img = '../../../recursos/img/users/user.png';
                                                    }//end else
                                                }//end
                                                else {
                                                    $img = '../../../recursos/img/users/user.png';
                                                }//end else
                                                $html .= '
                                                        <tr>
                                                            <td>' . ++$count . '</td>
                                                            <td>
                                                                <img src="' . $img . '" class="img-rounded" alt="img-perfil" id="img-preview" width="10%">
                                                                ' . $usuario->nombre_usuario . ' ' . $usuario->ap_usuario . ' ' . $usuario->am_usuario . '
                                                            </td>
                                                            <td>' . $usuario->rol . '</td>';
                                                if ($usuario->estatus_usuario == 0) {
                                                    $html .= '<td><a href="../../backend/panel/estatus_user.php?id=' . $usuario->id_usuario . '&estatus=1" type="button" class="btn btn-block btn-info">Habilitar</a></td>';
                                                } else {
                                                    $html .= ' <td><a href="../../backend/panel/estatus_user.php?id=' . $usuario->id_usuario . '&estatus=0" type="button" class="btn btn-block btn-outline-success">Deshabilitar</a></td>';
                                                }
                                                $html .= '<td>
                                                                <a href="../../backend/panel/delete_user.php?id=' . $usuario->id_usuario . '" type="button" class="btn btn-block btn-xs bg-gradient-danger">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="./usuario_detalles.php?id=' . $usuario->id_usuario . '" type="button" class="btn btn-block btn-xs text-white bg-gradient-warning">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    ';
                                            }//end foreach
                                        }//end if 
                                        echo $html;
                                        ?>
                                    </tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Usuario</th>
                                        <th>Rol</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        Footer
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../../recursos/recursos_panel/js/demo.js"></script>

    <!-- Toastr -->
    <script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="../../../recursos/recursos_panel/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script
        src="../../../recursos/recursos_panel/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script
        src="../../../recursos/recursos_panel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

    <!-- JS VIEW -->
    <script src="../../../recursos/js/views/usuarios.js"></script>

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