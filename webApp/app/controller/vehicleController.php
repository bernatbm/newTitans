<?php
require_once '../model/database.php';
require_once '../model/vehicleModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new VehicleModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $descripcion = $_POST['descripcion'];
        $email_conductor = $_POST['email_conductor'];
        $password = $_POST['password'];
        $model->agregarVehicle($descripcion, $email_conductor, $password);
    } elseif (isset($_POST['editar'])) {
        $id = $_POST['id_vehiculo'];
        $descripcion = $_POST['descripcion'];
        $email_conductor = $_POST['email_conductor'];
        $password = $_POST['password'];
        $model->actualizarVehicle($id, $descripcion, $email_conductor, $password);
    }
    header("Location: ../view/vehicleView.php");
    exit;
}

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $model->eliminarVehicle($_GET['id_vehiculo']);
    header("Location: ../view/vehicleView.php");
    exit;
}
?>