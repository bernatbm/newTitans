<?php
// La Base de datos
class database{
    private $pdo;

    public function __construct() {
        $host = 'baseDatosNewTitansApp'; // Nombre del contenedor de la bd
        $dataBase = "dataBaseNewTitans";// nombre de la bd
        $user = 'bernat'; // user de la bd
        $password = 'newtitansdb';// pswd de la bd
        $resolved_host = gethostbyname($host); // el nombre de la bd o la ip
        //echo "El nombre del HOST: " . $host ."\n";
        //echo "El nombre o la ip es: " . $resolved_host ."\n";
        if ($resolved_host == $host) { //Si resolved _host es igual a host, entonces host debe ser la IP. 
            $host = '192.168.160.2'; // Si son iguales modificamos el nombre del host por la IP 
            $connection = "mysql:host=$host;dbname=$dataBase;charset=utf8mb4";
            //echo "Todo bien, ya que el host ahora es: $host, la conexion es con $connection ";
        }else{
            $connection = "mysql:host=$host;dbname=$dataBase;charset=utf8mb4";// si son diferentes, el host sigue siendo 'baseDatosNewTitansApp'
           //  echo "Todo bien, el host sigue siendo: $host, la conexion es: $connection ";

        }
        
        try{
            $this->pdo = new PDO($connection, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "You are connected! \n";
        } catch(PDOException $e){
            echo "I'm sorry you can't connect at newTitans database. ERROR: " . $e->getMessage() . "\n";
        }
    }
    public function getConnection(){
        return $this->pdo;
    }
}

new database();
