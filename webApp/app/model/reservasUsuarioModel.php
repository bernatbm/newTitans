<?php
require_once 'database.php';

class ReservasUsuarioModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConn();
    }

    public function obtenerEmailPorNombre($nombre) {
        $sql = "SELECT email FROM transfer_viajeros WHERE nombre = :nombre";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function obtenerReservasPorEmail($email) {
        $sql = "SELECT r.*, t.`Descripción` AS tipo_reserva_desc
                FROM transfer_reservas r
                LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
                WHERE r.email_cliente = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}