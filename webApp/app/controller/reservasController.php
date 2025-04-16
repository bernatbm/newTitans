<?php
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
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tipoReserva = $_POST['id_tipo_reserva'] ?? null;

            if ($tipoReserva == '1') {
                $this->model->addAeropuertoHotel();
            } elseif ($tipoReserva == '2') {
                $this->model->addHotelaeropuerto();
            } else {
                $this->model->addIdaVuelta();
            }
        } else {
            echo "Método no permitido.";
        }
    }

    public function verReserva($id) {
        $reserva = $this->model->obtenerReservaPorId($id);
        if (!$reserva) {
            echo "❌ No se encontró la reserva.";
            exit;
        }
        require_once '../view/verReserva.php';
    }

    public function listarReservas() {
        $reservas = $this->model->obtenerTodasLasReservas();
        require_once '../view/listarReservasView.php';
    }
}


$controller = new ReservasController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->procesarReserva();
} else {
    $accion = $_GET['accion'] ?? '';
    switch ($accion) {
        case 'listar':
            $controller->listarReservas();
            break;

        default:
            echo "Acción no válida";
    }
}
