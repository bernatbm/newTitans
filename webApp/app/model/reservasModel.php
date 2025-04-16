<?php
class ReservasModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    
    public function addAeropuertoHotel () {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fechaEntrada = $_POST['fecha_llegada'] ?? null;
            $horaEntrada = $_POST['hora_llegada'] ?? null;
            $numeroVuelo = $_POST['numero_vuelo_entrada'] ?? null;
            $aeropuertoOrigen = $_POST['id_destino'] ?? null;
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
        }

        try {
            // Verificar si el email ya está en la base de datos
            $checkEmail = $this->conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
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

                $insertViajero = $this->conn->prepare("
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

          
            $localizador = $this->generarLocalizador();
            $idVehiculo = $this->seleccionarVehiculoAleatorio();
            $fechaReserva = $this->fechaReservada();
            

            $sql = "INSERT INTO transfer_reservas 
                    (localizador, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, 
                    id_tipo_reserva, id_hotel, num_viajeros, email_cliente, id_vehiculo, fecha_reserva)
                    VALUES 
                    (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_entrada, :origen_vuelo_entrada, 
                    :id_tipo_reserva, :id_hotel, :num_viajeros, :email_cliente, :id_vehiculo, :fecha_reserva)";

            $stmt = $this->conn->prepare($sql);
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

            $this->redirigirConLocalizador($localizador);


        } catch (PDOException $e) {
            echo "❌ Error al procesar la reserva: " . $e->getMessage();
        }
    }


    // Función para seleccionar un vehículo aleatorio
    public function seleccionarVehiculoAleatorio() {
        $vehiculoQuery = $this->conn->query("SELECT id_vehiculo FROM transfer_vehiculo ORDER BY RAND() LIMIT 1");
        return $vehiculoQuery->fetchColumn();
    }

    // Función para generar un localizador
    public function generarLocalizador() {
        return random_int(100000, 999999);
    }

    public function fechaReservada(){
        $fechaReserva = date('Y-m-d H:i:s');
        return $fechaReserva;
    }

    // Función para redirigir con el localizador
    public function redirigirConLocalizador($localizador) {
        header("Location: ../admin/panelAdministrador.php?reservado=reserva&localizador=$localizador");
        exit();
    }

    // Función para insertar reserva solo de ida
    public function addHotelAeropuerto() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fechaEntrada = $_POST['fecha_llegada'] ?? null;
            $horaEntrada = $_POST['hora_llegada'] ?? null;
            $numeroVuelo = $_POST['numero_vuelo_entrada'] ?? null;
            $aeropuertoOrigen = $_POST['id_destino'] ?? null;
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
                
                // Verificar si el email ya está en la base de datos
                $checkEmail =$this->conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
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
        
                    $insertViajero = $this->conn->prepare("
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
        
                
                $localizador = $this->generarLocalizador();
                $idVehiculo = $this->seleccionarVehiculoAleatorio();
                $fechaReserva = $this->fechaReservada();
        
                // Insertar la reserva
                $sql = "INSERT INTO transfer_reservas 
                    (localizador, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, 
                    id_tipo_reserva, id_hotel, num_viajeros, email_cliente, id_vehiculo, fecha_reserva)
                    VALUES 
                    (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_entrada, :origen_vuelo_entrada, 
                    :id_tipo_reserva, :id_hotel, :num_viajeros, :email_cliente, :id_vehiculo, :fecha_reserva)";
        
                $stmt = $this->conn->prepare($sql);
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
                
        
                $this->redirigirConLocalizador($localizador);
        
                
            } catch (PDOException $e) {
                echo "Error al insertar: " . $e->getMessage();
            }
        } else {
            echo "Método no permitido.";
        }
    }
    // Función para insertar reserva de vuelta
    public function addIdaVuelta() {

        if ($_SERVER["REQUEST_METHOD"]==="POST"){
            $fechaEntrada = $_POST ['fecha_llegada']?? null;
            $horaEntrada = $_POST ['hora_llegada']?? null;
            $numeroVueloEntrada= $_POST['numero_vuelo_entrada']??null;
            $aeropuertoOrigen = $_POST['id_destino'] ?? null;
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
                
                $checkEmail = $this->conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
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
        
                    $insertViajero = $this->conn->prepare("
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
                $localizador = $this->generarLocalizador();
                $idVehiculo = $this->seleccionarVehiculoAleatorio();
                $fechaReserva = $this->fechaReservada();
        
                $sql= "INSERT INTO transfer_reservas
                (localizador,fecha_entrada,hora_entrada,numero_vuelo_entrada, origen_vuelo_entrada, id_hotel,id_vehiculo,fecha_reserva,
                num_viajeros,fecha_vuelo_salida,hora_vuelo_salida,numero_vuelo_salida,hora_recogida,id_destino,email_cliente,id_tipo_reserva)
                VALUES (:localizador,:fecha_entrada,:hora_entrada,:numero_vuelo_entrada,:origen_vuelo_entrada,:id_hotel,:id_vehiculo,:fecha_reserva,
                :num_viajeros,:fecha_vuelo_salida,:hora_vuelo_salida,:numero_vuelo_salida,:hora_recogida,:id_destino,:email_cliente, :id_tipo_reserva)";
        
                $stmt = $this->conn->prepare($sql);
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
        
                $this->redirigirConLocalizador($localizador);
            }catch (PDOException $e){
                echo "Error al insertar: " . $e->getMessage();
            }
        }else{
            echo "Método no permitido.";
        }
        
    }
    public function obtenerReservaPorId($id) {
        $sql = "SELECT r.*, h.nombre_hotel, t.Descripción AS tipo_reserva
                FROM transfer_reservas r
                LEFT JOIN transfer_hotel h ON r.id_hotel = h.id_hotel
                LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
                WHERE r.id_reserva = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
    public function obtenerTodasLasReservas() {
        $sql = "SELECT 
                    r.id_reserva, 
                    r.localizador, 
                    h.nombre_hotel, 
                    t.Descripción AS tipo_reserva,
                    r.email_cliente, 
                    r.fecha_reserva, 
                    r.fecha_modificacion
                FROM transfer_reservas r
                LEFT JOIN transfer_hotel h ON r.id_hotel = h.id_hotel
                LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
                ORDER BY r.fecha_reserva DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }
    public function actualizarReserva($id, $datos) {
        // Obtener los datos actuales de la reserva
        $stmt = $this->conn->prepare("SELECT * FROM transfer_reservas WHERE id_reserva = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reserva) {
            return false; 
        }

        // Preparamos los datos, usando los valores antiguos si no hay nuevos
        $data = [
            ':id_hotel' => $datos['id_hotel'] !== '' ? $datos['id_hotel'] : $reserva['id_hotel'],
            ':id_tipo_reserva' => $datos['id_tipo_reserva'] !== '' ? $datos['id_tipo_reserva'] : $reserva['id_tipo_reserva'],
            ':email_cliente' => $datos['email_cliente'] !== '' ? $datos['email_cliente'] : $reserva['email_cliente'],
            ':fecha_reserva' => $datos['fecha_reserva'] !== '' ? $datos['fecha_reserva'] : $reserva['fecha_reserva'],
            ':id_destino' => $datos['id_destino'] !== '' ? $datos['id_destino'] : $reserva['id_destino'],
            ':fecha_entrada' => $datos['fecha_entrada'] !== '' ? $datos['fecha_entrada'] : $reserva['fecha_entrada'],
            ':hora_entrada' => $datos['hora_entrada'] !== '' ? $datos['hora_entrada'] : $reserva['hora_entrada'],
            ':numero_vuelo_entrada' => $datos['numero_vuelo_entrada'] !== '' ? $datos['numero_vuelo_entrada'] : $reserva['numero_vuelo_entrada'],
            ':origen_vuelo_entrada' => $datos['origen_vuelo_entrada'] !== '' ? $datos['origen_vuelo_entrada'] : $reserva['origen_vuelo_entrada'],
            ':hora_vuelo_salida' => $datos['hora_vuelo_salida'] !== '' ? $datos['hora_vuelo_salida'] : $reserva['hora_vuelo_salida'],
            ':fecha_vuelo_salida' => $datos['fecha_vuelo_salida'] !== '' ? $datos['fecha_vuelo_salida'] : $reserva['fecha_vuelo_salida'],
            ':num_viajeros' => $datos['num_viajeros'] !== '' ? $datos['num_viajeros'] : $reserva['num_viajeros'],
            ':id_vehiculo' => $datos['id_vehiculo'] !== '' ? $datos['id_vehiculo'] : $reserva['id_vehiculo'],
            ':numero_vuelo_salida' => $datos['numero_vuelo_salida'] !== '' ? $datos['numero_vuelo_salida'] : $reserva['numero_vuelo_salida'],
            ':hora_recogida' => $datos['hora_recogida'] !== '' ? $datos['hora_recogida'] : $reserva['hora_recogida'],
            ':id' => $id
        ];

        // Preparar la consulta para actualizar los datos
        $sql = "UPDATE transfer_reservas SET
            id_hotel = :id_hotel,
            id_tipo_reserva = :id_tipo_reserva,
            email_cliente = :email_cliente,
            fecha_reserva = :fecha_reserva,
            fecha_modificacion = NOW(),
            id_destino = :id_destino,
            fecha_entrada = :fecha_entrada,
            hora_entrada = :hora_entrada,
            numero_vuelo_entrada = :numero_vuelo_entrada,
            origen_vuelo_entrada = :origen_vuelo_entrada,
            hora_vuelo_salida = :hora_vuelo_salida,
            fecha_vuelo_salida = :fecha_vuelo_salida,
            num_viajeros = :num_viajeros,
            id_vehiculo = :id_vehiculo,
            numero_vuelo_salida = :numero_vuelo_salida,
            hora_recogida = :hora_recogida
            WHERE id_reserva = :id";

        // Ejecutar la actualización
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data); // Devuelve true o false
    }
}
?>
