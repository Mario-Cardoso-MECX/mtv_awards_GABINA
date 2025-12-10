<?php
// Activar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Verificar login
if (!isset($_SESSION["is_logged"]) || !$_SESSION["is_logged"]) {
    $_SESSION['message'] = [
        "type" => "error",
        "description" => "Debes iniciar sesión para votar",
        "title" => "¡ERROR!"
    ];
    header('Location: ../../views/portal/votar.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_al"])) {
    require_once '../../models/Tabla_votaciones.php';
    require_once '../../models/Tabla_albumes.php';
    
    $tabla_votacion = new Tabla_votaciones();
    $tabla_albumes = new Tabla_albumes();
    
    $album = $tabla_albumes->readGetAlbum($_POST["id_al"]);
    
    if (empty($album)) {
        $_SESSION['message'] = [
            "type" => "error",
            "description" => "No se encontró el álbum seleccionado",
            "title" => "¡ERROR!"
        ];
        header('Location: ../../views/portal/votar.php');
        exit();
    }
    
    // Verificar si el usuario ya votó por este álbum
    $votaciones_usuario = $tabla_votacion->readAllVotaciones($_SESSION["id_usuario"]);
    $ya_voto = false;
    
    foreach ($votaciones_usuario as $voto) {
        if ($voto->id_album == $album->id_album) {
            $ya_voto = true;
            break;
        }
    }
    
    if ($ya_voto) {
        $_SESSION['message'] = [
            "type" => "warning",
            "description" => "Ya has votado por este álbum anteriormente",
            "title" => "Voto duplicado"
        ];
        header('Location: ../../views/portal/votar.php');
        exit();
    }
    
    // Preparar datos para votación
    $data = [
        "id_artista" => $album->id_artista,
        "id_album" => $album->id_album,
        "id_usuario" => $_SESSION["id_usuario"],
    ];
    
    // Registrar el voto
    if ($tabla_votacion->createVotacion($data)) {
        $_SESSION['message'] = [
            "type" => "success",
            "description" => "¡Voto registrado exitosamente por '" . htmlspecialchars($album->titulo_album) . "'!",
            "title" => "¡Votación Exitosa!"
        ];
    } else {
        $_SESSION['message'] = [
            "type" => "error",
            "description" => "Error al registrar el voto. Intenta nuevamente.",
            "title" => "¡ERROR!"
        ];
    }
    
    header('Location: ../../views/portal/votar.php');
    exit();
    
} else {
    $_SESSION['message'] = [
        "type" => "error",
        "description" => "Solicitud inválida",
        "title" => "¡ERROR!"
    ];
    header('Location: ../../views/portal/votar.php');
    exit();
}
?>