<?php
class AirportModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertarAeropuerto($aeropuerto) {
        $stmt = $this->conn->prepare("INSERT INTO transfer_aero (aeropuerto) VALUES (:aeropuerto)");
        return $stmt->execute([':aeropuerto' => $aeropuerto]);
    }

    public function obtenerAeropuertos() {
        $stmt = $this->conn->query("SELECT * FROM transfer_aero");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerAeropuertoPorId($id) {
        $stmt = $this->conn->prepare("SELECT id_destino, aeropuerto FROM transfer_aero WHERE id_destino = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function actualizarAeropuerto($id, $aeropuerto) {
        $stmt = $this->conn->prepare("UPDATE transfer_aero SET aeropuerto = :aeropuerto WHERE id_destino = :id");
        return $stmt->execute([':aeropuerto' => $aeropuerto, ':id' => $id]);
    }

    public function eliminarAeropuerto($id) {
        $stmt = $this->conn->prepare("DELETE FROM transfer_aero WHERE id_destino = :id");
        return $stmt->execute([':id' => $id]);
    }
    public function obtenerPrimerosCincoAeropuertos() {
        $stmt = $this->conn->prepare("SELECT * FROM transfer_aero LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
   

}
