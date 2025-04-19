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

    public function crearTablaAdmin() {
        $checkTableSQL = "
            SELECT COUNT(*) AS existe 
            FROM information_schema.TABLES 
            WHERE TABLE_NAME = 'transfer_administradores' 
            AND TABLE_SCHEMA = 'dataBaseNewTitans';
        ";
        $result = $this->pdo->query($checkTableSQL); // Usamos $this->pdo aquí
        $row = $result->fetch(PDO::FETCH_ASSOC);
    
        if ($row['existe'] == 0) {
            $createTableSQL = "
                CREATE TABLE transfer_administradores (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(255) NOT NULL,
                    apellido1 VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    isAdmin TINYINT DEFAULT 1
                );
            ";
            $this->pdo->exec($createTableSQL); 
        } else {
            $columnasNecesarias = [
                'id',
                'nombre',
                'apellido1',
                'email',
                'password',
                'isAdmin'
            ];
    
            foreach ($columnasNecesarias as $columna) {
                $checkColumnSQL = "
                    SELECT COUNT(*) AS existe 
                    FROM information_schema.COLUMNS 
                    WHERE TABLE_NAME = 'transfer_administradores' 
                    AND COLUMN_NAME = '$columna' 
                    AND TABLE_SCHEMA = 'dataBaseNewTitans';
                ";
                $columnResult = $this->pdo->query($checkColumnSQL);
                $columnRow = $columnResult->fetch(PDO::FETCH_ASSOC);
    
                if ($columnRow['existe'] == 0) {
                    if ($columna == 'isAdmin') {
                        $alterSQL = "ALTER TABLE transfer_administradores ADD $columna TINYINT DEFAULT 1;";
                    } elseif ($columna == 'id') {
                        $alterSQL = "ALTER TABLE transfer_administradores ADD $columna INT;";
                    } else {
                        $alterSQL = "ALTER TABLE transfer_administradores ADD $columna VARCHAR(255);";
                    }
    
                    $this->pdo->exec($alterSQL);
                }
            }
        }
    }
}