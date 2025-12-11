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
    } //end __construct

    //---------------------------
    // CRUD: Create
    //--------------------------
    public function createUser($data = array())
    {
        if (isset($data["password_usuario"])) {
            $data['password_usuario'] = hash('sha256', $data['password_usuario']);
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
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    } 

    //---------------------------
    // CRUD: Read All
    //--------------------------
    public function readAllUsers()
    {
        $sql = "SELECT * FROM " . $this->table . " INNER JOIN roles ON " . $this->table . ".id_rol = roles.id_rol ORDER BY ap_usuario;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $users = $stmt->fetchAll();
            return (!empty($users)) ? $users : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }
    } 

    //---------------------------
    // Read Users valid for Artists (Rol 2)
    //--------------------------
    public function readAllUsersForArt()
    {
        // AJUSTE: Usamos id_rol = 2 para artistas (antes era 85)
        $sql = "SELECT * FROM " . $this->table . " 
            INNER JOIN roles ON " . $this->table . ".id_rol = roles.id_rol
            WHERE " . $this->table . ".id_rol = 2
            AND " . $this->table . ".id_usuario NOT IN (SELECT id_usuario FROM artistas)
            ORDER BY ap_usuario;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $users = $stmt->fetchAll();
            return (!empty($users)) ? $users : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return array();
        }
    }

    //---------------------------
    // CRUD: Read One
    //--------------------------
    public function readGetUser($id_usuario = 0)
    {
        $sql = "SELECT * FROM " . $this->table . " INNER JOIN roles ON " . $this->table . ".id_rol = roles.id_rol 
                WHERE " . $this->table . "." . $this->primary_key . "= :id_usuario;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $users = $stmt->fetch();
            return (!empty($users)) ? $users : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }
    } 

    //---------------------------
    // CRUD: Update
    //--------------------------
    public function updateUser($id_usuario = 0, $data = array())
    {
        if (isset($data["password_usuario"])) {
            $data['password_usuario'] = hash('sha256', $data['password_usuario']);
        }

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
            $stmt->bindValue(":id", $id_usuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    } 

    //---------------------------
    // CRUD: Delete
    //--------------------------
    public function deleteUser($id_usuario = 0)
    {
        try {
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id;';
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id_usuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error in query: ' . $e->getMessage();
            return false;
        }
    } 

    //---------------------------
    // LOGIN: Validate User
    //--------------------------
    public function validateUser($email = '', $pass = '')
    {
        // AJUSTE: SHA2 con 256 bits para coincidir con la base de datos
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
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return array();
        }
    }
} //end Tabla_usuarios
?>