<?php
// Reinstanciar sesión
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

require_once '../../models/Tabla_albumes.php';

// Verificar si el ID del álbum fue enviado
if (!isset($_GET["id_al"]) || empty($_GET["id_al"])) {
    echo "ID del álbum no proporcionado.";
    exit();
}

$id_al = $_GET["id_al"];
$tabla_albumes = new Tabla_albumes();

// Obtener los detalles del álbum
$album = $tabla_albumes->readGetAlbum($id_al);

if (empty($album)) {
    echo "El álbum no existe.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Álbum</title>
    <!-- Incluir Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
</head>

<body>
    <header>
        <h1 class="text-center my-4">Detalles del Álbum</h1>
    </header>
    <main class="container">
        <!-- Botón para abrir el modal -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#albumDetailsModal">
            Ver Detalles
        </button>

        <!-- Modal -->
        <div class="modal fade" id="albumDetailsModal" tabindex="-1" role="dialog" aria-labelledby="albumDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="albumDetailsModalLabel"><?= htmlspecialchars($album->titulo_album) ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Mostrar la imagen del álbum -->
                        <img src="<?= '../../../recursos/img/albums/' . htmlspecialchars($album->imagen_album) ?>" class="img-fluid" alt="Portada del Álbum">
                        
                        <!-- Mostrar los detalles del álbum -->
                        <p><strong>Artista:</strong> <?= htmlspecialchars($album->nombre_usuario) ?></p>
                        <p><strong>Género:</strong> <?= htmlspecialchars($album->nombre_genero) ?></p>
                        <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($album->descripcion_album)) ?></p>
                    </div>
                    <div class="modal-footer">
                        <a href="votar.php" class="btn btn-secondary">Volver a la lista</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Incluir los scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Usar la versión completa de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Abrir automáticamente el modal cuando se carga la página
        $(document).ready(function() {
            $('#albumDetailsModal').modal('show');
        });
    </script>
</body>
</html>
