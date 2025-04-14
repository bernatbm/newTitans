<?php
require_once '../model/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id']; // Cast por seguridad

    try {
        $db = new database();
        $conn = $db->getConn();

        // Eliminar la reserva por ID
        $stmt = $conn->prepare("DELETE FROM transfer_reservas WHERE id_reserva = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige con mensaje
        header("Location: ../admin/panelAdministrador.php?mensaje=eliminado");
        exit;
    } catch (PDOException $e) {
        echo "<p style='color: red;'>❌ Error al borrar la reserva: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ ID de reserva no válido.</p>";
}
?>