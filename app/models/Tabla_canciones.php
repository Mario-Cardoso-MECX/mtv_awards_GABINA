<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_canciones
{
    private $connect;
    private $table = 'canciones';
    private $primary_key = 'id_acancion';
    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    public function createCancion($data = array())
    {
        // Setting fields dynamically
        $fields = implode(", ", array_keys($data));

        // Setting values dynamically
        $values = ":" . implode(", :", array_keys($data));

        // SQL QUERY - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            $stmt = $this->connect->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            echo "<br>SQL: " . $sql;
            return false;
        }
    }

    public function readAllC()
{
    $sql = "SELECT c.* 
            FROM " . $this->table . " c 
            INNER JOIN artistas a ON c.id_artista = a.id_artista 
            ORDER BY c.nombre_cancion";
    try {
        $stmt = $this->connect->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $canciones = $stmt->fetchAll();
        return (!empty($canciones)) ? $canciones : array();
    } catch (PDOException $e) {
        echo "Error in query: " . $e->getMessage();
        return array();
    }
}

    public function readAllCanciones($id_usuario)
    {
        $sql = "SELECT c.* 
                FROM " . $this->table . " c 
                INNER JOIN artistas a ON c.id_artista = a.id_artista 
                WHERE a.id_usuario = :id_usuario
                ORDER BY c.nombre_cancion";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $canciones = $stmt->fetchAll();
            return (!empty($canciones)) ? $canciones : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return array();
        }
    }


    public function readGetCancion($id_acancion, $id_artista)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = :id_acancion AND id_artista = :id_artista";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_acancion", $id_acancion, PDO::PARAM_INT);
            $stmt->bindValue(":id_artista", $id_artista, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return null;
        }
    }

    public function updateCancion($id_acancion = 0, $data = array())
    {
        $params = array();
        $fields = array();

        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
            $fields[] = "$key = :$key";
        }

        try {
            $setParams = implode(", ", $fields);
            $sql = 'UPDATE ' . $this->table . ' SET ' . $setParams . ' WHERE id_acancion = :id';
            $stmt = $this->connect->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(":id", $id_acancion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    }

    public function deleteCancion($id_cancion = 0)
    {
        try {
            // Verificar si el ID es válido
            if (empty($id_cancion) || !is_numeric($id_cancion)) {
                throw new InvalidArgumentException("El ID de la canción no es válido.");
            }

            // Preparar y ejecutar la consulta de eliminación
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id';
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id_cancion, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error in query: ' . $e->getMessage();
            return false;
        } catch (InvalidArgumentException $e) {
            echo 'Validation error: ' . $e->getMessage();
            return false;
        }
    }

    public function getIdArtistaByUsuario($id_usuario)
    {
        $sql = "SELECT id_artista FROM artistas WHERE id_usuario = :id_usuario";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $artista = $stmt->fetch(PDO::FETCH_OBJ);
            return $artista ? $artista->id_artista : null;
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return null;
        }
    }

    public function readAllByArtista($id_artista)
{
    $sql = "SELECT c.*
            FROM " . $this->table . " c
            WHERE c.id_artista = :id_artista
            ORDER BY c.nombre_cancion";

    try {
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(":id_artista", $id_artista, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error in query: " . $e->getMessage();
        return array();
    }
}

}


