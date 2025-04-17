<?php
session_start();

// Verificación de acceso
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}

require_once '../model/database.php';
require_once '../model/hotelModel.php';

class HotelController {
    private $model;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConn();
        $this->model = new HotelModel($conn);
    }

    // Agregar un nuevo hotel
    public function agregarHotel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['id_hotel'])) {  // Solo agregar si NO existe id_hotel
            // Sanitizar y validar los datos de entrada
            $nombre_hotel = htmlspecialchars($_POST['nombre_hotel']);
            $id_zona = filter_var($_POST['id_zona'], FILTER_SANITIZE_NUMBER_INT);

            // Si 'comision' es un campo opcional, lo tratamos como tal
            $comision = isset($_POST['comision']) ? filter_var($_POST['comision'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0.0;
            $usuario = htmlspecialchars($_POST['usuario']);
            $password = htmlspecialchars($_POST['password']);

            // Validación simple
            if (empty($nombre_hotel) || empty($usuario) || empty($password)) {
                header("Location: ../view/hotelView.php?error=campos_vacios");
                exit;
            }

            // Insertar hotel en la base de datos
            $this->model->insertarHotel($nombre_hotel, $id_zona, $comision, $usuario, $password);
            header("Location: ../view/hotelView.php?exito=true");
            exit;
        }
    }

    // Eliminar un hotel
    public function eliminar($id) {
        if (!empty($id)) {
            $this->model->eliminarHotel($id);
            header("Location: ../view/hotelView.php?borrado=true");
        } else {
            header("Location: ../view/hotelView.php?error=hotel_no_encontrado");
        }
        exit;
    }

    // Editar hotel
    public function editar($id, $datos) {
        $hotel = trim($datos);
        if (!empty($$hotel)) {
            $this->model->actualizarHotel($id, $hotel);
            header("Location: ../view/hotelView.php?editado=true");
            exit; 
    }
}
}
// Inicialización del controlador
$controller = new HotelController();

// Procesar acciones dependiendo de los parámetros en la URL o método POST
if (isset($_GET['accion'])) {
    if ($_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
        $controller->eliminar($_GET['id']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_hotel']) && !empty($_POST['id_hotel'])) {
        // Si existe el id_hotel, es una edición
        $controller->editar($_POST['id_hotel'], $_POST);
    } else {
        // Si no existe id_hotel, es un nuevo registro
        $controller->agregarHotel();
    }
}
