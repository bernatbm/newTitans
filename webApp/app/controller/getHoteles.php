<?php
require_once '../model/database.php';

try {
    $db = new database();
    $conn = $db->getConn();

    $query = "SELECT id_hotel, nombre_hotel FROM transfer_hotel";
    $stmt = $conn->query($query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['id_hotel'] . '">' . htmlspecialchars($row['nombre_hotel']) . '</option>';
    }
} catch (PDOException $e) {
    echo '<option disabled>Error cargando hoteles</option>';
}
?>