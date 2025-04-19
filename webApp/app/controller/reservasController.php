<?php
require_once '../model/database.php';
require_once '../model/reservasModel.php';
require_once __DIR__ . '/enviarMail.php';

class ReservasController {

    private $model;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConn();
        $this->model = new ReservasModel($conn);
    }

    public function procesarReserva() {
        $datos = $_POST;
        $emailCliente = $datos['email_cliente'];
    
        if (!empty($datos['id_reserva'])) {
            // Actualizar reserva
            $this->model->actualizarReserva($datos['id_reserva'], $datos);
            $id = $datos['id_reserva'];
            header("Location: ../public/verReserva.php?id=" . $id . "&mensaje=Reserva%20Actualizada");
            exit;
        } else {
            //añadir reserva segun tipo
            $tipoReserva = $datos['id_tipo_reserva'] ?? null;
    
            if ($tipoReserva == '1') {
                $this->model->addAeropuertoHotel();
            } elseif ($tipoReserva == '2') {
                $this->model->addHotelAeropuerto();
            } else {
                $this->model->addIdaVuelta();
            }
            enviarCorreoReserva($emailCliente, $datos);
        }
        header("Location: ../admin/panelAdministrador.php");
        exit;
    }

    public function verReserva($id) {
       
        $reserva = $this->model->obtenerReservaPorId($id);
    
        if ($reserva) {
            require '../view/verReservaView.php';
        } else {
            echo "❌ Reserva no encontrada.";
        }
    }
    
    

    public function listarReservas() {
        
        $reservas = $this->model->obtenerTodasLasReservas();
        require_once '../view/listarReservasView.php';
    }
    //Creo que se puede deletear.
    public function updateReservas($id, $datos) {
        if (!$id || empty($datos)) {
            echo "ID o datos de reserva no proporcionados.";
            exit;
        }
    
        $resultado = $this->model->actualizarReserva($id, $datos);
    
       
        header("Location: ../public/verReserva.php?id=" . $id . "&mensaje=Reserva%20Actualizada");
        exit;
    }
    public function eliminarReserva() {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = (int) $_GET['id'];
            $this->model->deleteReserva($id);
        } else {
            echo "<p style='color: red;'>❌ ID de reserva no válido.</p>";
        }
    }
    
        
        
}


 $controller = new ReservasController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->procesarReserva();
} 
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'eliminar') {
        $controller->eliminarReserva();
    }
}
  
