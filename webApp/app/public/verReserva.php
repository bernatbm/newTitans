<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

<?php
// public/verReserva.php

require_once '../controller/reservasController.php';

if (!isset($_GET['id'])) {
    echo "❌ ID de reserva no especificado.";
    exit;
}

$id = $_GET['id'];

$reservasController = new ReservasController();
$reservasController->verReserva($id);
?>
