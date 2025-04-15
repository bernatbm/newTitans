<?php
require_once '../model/database.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fechaEntrada = $_POST['fecha_llegada'] ?? null;
    $horaEntrada = $_POST['hora_llegada'] ?? null;
    $numeroVuelo = $_POST['numero_vuelo_entrada'] ?? null;
    $aeropuertoOrigen = $_POST['aeropuerto_origen'] ?? null;
    $hotel = $_POST['id_hotel'] ?? null;
    $numViajeros = $_POST['num_viajeros'] ?? null;
    $emailCliente = $_POST['email_cliente'] ?? null;
    $idTipoReserva = $_POST['id_tipo_reserva'] ?? null;

    if (
        empty($fechaEntrada) || empty($horaEntrada) || empty($idTipoReserva) ||
        empty($numeroVuelo) || empty($aeropuertoOrigen) || empty($hotel) ||
        empty($numViajeros) || empty($emailCliente)
    ) {
        echo "Todos los campos obligatorios deben estar completos.";
        exit;
    }

    try {
        $db = new database();
        $conn = $db->getConn();

        // Verificar si el email ya está en la base de datos
        $checkEmail = $conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
        $checkEmail->bindParam(':email', $emailCliente);
        $checkEmail->execute();

        // Si no existe, insertamos los datos personales
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
                echo "⚠️ Faltan datos personales. Por favor, completa todos los campos.";
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

        // Seleccionar un vehículo aleatorio
        $vehiculoQuery = $conn->query("SELECT id_vehiculo FROM transfer_vehiculo ORDER BY RAND() LIMIT 1");
        $idVehiculo = $vehiculoQuery->fetchColumn();

        // Fecha actual
        $fechaReserva = date('Y-m-d H:i:s');

        // Localizador aleatorio
        $localizador = random_int(100000, 999999);

        // Insertar la reserva
        $sql = "INSERT INTO transfer_reservas 
            (localizador, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, 
            id_tipo_reserva, id_hotel, num_viajeros, email_cliente, id_vehiculo, fecha_reserva)
            VALUES 
            (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_entrada, :origen_vuelo_entrada, 
            :id_tipo_reserva, :id_hotel, :num_viajeros, :email_cliente, :id_vehiculo, :fecha_reserva)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':localizador', $localizador);
        $stmt->bindParam(':fecha_entrada', $fechaEntrada);
        $stmt->bindParam(':hora_entrada', $horaEntrada);
        $stmt->bindParam(':numero_vuelo_entrada', $numeroVuelo);
        $stmt->bindParam(':origen_vuelo_entrada', $aeropuertoOrigen);
        $stmt->bindParam(':id_tipo_reserva', $idTipoReserva);
        $stmt->bindParam(':id_hotel', $hotel);
        $stmt->bindParam(':num_viajeros', $numViajeros);
        $stmt->bindParam(':email_cliente', $emailCliente);
        $stmt->bindParam(':id_vehiculo', $idVehiculo);
        $stmt->bindParam(':fecha_reserva', $fechaReserva);
        $stmt->execute();
        

        header("Location: ../admin/panelAdministrador.php?reservado=reserva&localizador=$localizador");
        exit();

        
    } catch (PDOException $e) {
        echo "Error al insertar: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}
?>
