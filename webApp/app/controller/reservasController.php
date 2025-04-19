<?php
session_start();
require_once '../model/database.php';
require_once '../model/reservasModel.php';

class ReservasController {

    private $model;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConn();
        $this->model = new ReservasModel($conn);
    }

    public function procesarReserva() {
        try {
            $tipoReserva = $_POST['id_tipo_reserva'] ?? null;
            $localizador = null;

            if ($tipoReserva == '1') {
                $localizador = $this->model->addAeropuertoHotel();
            } elseif ($tipoReserva == '2') {
                $localizador = $this->model->addHotelAeropuerto();
            } else {
                $localizador = $this->model->addIdaVuelta();
            }

            // Redirección según rol
            $redirectUrl = ($_SESSION['isAdmin'] == 1) 
                ? "../admin/panelAdministrador.php?reservado=ok&localizador=$localizador" 
                : "../usuario/perfilUsuario.php?reservado=ok&localizador=$localizador";
            
            header("Location: $redirectUrl");
            exit;

        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage();
        }
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
            $id = (int)$_GET['id'];
            if ($this->model->deleteReserva($id)) {
                $redirectUrl = ($_SESSION['isAdmin'] == 1) 
                    ? "../admin/panelAdministrador.php?mensaje=eliminado" 
                    : "../usuario/perfilUsuario.php?mensaje=eliminado";
                
                header("Location: $redirectUrl");
                exit;
            }
        }
        echo "❌ ID de reserva no válido.";
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

