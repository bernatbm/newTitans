<?php
class RegistroModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Contar administradores para la primera session
    public function contarAdministradores() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM transfer_administradores WHERE isAdmin = 1");
        $stmt->execute();
        $administrador = $stmt->fetch(PDO::FETCH_ASSOC);
        return $administrador['total'];
    }

    // Registrar un nuevo usuario
    public function registrarUsuario($datos) {
        $sql = "INSERT INTO transfer_viajeros (nombre, apellido1, apellido2, email, password, direccion, codigoPostal, ciudad, pais, isAdmin) 
                VALUES (:nombre, :apellido1, :apellido2, :email, :password, :direccion, :codigoPostal, :ciudad, :pais, :isAdmin)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':apellido1' => $datos['apellido1'],
            ':apellido2' => $datos['apellido2'],
            ':email' => $datos['email'],
            ':password' =>$datos['password'],
            ':direccion' => $datos['direccion'],
            ':codigoPostal' => $datos['codigoPostal'],
            ':ciudad' => $datos['ciudad'],
            ':pais' => $datos['pais'],
            ':isAdmin' => $datos['isAdmin']
        ]);
    }
}
?>
