<?php
require_once '../model/database.php';

try {
    $db = new database();
    $conn = $db->getConn();

    $stmt = $conn->query("SELECT id_destino, aeropuerto FROM transfer_aero");
    $aeropuertos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($aeropuertos as $aeropuerto) {
        echo '<option value="' . $aeropuerto['id_destino'] . '">' . htmlspecialchars($aeropuerto['aeropuerto']) . '</option>';
    }
} catch (PDOException $e) {
    echo '<option disabled>Error al cargar aeropuertos</option>';
}
?>
