<?php
require_once '../model/database.php';

try {
    $db = new database();
    $conn = $db->getConn();

    $stmt = $conn->query("SELECT id_destino, aeropuerto FROM transfer_aero");
    $aeropuertos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($aeropuertos);
} catch (PDOException $e) {
    echo json_encode([]);
}