<?php
require_once '../model/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $db = new database();
        $conn = $db->getConn();

        // Eliminar la reserva
        $stmt = $conn->prepare("DELETE FROM transfer_reservas WHERE id_reserva = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Redirigir de nuevo al panel
        header("Location: ../admin/panelAdministrador.php?mensaje=eliminado");
        exit;
    } catch (PDOException $e) {
        echo "❌ Error al borrar la reserva: " . $e->getMessage();
    }
} else {
    echo "❌ ID no especificado.";
}