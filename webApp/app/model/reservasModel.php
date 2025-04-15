<?php
class ReservasModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Función para insertar un viajero si no existe en la base de datos
    public function insertarViajeroSiNoExiste($emailCliente, $datosPersonales) {
        $checkEmail = $this->conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
        $checkEmail->bindParam(':email', $emailCliente);
        $checkEmail->execute();

        if ($checkEmail->rowCount() === 0) {
            extract($datosPersonales);

            if (in_array(null, [$nombre, $apellido1, $apellido2, $direccion, $codigoPostal, $ciudad, $pais, $password], true)) {
                throw new Exception("⚠️ Faltan datos personales. Por favor, completa todos los campos.");
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

    // Función para redirigir con el localizador
    public function redirigirConLocalizador($localizador) {
        header("Location: ../admin/panelAdministrador.php?reservado=reserva&localizador=$localizador");
        exit();
    }

    // Función para insertar reserva solo de ida
    public function insertarReservaIda($comunes, $post) {
        $sql = "INSERT INTO transfer_reservas 
            (localizador, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, 
            id_tipo_reserva, id_hotel, num_viajeros, email_cliente, id_vehiculo, fecha_reserva)
            VALUES 
            (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_entrada, :origen_vuelo_entrada, 
            :id_tipo_reserva, :id_hotel, :num_viajeros, :email_cliente, :id_vehiculo, :fecha_reserva)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array_merge($comunes, [
            ':numero_vuelo_entrada' => $post['numero_vuelo_entrada'] ?? null,
            ':origen_vuelo_entrada' => $post['aeropuerto_origen'] ?? null
        ]));
    }

    // Función para insertar reserva de vuelta
    public function insertarReservaVuelta($comunes, $post) {
        $sql = "INSERT INTO transfer_reservas 
            (localizador, fecha_entrada, hora_entrada, numero_vuelo_salida, hora_vuelo_salida, fecha_vuelo_salida, 
            hora_recogida, id_tipo_reserva, id_hotel, id_destino, num_viajeros, email_cliente, id_vehiculo, fecha_reserva)
            VALUES 
            (:localizador, :fecha_entrada, :hora_entrada, :numero_vuelo_salida, :hora_vuelo_salida, :fecha_vuelo_salida, 
            :hora_recogida, :id_tipo_reserva, :id_hotel, :id_destino, :num_viajeros, :email_cliente, :id_vehiculo, :fecha_reserva)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array_merge($comunes, [
            ':numero_vuelo_salida' => $post['numero_vuelo_vuelta'] ?? null,
            ':hora_vuelo_salida' => $post['hora_vuelo'] ?? null,
            ':fecha_vuelo_salida' => $post['dia_vuelo'] ?? null,
            ':hora_recogida' => $post['hora_recogida'] ?? null,
            ':id_destino' => $post['id_destino'] ?? null
        ]));
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
    
}
