<?php
class travellerController{
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
    
    
    
}