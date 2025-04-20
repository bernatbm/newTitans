<?php
class ZoneModel {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function obtenerZonas() {
        $sql = "SELECT * FROM transfer_zona";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerZonaPorId($id) {
        $sql = "SELECT * FROM transfer_zona WHERE id_zona = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarZona($descripcion) {
        $sql = "INSERT INTO transfer_zona (descripcion) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$descripcion]);
    }

    public function actualizarZona($id, $descripcion) {
        $sql = "UPDATE transfer_zona SET descripcion = ? WHERE id_zona = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$descripcion, $id]);
    }

    public function eliminarZona($id) {
        // Eliminar los hoteles asociados
    $query = "DELETE FROM transfer_hotel WHERE id_zona = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Eliminar la zona
    $query = "DELETE FROM transfer_zona WHERE id_zona = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
    }
   
