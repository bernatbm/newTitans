<?php
// public/verReserva.php
require_once '../controller/ReservaController.php';

if (!isset($_GET['id'])) {
    echo "❌ ID de reserva no especificado.";
    exit;
}

$id = $_GET['id'];

$reservasController = new ReservaController();
$reservasController->verReserva($id);
?>