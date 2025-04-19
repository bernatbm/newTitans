<?php
require_once '../model/database.php';
require_once '../model/hotelModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new HotelModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $nombre = $_POST['nombre_hotel'] ?? '';
        $zona = $_POST['id_zona'] ?? '';
        $comision = isset($_POST['comision']) && $_POST['comision'] !== '' 
                    ? (int)$_POST['comision'] 
                    : 0; // Valor por defecto
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $model->agregarHotel($nombre, $zona, $comision, $usuario, $password);
    } elseif (isset($_POST['editar'])) {
        $id = $_POST['id_hotel'] ?? '';
        $nombre = $_POST['nombre_hotel'] ?? '';
        $zona = $_POST['id_zona'] ?? '';
        $comision = isset($_POST['comision']) && $_POST['comision'] !== '' 
                    ? (int)$_POST['comision'] 
                    : 0; // Valor por defecto
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $model->actualizarHotel($id, $nombre, $zona, $comision, $usuario, $password);
    }
    header("Location: ../view/hotelView.php");
    exit;
}

// Eliminar (vía GET)
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $id = $_GET['id_hotel'] ?? '';
    $model->eliminarHotel($id);
    header("Location: ../view/hotelView.php");
    exit;
}

?>
