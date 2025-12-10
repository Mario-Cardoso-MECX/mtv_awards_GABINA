<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_generos
{
    private $connect;
    private $table = 'generos';
    private $primary_key = 'id_genero';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    //---------------------------
    // CRUD: Create | Read | Update | Delete
    //---------------------------

    // Leer todos los géneros registrados
    public function readAllGeneros()
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE estatus_genero = 1;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $generos = $stmt->fetchAll();
            return (!empty($generos)) ? $generos : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return array();
        }
    }
    

    public function readAllGenerosIncluyendoEstatus()
    {
        $sql = "SELECT * FROM " . $this->table . ";";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $generos = $stmt->fetchAll();
            return (!empty($generos)) ? $generos : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return array();
        }
    }


    public function readGetGenero($id_genero = 0)
    {
        /**
            QUERY - SELECT
            SELECT * FROM generos WHERE id_genero = :id_genero;
         */
        $sql = "SELECT * FROM generos WHERE id_genero = :id_genero;";
        try {
            // PREPARE THE STATEMENT
            $stmt = $this->connect->prepare($sql);
            // BIND PARAM
            $stmt->bindValue(":id_genero", $id_genero, PDO::PARAM_INT);
            // SPECIFIC FETCH MODE BEFORE CALLING FETCH
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            // EXECUTE THE QUERY
            $stmt->execute();
            // RETURN THE FETCHED RESULT
            $genero = $stmt->fetch();
            return (!empty($genero)) ? $genero : array();
        }//end try
        catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }//end catch
    }//end readGetGenero


    // Método para registrar un nuevo género
    public function createGenero($data)
    {
        $sql = "INSERT INTO " . $this->table . " (nombre_genero) VALUES (:nombre_genero)";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':nombre_genero', $data['nombre_genero'], PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al registrar el género: " . $e->getMessage();
            return false;
        }
    }

    public function updateGenero($id_genero = 0, $data = array())
    {
        /**
            UPDATE generos SET nombre_genero = :nombre WHERE id_genero = :id;
         */

        // Dinámicamente construye las partes SET del SQL
        $params = array();
        $fields = array();

        // Recorre el array de datos para construir las cláusulas
        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
            $fields[] = "$key = :$key";
        }//end foreach

        try {
            // Une todos los campos para formar la cláusula SET
            $setParams = implode(", ", $fields);

            // Consulta SQL - UPDATE
            $sql = 'UPDATE generos SET ' . $setParams . ' WHERE id_genero = :id;';

            // Prepara la declaración
            $stmt = $this->connect->prepare($sql);

            // Vincula los parámetros dinámicamente
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }//end foreach

            // Vincula el parámetro id
            $stmt->bindValue(":id", $id_genero);

            // Ejecuta el SQL
            return $stmt->execute();

        }//end try
        catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }//end catch
    }//end updateGenero

    public function deleteGenero($id_genero = 0)
    {
        /**
            DELETE FROM generos WHERE id_genero = :id;
         */
        try {
            // Consulta SQL - DELETE
            $sql = 'DELETE FROM generos WHERE id_genero = :id;';

            // Prepara la declaración
            $stmt = $this->connect->prepare($sql);

            // Vincula el parámetro id
            $stmt->bindValue(":id", $id_genero);

            // Ejecuta el SQL
            return $stmt->execute();
        }//end try
        catch (PDOException $e) {
            echo 'Error in query: ' . $e->getMessage();
            return false;
        }//end catch
    }//end deleteGenero


}
