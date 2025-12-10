<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_nominaciones
{
    private $connect;
    private $table = 'nominaciones';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    public function obtenerNominacionPorAlbum($id_artista, $id_album)
    {
        $sql = "SELECT id_nominacion FROM " . $this->table . " 
                WHERE id_artista = ? AND id_album = ? 
                LIMIT 1";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute([$id_artista, $id_album]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result) ? $result['id_nominacion'] : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function crearNominacion($id_categoria_nominacion, $id_album, $id_artista)
    {
        $sql = "INSERT INTO " . $this->table . " 
                (id_categoria_nominacion, id_album, id_artista) 
                VALUES (?, ?, ?)";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute([$id_categoria_nominacion, $id_album, $id_artista]);
            return $this->connect->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function obtenerTodasNominaciones()
    {
        $sql = "SELECT * FROM " . $this->table;
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
?> 