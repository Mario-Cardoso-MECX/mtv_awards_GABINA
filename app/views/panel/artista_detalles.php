<?php
// Importar librerías
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';
require_once '../../models/Tabla_artista.php';
require_once '../../models/Tabla_usuarios.php';
require_once '../../models/Tabla_generos.php';

// Reinstancia la variable
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

if (!isset($_GET["id"])) {
    $_SESSION['message'] = array(
        "type" => "warning",
        "description" => "El artista que intentas encontrar no existe en la Base de Datos...",
        "title" => "¡Advertencia!"
    );
    header("location: ./artistas.php");
    exit();
}

// Instancias de las tablas
$tabla_artista = new Tabla_artista();
$tabla_usuarios = new Tabla_usuarios();
$tabla_generos = new Tabla_generos();

// Obtener el artista por su ID
$artista = $tabla_artista->readGetArtist($_GET["id"]);

// Verificar si el artista existe
if (empty($artista)) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "El artista que intentas editar no existe en la Base de Datos...",
        "title" => "¡ERROR!"
    );
    header("location: ./artistas.php");
    exit();
}

// Obtener usuarios y géneros para los select
$usuarios = $tabla_usuarios->readAllUsersForArt(); // Usuarios disponibles
$generos = $tabla_generos->readAllGeneros(); // Todos los géneros
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
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="../../index3.html" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="Logo" class="brand-image elevation-3"
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
                        <?= mostrar_menu_lateral("ARTISTAS") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?php
            $breadcrumb = array(
                array(
                    'tarea' => 'Artistas',
                    'href' => './artistas.php'
                ),
                array(
                    'tarea' => 'Detalles del Artista',
                    'href' => '#'
                ),
            );
            echo mostrar_breadcrumb('Detalles del Artista', $breadcrumb);
            ?>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Editar Artista</h3>
                                </div>
                                <form id="form-artista" action="../../backend/panel/update_artista.php" method="post">
                                    <div class="card-body">
                                        <input type="hidden" name="id_artista" value="<?= $artista->id_artista ?>">

                                        <div class="form-group">
                                            <label for="pseudonimo">Pseudónimo</label>
                                            <input type="text" name="pseudonimo_artista" class="form-control"
                                                id="pseudonimo" value="<?= $artista->pseudonimo_artista ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="nacionalidad">Nacionalidad</label>
                                            <input type="text" name="nacionalidad_artista" class="form-control"
                                                id="nacionalidad" value="<?= $artista->nacionalidad_artista ?>"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="biografia">Biografía</label>
                                            <textarea name="biografia_artista" class="form-control" id="biografia"
                                                rows="4"><?= $artista->biografia_artista ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="usuario">Usuario</label>
                                            <select name="id_usuario" class="form-control" id="usuario" required>
                                                <option value="">Selecciona un usuario</option>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <option value="<?= $usuario->id_usuario ?>"
                                                        <?= $usuario->id_usuario == $artista->id_usuario ? 'selected' : '' ?>>
                                                        <?= $usuario->nombre_usuario . ' ' . $usuario->ap_usuario ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="genero">Género</label>
                                            <select name="id_genero" class="form-control" id="genero" required>
                                                <option value="">Selecciona un género</option>
                                                <?php foreach ($generos as $genero): ?>
                                                    <option value="<?= $genero->id_genero ?>"
                                                        <?= $genero->id_genero == $artista->id_genero ? 'selected' : '' ?>>
                                                        <?= $genero->nombre_genero ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info">Actualizar</button>
                                        <a href="./artistas.php" class="btn btn-danger">Cancelar</a>
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

    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>
</body>

</html>