<?php
require_once '../model/database.php';

if (isset($_GET['id_zona'])) {
    $idZona = $_GET['id_zona'];

    $db = new database();
    $conn = $db->getConn();

    $stmt = $conn->prepare("SELECT id_hotel, nombre_hotel FROM transfer_hotel WHERE id_zona = :id_zona");
    $stmt->bindParam(':id_zona', $idZona);
    $stmt->execute();

    $hoteles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($hoteles);
}
?>