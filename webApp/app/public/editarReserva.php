<?php// Suponiendo que se pasa el ID de la reserva por URL
if (isset($_GET['id'])) {
    $controller->verReserva($_GET['id']);
}
?>