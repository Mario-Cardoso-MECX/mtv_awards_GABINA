<?php
class Conecct
{
    public $conecct = null;
    private $host = "localhost";
    private $db = "mtv_awardsgaby";
    private $user = "root";
    // private $password = "abnerclash10";
    private $password = "";
    private $port = "3306";
    private $charset = "utf8";

    function __construct()
    {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $this->conecct = new PDO($dsn, $this->user, $this->password);
            //settings errors
            $this->conecct->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo
            //    '<div class="alert alert-success" role"alert">
            //    Conexion exitosa
            //    </div>';
        } catch (PDOException $e) {
            echo
                '<div class="alert alert-danger" role"alert">
                Error de conexion :' . $e->getMessage() . '
                </div>';
        }
    }
}