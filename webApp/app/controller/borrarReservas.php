<?php
session_start();
require_once '../model/database.php';

if (!isset($_SESSION['userName']) || $_SESSION['isAdmin'] != 0) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $db = new database();
        $conn = $db->getConn();

        // 1. Obtener la fecha de reserva
        $stmt = $conn->prepare("SELECT fecha_reserva FROM transfer_reservas WHERE id_reserva = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reserva) {
            header("Location: ../controller/reservasUsuarioController.php?error=reserva_no_encontrada");
            exit;
        }

        $fechaReserva = new DateTime($reserva['fecha_reserva']);
        $fechaHoy = new DateTime();
        $diferencia = $fechaHoy->diff($fechaReserva);
        $dias = $diferencia->days;

        // 2. Verificar si han pasado más de 2 días
        if ($dias >= 2) {
            // Eliminar la reserva
            $stmt = $conn->prepare("DELETE FROM transfer_reservas WHERE id_reserva = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: ../controller/reservasUsuarioController.php?borrado=1");
            exit;
        } else {
            header("Location: ../controller/reservasUsuarioController.php?error=no_puede_borrar");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: ../controller/reservasUsuarioController.php?error=error_borrar");
        exit;
    }
} else {
    header("Location: ../controller/reservasUsuarioController.php?error=id_invalido");
    exit;
}
?>
