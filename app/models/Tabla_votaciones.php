<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_votaciones
{
    private $connect;
    private $table = 'votaciones';
    private $primary_key = 'id_votacion';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    public function createVotacion($data = array())
    {
        // Asegúrate de que los datos tengan id_nominacion
        if (!isset($data['id_nominacion'])) {
            // Buscar nominación existente
            $id_nominacion = $this->obtenerNominacion($data['id_artista'], $data['id_album']);
            
            if (!$id_nominacion) {
                // Crear nominación automática si no existe
                $id_nominacion = $this->crearNominacionAutomatica($data['id_artista'], $data['id_album']);
            }
            
            $data['id_nominacion'] = $id_nominacion;
        }
        
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            $stmt = $this->connect->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en createVotacion: " . $e->getMessage());
            error_log("SQL: " . $sql);
            error_log("Data: " . print_r($data, true));
            return false;
        }
    }

    private function obtenerNominacion($id_artista, $id_album)
    {
        $sql = "SELECT id_nominacion FROM nominaciones 
                WHERE id_artista = ? AND id_album = ? 
                LIMIT 1";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute([$id_artista, $id_album]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result) ? $result['id_nominacion'] : false;
        } catch (PDOException $e) {
            error_log("Error en obtenerNominacion: " . $e->getMessage());
            return false;
        }
    }

    private function crearNominacionAutomatica($id_artista, $id_album)
    {
        // Usar categoría 1 por defecto (Álbum del Año)
        $sql = "INSERT INTO nominaciones (id_categoria_nominacion, id_album, id_artista) 
                VALUES (1, ?, ?)";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute([$id_album, $id_artista]);
            return $this->connect->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en crearNominacionAutomatica: " . $e->getMessage());
            return 0;
        }
    }

    public function countVotacionesByAlbum($id_album)
    {
        $sql = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE id_album = :id_album";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_album", $id_album, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log("Error en countVotacionesByAlbum: " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerTop5Albumes()
    {
        $sql = "SELECT a.titulo_album, a.imagen_album, COUNT(v.id_votacion) as total_votos 
                FROM " . $this->table . " v
                INNER JOIN albumes a ON v.id_album = a.id_album
                GROUP BY v.id_album 
                ORDER BY total_votos DESC 
                LIMIT 5";

        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en obtenerTop5Albumes: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerAlbumMasVotado()
    {
        $sql = "SELECT a.*, ar.pseudonimo_artista, COUNT(v.id_votacion) as total_votos 
                FROM " . $this->table . " v
                INNER JOIN albumes a ON v.id_album = a.id_album
                INNER JOIN artistas ar ON a.id_artista = ar.id_artista
                GROUP BY v.id_album 
                ORDER BY total_votos DESC 
                LIMIT 1";

        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en obtenerAlbumMasVotado: " . $e->getMessage());
            return null;
        }
    }

    public function readAllVotaciones($id_usuario)
    {
        $sql = "SELECT v.* FROM " . $this->table . " v
                WHERE v.id_usuario = :id_usuario
                ORDER BY v.id_votacion";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readAllVotaciones: " . $e->getMessage());
            return [];
        }
    }

    public function readGetVotacion($id_votacion)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = :id_votacion";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_votacion", $id_votacion, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readGetVotacion: " . $e->getMessage());
            return null;
        }
    }

    // Agrega este método para verificar votos por usuario
public function hasUserVotedForAlbum($id_usuario, $id_album)
{
    $sql = "SELECT COUNT(*) as total FROM " . $this->table . " 
            WHERE id_usuario = :id_usuario AND id_album = :id_album";
    
    try {
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->bindValue(":id_album", $id_album, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['total'] > 0);
    } catch (PDOException $e) {
        error_log("Error en hasUserVotedForAlbum: " . $e->getMessage());
        return false;
    }
}
}
?>