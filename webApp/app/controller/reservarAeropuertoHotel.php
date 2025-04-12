<?php
require_once '../model/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fechaEntrada = $_POST['fecha_llegada'] ?? null;
    $horaEntrada = $_POST['hora_llegada'] ?? null;
    $numeroVuelo = $_POST['numero_vuelo_entrada'] ?? null;
    $aeropuertoOrigen = $_POST ['aeropuerto_origen'] ?? null;
    $hotel = $_POST ['id_hotel'] ?? null;
    $numViajeros = $_POST['num_viajeros'] ?? null;
    $emailCliente = $_POST['email_cliente'] ?? null;
    $idTipoReserva = $_POST['id_tipo_reserva'] ?? null;
    



    if (empty($fechaEntrada) || empty($horaEntrada) || empty($idTipoReserva) || empty($numeroVuelo)||empty($aeropuertoOrigen)||empty($hotel)||empty($numViajeros)||empty($emailCliente) ) {
        echo "Todos los campos obligatorios deben estar completos";
        exit;
    }
    try {
        $db = new database();         
        $conn = $db->getConn();  
        
        $checkEmail = $conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
        $checkEmail->bindParam(':email', $emailCliente);
        $checkEmail->execute();

        if ($checkEmail->rowCount() === 0) {
            
            $insertEmail = $conn->prepare("INSERT INTO transfer_viajeros (email) VALUES (:email)");
            $insertEmail->bindParam(':email', $emailCliente);
            $insertEmail->execute();
        }

        $vehiculoQuery = $conn->query("SELECT id_vehiculo FROM transfer_vehiculo ORDER BY RAND() LIMIT 1");
        $idVehiculo = $vehiculoQuery->fetchColumn();

        $fechaReserva = date('Y-m-d H:i:s'); 

        $localizador = random_int(100000, 999999);

        $sql = "INSERT INTO transfer_reservas 
        (localizador, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, id_tipo_reserva, id_hotel, num_viajeros, email_cliente, id_vehiculo, fecha_reserva)
        VALUES 
        (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_entrada, :origen_vuelo_entrada, :id_tipo_reserva, :id_hotel, :num_viajeros, :email_cliente, :id_vehiculo, :fecha_reserva)";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':localizador', $localizador);
        $stmt->bindParam(':fecha_entrada', $fechaEntrada);
        $stmt->bindParam(':hora_entrada', $horaEntrada);
        $stmt->bindParam(':numero_vuelo_entrada', $numeroVuelo);
        $stmt->bindParam(':origen_vuelo_entrada',$aeropuertoOrigen);
        $stmt->bindParam(':id_hotel', $hotel);
        $stmt->bindParam(':num_viajeros', $numViajeros);
        $stmt->bindParam(':email_cliente',$emailCliente);
        $stmt->bindParam(':id_tipo_reserva', $idTipoReserva);
        $stmt->bindParam(':fecha_reserva', $fechaReserva);
        $stmt->bindParam(':id_vehiculo', $idVehiculo);
        $stmt->execute();

            echo "Reserva creada con éxito. Localizador: $localizador";
        } catch (PDOException $e) {
            echo "Error al insertar: " . $e->getMessage();
        }
    } else {
        echo "Método no permitido.";
    }
        