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
            // Recoger datos del formulario
            $nombre_hotel = $_POST['nombre_hotel'];
            $id_zona = $_POST['id_zona'];
            $comision = isset($_POST['Comision']) && $_POST['Comision'] !== '' ? $_POST['Comision'] : 10; // Asignar valor por defecto si no se ha enviado
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            
            

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
        // Asegúrate de aplicar trim a los valores específicos del array
        $nombre_hotel = isset($datos['nombre_hotel']) ? trim($datos['nombre_hotel']) : null;
        $id_zona = isset($datos['id_zona']) ? trim($datos['id_zona']) : null;
        $comision = isset($datos['comision']) ? trim($datos['comision']) : null;
        $usuario = isset($datos['usuario']) ? trim($datos['usuario']) : null;
        $password = isset($datos['password']) ? trim($datos['password']) : null;
    
        // Crear el array con los datos que vamos a actualizar
        $datos = [
            'nombre_hotel' => $nombre_hotel,
            'id_zona' => $id_zona,
            'comision' => $comision,
            'usuario' => $usuario,
            'password' => $password
        ];
    
        // Llamar a la función actualizarHotel con el array de datos
        $this->model->actualizarHotel($id, $datos);
    
        // Redirigir después de la actualización
        header("Location: ../view/hotelView.php?editado=true");
        exit;
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
