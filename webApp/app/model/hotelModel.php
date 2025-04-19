<?php
class hotelModel{
private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function obtenerHoteles() {
        $sql = "SELECT * FROM transfer_hotel";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerHotelPorId($id) {
        $sql = "SELECT * FROM transfer_hotel WHERE id_hotel = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function agregarHotel($nombre, $zona, $comision, $usuario, $password) {
        $sql = "INSERT INTO transfer_hotel (nombre_hotel, id_zona, Comision, usuario, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre, $zona, $comision, $usuario, $password]);
    }


    public function actualizarHotel($id_hotel, $nombre, $zona, $comision, $usuario, $password) {
        $sql = "UPDATE transfer_hotel 
                SET nombre_hotel = ?, id_zona = ?, Comision = ?, usuario = ?, password = ? 
                WHERE id_hotel = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre, $zona, $comision, $usuario, $password, $id_hotel]);
    }

  public function eliminarHotel($id) {
    $sql = "DELETE FROM transfer_hotel WHERE id_hotel = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
}


}
?>
