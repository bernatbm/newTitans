<?php
class TravellerModel {

    
    private $conn;

    function __construct($connDB) {
        $this->conn = $connDB;
    }
    
    public function loginTraveller($usuario, $password) {
        $stmt = $this->conn->prepare("
     (SELECT email, nombre, apellido1, password,isAdmin FROM transfer_viajeros WHERE email = ? OR (nombre = ? AND apellido1 = ?))
    UNION
    (SELECT email, nombre, apellido1, password, isAdmin FROM transfer_administradores WHERE email = ? OR (nombre = ? AND apellido1 = ?))
"); //Para iniciar sesión con email OR nombre y apellido1 dependiendo de las tablas.
        
        if (str_contains($usuario, ' ')) {//Si hau un espacio quiere decir que se iniciara la ssion con name + surname
            [$nombre, $apellido1] = explode(' ', $usuario, 2);// separara la cadena de usuario en 2( nombre " " apellido)
            $stmt->execute([$usuario, $nombre, $apellido1, $usuario, $nombre, $apellido1]);// Mira si hay email o nombre y apellido
        } else {
            $stmt->execute([$usuario, '', '', $usuario, '', '']);// Si no, solo hay email
        }
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            
            $storedPassword = trim($user['password']);
            $inputPassword = trim($password);
            
            if ($inputPassword === $storedPassword) {//Ahora que tenemos al user con nombre + apellido o email buscamos match con password
                return ['success' => true, 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'Credenciales incorrectas'];
            }
        } else {
            return ['success' => false, 'message' => 'Credenciales incorrectas'];
        }
    }

    public function emailExist() {
        header('Content-Type: application/json');
    
        $response = ['exists' => false];
    
        if (isset($_GET['email'])) {
            $email = $_GET['email']; // <- Añadir esto
    
            $stmt = $this->conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $response['exists'] = true;
            }
        }
    
        echo json_encode($response);
    }
    public function loginCorporate($usuario, $password) {
        $sql = "SELECT * FROM transfer_corporativos WHERE (email = :usuario OR nombre_empresa = :usuario) AND password = :password LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return [
                'success' => true,
                'user' => $result
            ];
        }
        return ['success' => false];
    }
    public function loginUnificado($usuario, $password) {
        $sql = "
            SELECT email, nombre, apellido1, password, isAdmin FROM transfer_viajeros 
            WHERE email = :usuario OR (nombre = :nombre AND apellido1 = :apellido)
            UNION
            SELECT email, nombre, apellido1, password, isAdmin FROM transfer_administradores 
            WHERE email = :usuario OR (nombre = :nombre AND apellido1 = :apellido)
            UNION
            SELECT email, nombre_empresa AS nombre, '' AS apellido1, password, isAdmin FROM transfer_corporativos 
            WHERE email = :usuario OR nombre_empresa = :usuario
            LIMIT 1;
        ";
    
        $stmt = $this->conn->prepare($sql);
    
        if (str_contains($usuario, ' ')) {
            [$nombre, $apellido] = explode(' ', $usuario, 2);
        } else {
            $nombre = $usuario;
            $apellido = '';
        }
    
        $stmt->execute([
            ':usuario' => $usuario,
            ':nombre' => $nombre,
            ':apellido' => $apellido
        ]);
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && trim($user['password']) === trim($password)) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Credenciales incorrectas'];
        }
    }
    
}