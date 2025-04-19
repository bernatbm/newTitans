<?php
require_once '../model/database.php';

header('Content-Type: application/json');

try {
    $db = new database();
    $conn = $db->getConn();

    $sql = "SELECT r.*, v.Descripción AS nombre_vehiculo, h.nombre_hotel AS nombre_hotel, u.nombre AS nombre, u.apellido1 AS apellido,t.Descripción AS tipo_reserva 
        FROM transfer_reservas r
        JOIN transfer_vehiculo v ON r.id_vehiculo = v.id_vehiculo 
        JOIN transfer_hotel h ON r.id_hotel = h.id_hotel
        JOIN transfer_viajeros u ON r.email_cliente = u.email
        JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva";
   
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

        $propsFiltradas['id_reserva'] = $reserva['id_reserva'];
        $propsFiltradas['nombre'] = $reserva['nombre'].' '.$reserva['apellido'];
        $propsFiltradas['Email Cliente'] = $reserva['email_cliente']; 
        $propsFiltradas['nombre_hotel'] = $reserva['nombre_hotel']; 
        $propsFiltradas['tipo_reserva'] = $reserva['tipo_reserva'];
        $propsFiltradas['Fecha Reserva'] = $reserva['fecha_reserva']; 
        $propsFiltradas['Fecha Modificacion'] = $reserva['fecha_modificacion']; 
        $propsFiltradas['Fecha Entrada'] = $reserva['fecha_entrada'];
        $propsFiltradas['Hora Entrada'] = $reserva['hora_entrada']; 
        $propsFiltradas['Numero Vuelo Entrada'] = $reserva['numero_vuelo_entrada']; 
        $propsFiltradas['Origen Vuelo Entrada'] = $reserva['origen_vuelo_entrada']; 
        $propsFiltradas['Hora Vuelo Salida'] = $reserva['fecha_vuelo_salida'];  
        $propsFiltradas['Num. Viajeros'] = $reserva['num_viajeros']; 
        $propsFiltradas['nombre_vehiculo'] = $reserva['nombre_vehiculo'];
        

        $eventos[] = [
            'title' => '#'. " " .$reserva['id_reserva']. " - ". $reserva['localizador']." ".$reserva['nombre']. " " . $reserva['apellido'],
            'start' => $startDateTime,
            'id'    => $reserva['localizador'],
            'extendedProps' => $propsFiltradas
        ];
    }

    echo json_encode($eventos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener las reservas: ' . $e->getMessage()]);
}