<?php
session_start();
// Verificamos que el usuario esté logueado y sea administrador
if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']) != 1) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}

require_once '../model/database.php'; 
require_once '../model/airportModel.php';

class AirportController {
    private $model;
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConn();
        $this->model = new AirportModel($this->conn);
    }

    public function agregarAeropuerto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aeropuerto'])) {
            $aeropuerto = trim($_POST['aeropuerto']);
            if (!empty($aeropuerto)) {
                $this->model->insertarAeropuerto($aeropuerto);
                header("Location: ../view/airportView.php?exito=true");
                exit;
            }
        }
    }
    public function editarAeropuerto($id, $aeropuerto) {
        $aeropuerto = trim($aeropuerto);
        if (!empty($aeropuerto)) {
            $this->model->actualizarAeropuerto($id, $aeropuerto);
            header("Location: ../view/airportView.php?editado=true");
            exit;
        }
    }
    

    public function eliminarAeropuerto($id) {
        $this->model->eliminarAeropuerto($id);
        header("Location: ../view/airportView.php?borrado=true");
        exit;
    }

    public function obtenerAeropuertosPanel() {
        $aeropuertos = $this->model->obtenerPrimerosCincoAeropuertos();
        include '../admin/panelAdministrador.php'; // Pasa los datos a la vista
    }
}

$controller = new AirportController();

if (isset($_GET['accion'])) {
    if ($_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
        $controller->eliminarAeropuerto($_GET['id']);
    } elseif ($_GET['accion'] === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id']) && isset($_POST['aeropuerto'])) {
            $controller->editarAeropuerto($_POST['id'], $_POST['aeropuerto']);
        }
    }
} else {
    $controller->agregarAeropuerto();
}

