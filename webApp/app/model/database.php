<?php
class database{
    private $pdo;

    public function __construct(){
        $host = "baseDatosNewTitansApp";
        $db ='dataBaseNewTitans';
        $user='bernat';
        $pswd = 'newtitansdb';
        $conn = "mysql:host=$host;dbname=$db";

        try{
            $this->pdo=new PDO($conn,$user,$pswd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);// Config en caso de error

            $this->pdo->exec("SET NAMES 'utf8'"); 
        }catch(PDOException $e){
            echo "No hay conexión:" . $e->getMessage();
            exit();//Cerramos conexion 
        }
    }

    public function getConn(){
        return $this->pdo;
    }
}