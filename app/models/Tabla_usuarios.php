<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_usuarios
{
    private $connect;
    private $table = 'usuarios';
    private $primary_key = 'id_usuario';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }//end __construct

    //---------------------------
    // QUERIES : PETICIONES SQL
    // CRUD: Create | Read | Delete | Update
    //--------------------------
    public function createUser($data = array())
    {
        //Setting a new value
        if (isset($data["password_usuario"])) {
            $data['password_usuario'] = hash('sha256', $data['password_usuario']);
        }//end isset
        // echo print("<pre>".print_r($data,true)."</pre>");

        /*
            INSERT INTO usuarios 
                (nombre_usuario, ap_usuario, am_usuario, sexo_usuario, email_usuario, password_usuario, imagen_usuario, id_rol) 
                VALUES ('', "", NULL)
                VALUES (:nombre, :ap, :am, :sexo, :email, :pass, :img, :rol)
        */

        //Setting fields dynamically
        $fields = implode(", ", array_keys($data));

        //Setting values dynamically into slq
        $values = ":" . implode(", :", array_keys($data));

        //SQL QUERY - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            //Prepare the statement   
            $stmt = $this->connect->prepare($sql);

            //Bind values dynamically
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }//end foreach

            //Execute sql
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }//end catch


        // echo print("<pre>".print_r($values,true)."</pre>");
    }//end createUser

    public function readAllUsers()
    {
        /**
            QUERY - SELECT
            SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol;
         */
        $sql = "SELECT * FROM " . $this->table . " INNER JOIN roles ON " . $this->table . ".id_rol = roles.id_rol ORDER BY ap_usuario;";
        try {
            //PREPARE THE STATEMENT
            $stmt = $this->connect->prepare($sql);
            //SPECIFIC FECTH MODE BEFORE CALLING FETCH
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            //EXECUTE THE QUERY
            $stmt->execute();
            //RETURN THE FETCHED RESULT
            $users = $stmt->fetchAll();
            return (!empty($users)) ? $users : array();
        }//end try
        catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }//end catch
    }//end readAllUsers

    public function readAllUsersForArt()
    {
        /**
         * QUERY - SELECT
         * Selecciona usuarios tipo Artista (id_rol = 85) que no tengan registros en la tabla artistas.
         * SELECT * FROM usuarios 
         * INNER JOIN roles ON usuarios.id_rol = roles.id_rol
         * WHERE usuarios.id_rol = 85 AND usuarios.id_usuario NOT IN (SELECT id_usuario FROM artistas)
         * ORDER BY ap_usuario;
         */
        $sql = "SELECT * 
            FROM " . $this->table . " 
            INNER JOIN roles ON " . $this->table . ".id_rol = roles.id_rol
            WHERE " . $this->table . ".id_rol = 85
            AND " . $this->table . ".id_usuario NOT IN (SELECT id_usuario FROM artistas)
            ORDER BY ap_usuario;";
        try {
            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);
            // Configurar el modo de fetch
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            // Ejecutar la consulta
            $stmt->execute();
            // Retornar los resultados obtenidos
            $users = $stmt->fetchAll();
            return (!empty($users)) ? $users : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return array();
        }
    }


    public function readGetUser($id_usuario = 0)
    {
        /**
            QUERY - SELECT
            SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol;
         */
        $sql = "SELECT * FROM " . $this->table . " INNER JOIN roles ON " . $this->table . ".id_rol = roles.id_rol 
                WHERE " . $this->table . "." . $this->primary_key . "= :id_usuario;";
        try {
            //PREPARE THE STATEMENT
            $stmt = $this->connect->prepare($sql);
            //BIND PARAM
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            //SPECIFIC FECTH MODE BEFORE CALLING FETCH
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            //EXECUTE THE QUERY
            $stmt->execute();
            //RETURN THE FETCHED RESULT
            $users = $stmt->fetch();
            return (!empty($users)) ? $users : array();
        }//end try
        catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }//end catch
    }//end readGetUser

    public function updateUser($id_usuario = 0, $data = array())
    {
        /**
            UPDATE usuarios SET nombre_usuario = '', ap_usuario = '' WHERE id_usuario = ;
            UPDATE usuarios SET nombre_usuario = :nom, ap_usuario = :ap  WHERE id_usuario = :id;
         */

        //Setting a new value
        if (isset($data["password_usuario"])) {
            $data['password_usuario'] = hash('sha256', $data['password_usuario']);
        }//end isset

        //Dynamically build the set part of sql
        $params = array();
        $fields = array();

        //Loop trought the data array and construc the clauses
        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
            $fields[] = "$key = :$key";
        }//end foreach

        try {
            //Join all field to form set clause
            $setParams = implode(", ", $fields);

            //SQL QUERY - UPDATE
            $sql = 'UPDATE ' . $this->table . ' SET ' . $setParams . ' WHERE ' . $this->primary_key . ' = :id;';

            //Prepara the statement
            $stmt = $this->connect->prepare($sql);
            //Bind params dynamically
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }//end 

            //Bind param id
            $stmt->bindValue(":id", $id_usuario);

            //Execute SQL
            return $stmt->execute();

        }//end try
        catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }//end catch

    }//end updateUser

    public function deleteUser($id_usuario = 0)
    {
        /**
            DELETE FROM usuarios WHERE id_usuario = ;
        */
        try {
            //SQL QUERY - DELETE
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id;';

            //Prepare the statement
            $stmt = $this->connect->prepare($sql);

            //Bind param id
            $stmt->bindValue(":id", $id_usuario);

            //Execute SQL
            return $stmt->execute();
        }//end try
        catch (PDOException $e) {
            echo 'Error in query: ' . $e->getMessage();
            return false;
        }//end catch
    }//end deleteUser

    //---------------------------
    // QUERIES : ESPECIFICAS PETICIONES 
    //--------------------------
    // public function validateUser($email = '', $pass = '')
    // {
    //     $sql = 'SELECT * FROM ' . $this->table . ' WHERE correo_usuario = :email AND password_usuario = SHA2(:pass,0);';
    //     try {
    //         //Preparate the query
    //         $stmt = $this->connect->prepare($sql);

    //         //Bind parameters to query
    //         $stmt->bindValue(":email", $email);
    //         $stmt->bindValue(":pass", $pass);

    //         //Specific fecth mode before calling fetch
    //         $stmt->setFetchMode(PDO::FETCH_OBJ);

    //         //Execute the query
    //         $stmt->execute();

    //         //Return the fetched result
    //         $user = $stmt->fetch();
    //         return (!empty($user)) ? $user : array();
    //     }//end try
    //     catch (PDOException $e) {
    //         echo "Error in query: " . $e->getMessage();
    //         return array();
    //     }//end catch
    // }//end validateUser

    public function validateUser($email = '', $pass = '')
{
    $sql = 'SELECT * FROM ' . $this->table . ' 
            WHERE correo_usuario = :email 
            AND password_usuario = SHA2(:pass, 256);';
    try {
        $stmt = $this->connect->prepare($sql);

        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":pass", $pass);

        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $stmt->execute();

        $user = $stmt->fetch();
        return (!empty($user)) ? $user : array();
    }
    catch (PDOException $e) {
        echo "Error in query: " . $e->getMessage();
        return array();
    }
}


}//end Tabla_usuarios