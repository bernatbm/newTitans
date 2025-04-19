<?php
class HotelModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todos los hoteles
    public function obtenerHoteles() {
            $stmt = $this->conn->query("
                SELECT h.*, z.descripcion 
                FROM transfer_hotel h
                JOIN transfer_zona z ON h.id_zona = z.id_zona
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    

    // Insertar un nuevo hotel
    public function insertarHotel($nombre, $zona, $comision, $usuario, $password) {
        $comision = isset($comision) ? $comision : 10;

        $stmt = $this->conn->prepare(
            "INSERT INTO transfer_hotel (nombre_hotel, id_zona, Comision, usuario, password) 
            VALUES (:nombre_hotel, :id_zona, :Comision, :usuario, :password)"
        );

        // Usando parámetros con nombre para mayor claridad
        $stmt->bindParam(':nombre_hotel', $nombre);
        $stmt->bindParam(':id_zona', $zona);
        $stmt->bindParam(':Comision', $comision);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception('Error al insertar el hotel.');
        }
    }

    // Eliminar un hotel
    public function eliminarHotel($id) {
        $stmt = $this->conn->prepare("DELETE FROM transfer_hotel WHERE id_hotel = :id_hotel");
        $stmt->bindParam(':id_hotel', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception('Error al eliminar el hotel.');
        }
    }

    // Obtener un hotel por su ID
    public function obtenerHotelPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM transfer_hotel WHERE id_hotel = :id_hotel");
        $stmt->bindParam(':id_hotel', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar los datos de un hotel
    public function actualizarHotel($id, $datos) {
        // Obtener los datos actuales del hotel
        $stmt = $this->conn->prepare("SELECT * FROM transfer_hotel WHERE id_hotel = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$hotel) {
            return false;
        }
        // Actualizar con los valores del array de datos
        $nombre_hotel = isset($datos['nombre_hotel']) ? $datos['nombre_hotel'] : $hotel['nombre_hotel'];
        $id_zona = isset($datos['id_zona']) ? $datos['id_zona'] : $hotel['id_zona'];
        $comision = isset($datos['comision']) ? $datos['comision'] : $hotel['comision'];
        $usuario = isset($datos['usuario']) ? $datos['usuario'] : $hotel['usuario'];
        $password = isset($datos['password']) ? $datos['password'] : $hotel['password'];

    
        // Fallback a los valores actuales si no se envían datos nuevos
        function valor($clave, $datos, $hotel) {
            return array_key_exists($clave, $datos)
                ? ($datos[$clave] !== '' ? $datos[$clave] : $hotel[$clave])
                : $hotel[$clave];
        }
    
        // Actualizar la base de datos con los nuevos valores
        $stmt = $this->conn->prepare("UPDATE transfer_hotel SET nombre_hotel = :nombre_hotel, id_zona = :id_zona, comision = :comision, usuario = :usuario, password = :password WHERE id_hotel = :id");
        $stmt->bindParam(':nombre_hotel', $nombre_hotel);
        $stmt->bindParam(':id_zona', $id_zona);
        $stmt->bindParam(':comision', $comision);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $id);

        // Ejecutar la actualización
        return $stmt->execute();
        }
   
    
}
?>
