<?php
$host = 'localhost';
$db = 'mtv_awardsgaby';
$user = 'root';
// $password = 'abnerclash10';
$password = '';
$port = '3306';
$charset = 'utf8';
try {
    //dsn = Data Source Name
    $dsn = "mysql:host=" . $host . ";dbname=" . $db . ";charset=" . $charset;
    $dbh = new PDO($dsn, $user, $password); //Handle
    echo "conexion exitosa";
} catch (PDOException $e) {
    echo "error de conexion : " . $e->getMessage();
}