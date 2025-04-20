<?php
require_once '../model/database.php';
require_once '../model/zoneModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new ZoneModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $descripcion = $_POST['descripcion'];
        $model->agregarZona($descripcion);
    } elseif (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $model->actualizarZona($id, $descripcion);
    }
    header("Location: ../view/zoneView.php");
    exit;
}

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $model->eliminarZona($_GET['id']);
    header("Location: ../view/zoneView.php");
    exit;
}

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    try {
        $model->eliminarZona($_GET['id']);
        header("Location: ../view/zoneView.php?mensaje=eliminado");
    } catch (PDOException $e) {
        header("Location: ../view/zoneView.php?error=no_se_puede_eliminar");
    }
    exit;
}