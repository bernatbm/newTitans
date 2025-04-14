<?php
require_once '../model/database.php';

$db = new database();
$conn = $db->getConn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_reserva'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $hora_entrada = $_POST['hora_entrada'];
    $num_viajeros = $_POST['num_viajeros'];

    $sql = "UPDATE transfer_reservas 
            SET fecha_entrada = :fecha_entrada, 
                hora_entrada = :hora_entrada, 
                num_viajeros = :num_viajeros,
                fecha_modificacion = NOW()
            WHERE id_reserva = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fecha_entrada', $fecha_entrada);
    $stmt->bindParam(':hora_entrada', $hora_entrada);
    $stmt->bindParam(':num_viajeros', $num_viajeros);
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    header("Location: ../view/panelAdministrador.php?mensaje=editado");
    exit;
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM transfer_reservas WHERE id_reserva = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "❌ ID no especificado.";
    exit;
}
?>