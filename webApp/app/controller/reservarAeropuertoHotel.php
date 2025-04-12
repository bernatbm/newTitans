<?php
require_once '../model/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fechaEntrada = $_POST['fecha_llegada'] ?? null;
    $horaEntrada = $_POST['hora_llegada'] ?? null;
    $numeroVuelo = $_POST['numero_vuelo_entrada'] ?? null;
    $aeropuertoOrigen = $_POST ['aeropuerto_origen'] ?? null;
    $idTipoReserva = $_POST['id_tipo_reserva'] ?? null;



    if (empty($fechaEntrada) || empty($horaEntrada) || empty($idTipoReserva) || empty($numeroVuelo)||empty($aeropuertoOrigen) ) {
        echo "Todos los campos obligatorios deben estar completos";
        exit;
    }
    try {
        $db = new database();         
        $conn = $db->getConn();  

        $localizador = random_int(100000, 999999);

        $sql = "INSERT INTO transfer_reservas 
        (localizador, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, id_tipo_reserva)
        VALUES 
        (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_entrada, :origen_vuelo_entrada, :id_tipo_reserva)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':localizador', $localizador);
        $stmt->bindParam(':fecha_entrada', $fechaEntrada);
        $stmt->bindParam(':hora_entrada', $horaEntrada);
        $stmt->bindParam(':numero_vuelo_entrada', $numeroVuelo);
        $stmt->bindParam(':origen_vuelo_entrada',$aeropuertoOrigen);
        $stmt->bindParam(':id_tipo_reserva', $idTipoReserva);
        $stmt->execute();

            echo "Reserva creada con éxito. Localizador: $localizador";
        } catch (PDOException $e) {
            echo "Error al insertar: " . $e->getMessage();
        }
    } else {
        echo "Método no permitido.";
    }
        