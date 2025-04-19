<?php
require_once '../controller/reservasController.php';

$controller = new ReservasController();
$controller->obtenerUltimasReservas($limite = 5);