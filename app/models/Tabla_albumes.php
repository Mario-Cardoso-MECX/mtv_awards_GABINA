<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_albumes
{
    private $connect;
    private $table = 'albumes';
    private $primary_key = 'id_album';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    //---------------------------
    // CRUD: Create | Read | Update | Delete
    //---------------------------

    // Leer todos los álbumes de la tabla sin necesidad de un argumento
    // public function readAllAlbumsG()
    // {
    //     $sql = "SELECT " . $this->table . ".id_album, 
    //                " . $this->table . ".titulo_album, 
    //                " . $this->table . ".imagen_album, 
    //                " . $this->table . ".estatus_album
    //         FROM " . $this->table . "
    //         ORDER BY " . $this->table . ".fecha_lanzamiento_album;";
    //     try {
    //         $stmt = $this->connect->prepare($sql);
    //         $stmt->setFetchMode(PDO::FETCH_OBJ);
    //         $stmt->execute();
    //         $albums = $stmt->fetchAll();
    //         return (!empty($albums)) ? $albums : array();
    //     } catch (PDOException $e) {
    //         echo "Error en la consulta: " . $e->getMessage();
    //         return array();
    //     }
    // }

    
            // También modifica readAllAlbumsG si tiene problemas similares
            public function readAllAlbumsG()
            {
                $sql = "SELECT a.*, 
                            u.nombre_usuario, 
                            g.nombre_genero 
                        FROM albumes a
                        LEFT JOIN artistas ar ON a.id_artista = ar.id_artista
                        LEFT JOIN usuarios u ON ar.id_usuario = u.id_usuario
                        LEFT JOIN generos g ON a.id_genero = g.id_genero
                        WHERE a.estatus_album = 1
                        ORDER BY a.titulo_album";
                
                try {
                    $stmt = $this->connect->prepare($sql);
                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                    $stmt->execute();
                    return $stmt->fetchAll();
                } catch (PDOException $e) {
                    return [];
                }
            }

    // Crear un nuevo álbum
    public function createAlbum($data = array())
    {
        // Configurar campos dinámicamente
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        echo print ("<pre>" . print_r($data, true) . "</pre>");
        // Consulta SQL - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);

            // Vincular valores dinámicamente
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }

            // Ejecutar consulta
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    // Leer todos los álbumes de un usuario específico
    public function readAllAlbums($id_usuario)
    {
        $sql = "SELECT " . $this->table . ".id_album, 
                       " . $this->table . ".titulo_album, 
                       " . $this->table . ".imagen_album, 
                       " . $this->table . ".estatus_album
                FROM " . $this->table . "
                INNER JOIN artistas ON " . $this->table . ".id_artista = artistas.id_artista
                INNER JOIN usuarios ON artistas.id_usuario = usuarios.id_usuario
                WHERE usuarios.id_usuario = :id_usuario AND estatus_album = 1
                ORDER BY " . $this->table . ".fecha_lanzamiento_album;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $albums = $stmt->fetchAll();
            return (!empty($albums)) ? $albums : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return array();
        }
    }


    

    public function readAllAlbumsGeneral($id_usuario)
    {
        $sql = "SELECT " . $this->table . ".id_album, 
                       " . $this->table . ".titulo_album, 
                       " . $this->table . ".imagen_album, 
                       " . $this->table . ".estatus_album
                FROM " . $this->table . "
                INNER JOIN artistas ON " . $this->table . ".id_artista = artistas.id_artista
                INNER JOIN usuarios ON artistas.id_usuario = usuarios.id_usuario
                WHERE usuarios.id_usuario = :id_usuario
                ORDER BY " . $this->table . ".fecha_lanzamiento_album;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $albums = $stmt->fetchAll();
            return (!empty($albums)) ? $albums : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return array();
        }
    }


    // // Leer un álbum específico por su ID
    // public function readGetAlbum($id_album = 0)
    // {
    //     $sql = "SELECT albumes.*, usuarios.nombre_usuario, generos.nombre_genero
    //             FROM " . $this->table .
    //         " LEFT JOIN usuarios ON " . $this->table . ".id_artista = usuarios.id_usuario" .
    //         " LEFT JOIN generos ON " . $this->table . ".id_genero = generos.id_genero" .
    //         " WHERE " . $this->primary_key . " = :id_album;";
    //     try {
    //         $stmt = $this->connect->prepare($sql);
    //         $stmt->bindValue(":id_album", $id_album, PDO::PARAM_INT);
    //         $stmt->setFetchMode(PDO::FETCH_OBJ);
    //         $stmt->execute();
    //         $album = $stmt->fetch();
    //         return (!empty($album)) ? $album : array();
    //     } catch (PDOException $e) {
    //         echo "Error en la consulta: " . $e->getMessage();
    //     }
    // }

    public function readGetAlbum($id_album)
{
    // Verifica si tu tabla tiene id_album o id_album como columna
    $sql = "SELECT a.*, 
                   u.nombre_usuario, 
                   g.nombre_genero 
            FROM albumes a
            LEFT JOIN artistas ar ON a.id_artista = ar.id_artista
            LEFT JOIN usuarios u ON ar.id_usuario = u.id_usuario
            LEFT JOIN generos g ON a.id_genero = g.id_genero
            WHERE a.id_album = :id_album";  // Asegúrate que sea a.id_album
    
    try {
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(":id_album", $id_album, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        echo "Error in query: " . $e->getMessage();
        echo "<br>SQL: " . $sql;
        return null;
    }
}

    // Actualizar información de un álbum
    public function updateAlbum($id_album = 0, $data = array())
    {
        $params = array();
        $fields = array();

        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
            $fields[] = "$key = :$key";
        }

        try {
            $setParams = implode(", ", $fields);
            $sql = 'UPDATE ' . $this->table . ' SET ' . $setParams . ' WHERE ' . $this->primary_key . ' = :id;';
            $stmt = $this->connect->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(":id", $id_album);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    // Eliminar un álbum por su ID
    public function deleteAlbum($id_album = 0)
    {
        try {
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id;';
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id_album);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

}
