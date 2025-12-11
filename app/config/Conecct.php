<?php
// Incluimos el archivo con las credenciales
require_once __DIR__ . '/Constants.php';

class Conecct
{
    public $conecct = null;

    function __construct()
    {
        try {
            // Usamos las constantes definidas en el otro archivo
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            
            $this->conecct = new PDO($dsn, DB_USER, DB_PASS);
            
            // Configuración de errores
            $this->conecct->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // echo '<div class="alert alert-success" role="alert">Conexion exitosa</div>';

        } catch (PDOException $e) {
            echo '<div class="alert alert-danger" role="alert">
                    Error de conexion: ' . $e->getMessage() . '
                  </div>';
            exit();
        }
    }
}
?>