<?php
require_once '../model/database.php';

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    $fechaEntrada = $_POST ['fecha_llegada']?? null;
    $horaEntrada = $_POST ['hora_llegada']?? null;
    $numeroVueloEntrada= $_POST['numero_vuelo_entrada']??null;
    $aeropuertoOrigen = $_POST['aeropuerto_origen'] ?? null;
    $hotel = $_POST['id_hotel'] ?? null;
    $numViajeros = $_POST['num_viajeros'] ?? null;
    $diaVuelo = $_POST['dia_vuelo'] ?? null;
    $horaVuelo = $_POST['hora_vuelo'] ?? null;
    $numeroVueloVuelta = $_POST['numero_vuelo_vuelta'] ?? null;
    $horaRecogida = $_POST['hora_recogida'] ?? null;
    $aeropuertoDestino = $_POST['id_destino'] ?? null;
    $emailCliente = $_POST['email_cliente'] ?? null;
    $idTipoReserva = $_POST['id_tipo_reserva'] ?? null;

    if(
        empty($fechaEntrada) || empty($horaEntrada) || empty($numeroVueloEntrada) || 
        empty($aeropuertoOrigen) || empty($hotel) ||  empty($numViajeros) ||  empty($diaVuelo)|| 
        empty($horaVuelo) || empty($numeroVueloVuelta) || empty($horaRecogida) || empty($aeropuertoDestino)|| 
        empty($emailCliente) || empty($idTipoReserva)
    ){
        echo "Todos los campos obligatorios deben estar completos.";
        exit;
    }
    try {
        $db = new database();
        $conn = $db->getConn();

        $checkEmail = $conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
        $checkEmail->bindParam(':email', $emailCliente);
        $checkEmail->execute();

        if ($checkEmail->rowCount() === 0) {
            $nombre = $_POST['nombre'] ?? null;
            $apellido1 = $_POST['apellido1'] ?? null;
            $apellido2 = $_POST['apellido2'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $codigoPostal = $_POST['codigoPostal'] ?? null;
            $ciudad = $_POST['ciudad'] ?? null;
            $pais = $_POST['pais'] ?? null;
            $password = $_POST['password'] ?? null;

            if (
                empty($nombre) || empty($apellido1) || empty($apellido2) ||
                empty($direccion) || empty($codigoPostal) || empty($ciudad) ||
                empty($pais) || empty($password)
            ) {
                echo "Faltan datos personales. Por favor, completa todos los campos.";
                exit;
            }

            $insertViajero = $conn->prepare("
                INSERT INTO transfer_viajeros 
                (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password)
                VALUES 
                (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, :ciudad, :pais, :email, :password)
            ");
            $insertViajero->bindParam(':nombre', $nombre);
            $insertViajero->bindParam(':apellido1', $apellido1);
            $insertViajero->bindParam(':apellido2', $apellido2);
            $insertViajero->bindParam(':direccion', $direccion);
            $insertViajero->bindParam(':codigoPostal', $codigoPostal);
            $insertViajero->bindParam(':ciudad', $ciudad);
            $insertViajero->bindParam(':pais', $pais);
            $insertViajero->bindParam(':email', $emailCliente);
            $insertViajero->bindParam(':password', $password);
            $insertViajero->execute();
        }
        $vehiculoQuery = $conn->query("SELECT id_vehiculo FROM transfer_vehiculo ORDER BY RAND() LIMIT 1");
        $idVehiculo = $vehiculoQuery->fetchColumn();

        $fechaReserva = date('Y-m-d H:i:s');
        $localizador = random_int(100000, 999999);

        $sql= "INSERT INTO transfer_reservas
        (localizador,fecha_entrada,hora_entrada,numero_vuelo_entrada, origen_vuelo_entrada, id_hotel,id_vehiculo,fecha_reserva,
        num_viajeros,fecha_vuelo_salida,hora_vuelo_salida,numero_vuelo_salida,hora_recogida,id_destino,email_cliente,id_tipo_reserva)
        VALUES (:localizador,:fecha_entrada,:hora_entrada,:numero_vuelo_entrada,:origen_vuelo_entrada,:id_hotel,:id_vehiculo,:fecha_reserva,
        :num_viajeros,:fecha_vuelo_salida,:hora_vuelo_salida,:numero_vuelo_salida,:hora_recogida,:id_destino,:email_cliente, :id_tipo_reserva)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':localizador',$localizador);
        $stmt->bindParam(':fecha_entrada',$fechaEntrada);
        $stmt->bindParam(':hora_entrada', $horaEntrada);
        $stmt->bindParam(':numero_vuelo_entrada', $numeroVueloEntrada);
        $stmt->bindParam(':origen_vuelo_entrada', $aeropuertoOrigen);
        $stmt->bindParam(':id_hotel', $hotel);
        $stmt->bindParam(':id_vehiculo', $idVehiculo);
        $stmt->bindParam(':fecha_reserva', $fechaReserva);
        $stmt->bindParam(':num_viajeros', $numViajeros);
        $stmt->bindParam(':fecha_vuelo_salida', $diaVuelo);
        $stmt->bindParam(':hora_vuelo_salida', $horaVuelo);
        $stmt->bindParam(':numero_vuelo_salida', $numeroVueloVuelta);
        $stmt->bindParam(':hora_recogida', $horaRecogida);
        $stmt->bindParam(':id_destino', $aeropuertoDestino);
        $stmt->bindParam(':email_cliente', $emailCliente);
        $stmt->bindParam(':id_tipo_reserva', $idTipoReserva);
        $stmt->execute();

        echo "Reserva creada con éxito. Localizador: $localizador";
    }catch (PDOException $e){
        echo "Error al insertar: " . $e->getMessage();
    }
}else{
    echo "Método no permitido.";
}