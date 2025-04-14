<?php
require_once '../model/database.php';

header('Content-Type: application/json');

try {
    $db = new database();
    $conn = $db->getConn();

    $sql = "SELECT * FROM transfer_reservas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $eventos = [];

    foreach ($reservas as $reserva) {
        
        switch ($reserva['id_tipo_reserva']) {
            case 1:
                $tipo = 'Aeropuerto → Hotel';
                $startDateTime = $reserva['fecha_entrada'] . 'T' . $reserva['hora_entrada'];
                break;
            case 2:
                $tipo = 'Hotel → Aeropuerto';
                $startDateTime = $reserva['fecha_vuelo_salida'] . 'T' . $reserva['hora_vuelo_salida'];
                break;
            case 3:
                $tipo = 'Ida y vuelta';
                $startDateTime = $reserva['fecha_entrada'] . 'T' . $reserva['hora_entrada']; // usamos ida
                break;
            default:
                $tipo = 'Reserva';
                $startDateTime = $reserva['fecha_reserva'];
                break;
        }

        
        $propsFiltradas = array_filter($reserva, function ($value) {
            return !is_null($value);
        });

        $eventos[] = [
            'title' => 'Reserva #' . $reserva['id_reserva'],
            'start' => $startDateTime,
            'id'    => $reserva['localizador'],
            'extendedProps' => $propsFiltradas
        ];
    }

    echo json_encode($eventos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener las reservas: ' . $e->getMessage()]);
}