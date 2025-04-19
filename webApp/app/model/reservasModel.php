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
                    (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, isAdmin)
                    VALUES 
                    (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, :ciudad, :pais, :email, :password, 0)
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
            $diaVuelo = $_POST['dia_vuelo'] ?? null;
            $horaVuelo = $_POST['hora_vuelo'] ?? null;
            $numeroVuelo = $_POST['numero_vuelo_vuelta'] ?? null;
            $horaRecogida = $_POST['hora_recogida'] ?? null;
            $hotel = $_POST['id_hotel'] ?? null;
            $aeropuertoDestino = $_POST['id_destino'] ?? null;
            $numViajeros = $_POST['num_viajeros'] ?? null;
            $emailCliente = $_POST['email_cliente'] ?? null;
            $idTipoReserva = $_POST['id_tipo_reserva'] ?? null;
        
            if (
                empty($diaVuelo) || empty($horaVuelo) || empty($numeroVuelo) || empty($horaRecogida) ||
                empty($hotel) || empty($aeropuertoDestino) || empty($numViajeros) || empty($emailCliente) || empty($idTipoReserva)
            ) {
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
                    (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, isAdmin)
                    VALUES 
                    (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, :ciudad, :pais, :email, :password, 0)
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
                (localizador, fecha_entrada, hora_entrada, numero_vuelo_salida, hora_vuelo_salida, fecha_vuelo_salida, 
                hora_recogida, id_tipo_reserva, id_hotel, id_destino, num_viajeros, email_cliente, id_vehiculo, fecha_reserva)
                VALUES 
                (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_salida, :hora_vuelo_salida, :fecha_vuelo_salida, 
                :hora_recogida, :id_tipo_reserva, :id_hotel, :id_destino, :num_viajeros, :email_cliente, :id_vehiculo, :fecha_reserva)";
        
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':localizador', $localizador);
                $stmt->bindParam(':fecha_entrada', $diaVuelo);
                $stmt->bindParam(':hora_entrada', $horaRecogida);
                $stmt->bindParam(':numero_vuelo_salida', $numeroVuelo);
                $stmt->bindParam(':hora_vuelo_salida', $horaVuelo);
                $stmt->bindParam(':fecha_vuelo_salida', $diaVuelo);
                $stmt->bindParam(':hora_recogida', $horaRecogida);
                $stmt->bindParam(':id_tipo_reserva', $idTipoReserva);
                $stmt->bindParam(':id_hotel', $hotel);
                $stmt->bindParam(':id_destino', $aeropuertoDestino);
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
                        (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, isAdmin)
                        VALUES 
                        (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, :ciudad, :pais, :email, :password, 0)
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
        try {
          
    
            $sql = "SELECT r.*, h.nombre_hotel, t.Descripción AS tipo_reserva
                    FROM transfer_reservas r
                    LEFT JOIN transfer_hotel h ON r.id_hotel = h.id_hotel
                    LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
                    WHERE r.id_reserva = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
    
           
    
            return $reserva ?: null;
    
        } catch (PDOException $e) {
            echo "❌ Error al obtener los datos: " . $e->getMessage();
            return null;
        }
    }
    
    
    public function obtenerTodasLasReservas() {
        try {
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
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reservas;
    } catch (PDOException $e) {
        echo "<p>Error al obtener reservas: " . $e->getMessage() . "</p>";
        exit;
    }

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
        
            function valor($clave, $datos, $reserva) {
                if (array_key_exists($clave, $datos)) {
                    return $datos[$clave] === '' ? null : $datos[$clave];
                }
                return $reserva[$clave];
            }
            
        
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
        
            $data = [
                ':id_hotel' => valor('id_hotel', $datos, $reserva),
                ':id_tipo_reserva' => valor('id_tipo_reserva', $datos, $reserva),
                ':email_cliente' => valor('email_cliente', $datos, $reserva),
                ':fecha_reserva' => valor('fecha_reserva', $datos, $reserva),
                ':id_destino' => valor('id_destino', $datos, $reserva),
                ':fecha_entrada' => valor('fecha_entrada', $datos, $reserva) ?: null,
                ':hora_entrada' => valor('hora_entrada', $datos, $reserva),
                ':numero_vuelo_entrada' => valor('numero_vuelo_entrada', $datos, $reserva),
                ':origen_vuelo_entrada' => valor('origen_vuelo_entrada', $datos, $reserva),
                ':hora_vuelo_salida' => valor('hora_vuelo_salida', $datos, $reserva),
                ':fecha_vuelo_salida' => valor('fecha_vuelo_salida', $datos, $reserva) ?: null,
                ':num_viajeros' => valor('num_viajeros', $datos, $reserva),
                ':id_vehiculo' => valor('id_vehiculo', $datos, $reserva),
                ':numero_vuelo_salida' => valor('numero_vuelo_salida', $datos, $reserva),
                ':hora_recogida' => valor('hora_recogida', $datos, $reserva),
                ':id' => $id
            ];
        
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
        }
    public function deleteReserva($id){
        try {
            $stmt = $this->conn->prepare("DELETE FROM transfer_reservas WHERE id_reserva = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Redirección tras eliminar
            header("Location: ../admin/panelAdministrador.php?mensaje=eliminado");
            exit;
        } catch (PDOException $e) {
            echo "<p style='color: red;'>❌ Error al borrar la reserva: " . $e->getMessage() . "</p>";
        }
    }
        
}    
?>
