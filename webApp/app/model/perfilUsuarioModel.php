
<?php
require_once 'database.php';

class PerfilUsuarioModel {
    private $conn;
    private $tabla = 'transfer_viajeros';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConn();
    }

    public function obtenerUsuarioPorNombre($nombre) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->tabla WHERE nombre = :nombre");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarUsuario($datos, $nombreOriginal) {
        $stmt = $this->conn->prepare("UPDATE $this->tabla SET 
            nombre = :nombre, 
            apellido1 = :apellido1, 
            apellido2 = :apellido2, 
            direccion = :direccion, 
            codigoPostal = :codigoPostal, 
            ciudad = :ciudad, 
            pais = :pais, 
            email = :email, 
            password = :password
            WHERE nombre = :nombre_original");

        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':apellido1', $datos['apellido1']);
        $stmt->bindParam(':apellido2', $datos['apellido2']);
        $stmt->bindParam(':direccion', $datos['direccion']);
        $stmt->bindParam(':codigoPostal', $datos['codigoPostal']);
        $stmt->bindParam(':ciudad', $datos['ciudad']);
        $stmt->bindParam(':pais', $datos['pais']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':password', $datos['password']);
        $stmt->bindParam(':nombre_original', $nombreOriginal);

        return $stmt->execute();
    }
}