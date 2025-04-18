<?php
session_start();
require_once '../model/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id']; // Cast por seguridad

    try {
        $db = new database();
        $conn = $db->getConn();

        // 1. Obtener la fecha de reserva
        $stmt = $conn->prepare("SELECT fecha_reserva FROM transfer_reservas WHERE id_reserva = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reserva) {
            echo "<p style='color: red;'>❌ Reserva no encontrada.</p>";
            exit;
        }

        $fechaReserva = new DateTime($reserva['fecha_reserva']);
        $fechaHoy = new DateTime();
        $diferencia = $fechaHoy->diff($fechaReserva);
        $dias = $diferencia->days;

        // 2. Verificar si han pasado más de 2 días
        if ($dias >= 2) {
            // Eliminar la reserva por ID
            $stmt = $conn->prepare("DELETE FROM transfer_reservas WHERE id_reserva = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

        } else {
            echo "<p style='color: red;'>❌ No puedes borrar esta reserva hasta que pasen 2 días desde la fecha de creación.</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>❌ Error al borrar la reserva: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ ID de reserva no válido.</p>";
}
?>
