<?php
class vehicleModel{
private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function obtenerVehicles() {
        $sql = "SELECT * FROM transfer_vehiculo";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerVehiclePerId($id) {
        $stmt = $this->conn->prepare("SELECT id_vehiculo, Descripción, email_conductor, password FROM transfer_vehiculo WHERE id_vehiculo = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function agregarVehicle($descripcion, $email_conductor, $password) {
        $sql = "INSERT INTO transfer_vehiculo (Descripción, email_conductor, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$descripcion, $email_conductor, $password]);
    }
    

    public function actualizarVehicle($id_vehiculo, $descripcion, $email_conductor, $password) {
        $sql = "UPDATE transfer_vehiculo 
                SET Descripción = ?, email_conductor = ?, password = ? 
                WHERE id_vehiculo = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$descripcion, $email_conductor, $password, $id_vehiculo]);
    }
    
    public function eliminarVehicle($id) {
        $sql = "DELETE FROM transfer_vehiculo WHERE id_vehiculo = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

}


?>