<?php
session_start();

require_once '../model/database.php';

if (!isset($_GET['id'])) {
    echo "❌ ID de reserva no especificado.";
    exit;
}

$id = $_GET['id'];

try {
    $db = new database();
    $conn = $db->getConn();

    $sql = "SELECT r.*, email_cliente AS email_usuario
    FROM transfer_reservas r
    LEFT JOIN transfer_hotel h ON r.id_hotel = h.id_hotel
    LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
    WHERE r.id_reserva = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        echo "❌ No se encontró la reserva.";
        exit;
    }
} catch (PDOException $e) {
    echo "❌ Error al obtener los datos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Reserva</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="pa-detalle-reserva">
    <h2 class="pa-h2">Detalles de la Reserva</h2>
    <ul>
        <?php
            $etiquetas = [
                'id_reserva' => 'Número de reserva',
                'localizador' => 'Localizador',
                'nombre_hotel' => 'Hotel',
                'tipo_reserva' => 'Tipo de reserva',
                'email_cliente' => 'Email del cliente',
                'fecha_reserva' => 'Fecha de reserva',
                'fecha_modificacion' => 'Fecha de modificación',
                'id_destino' => 'Destino',
                'fecha_entrada' => 'Fecha de entrada',
                'hora_entrada' => 'Hora de entrada',
                'numero_vuelo_entrada' => 'Número de vuelo (ida)',
                'origen_vuelo_entrada' => 'Origen del vuelo',
                'hora_vuelo_salida' => 'Hora del vuelo de salida',
                'fecha_vuelo_salida' => 'Fecha del vuelo de salida',
                'num_viajeros' => 'Número de viajeros',
                'numero_vuelo_salida' => 'Número de vuelo (vuelta)',
                'hora_recogida' => 'Hora de recogida',
                
            ];

            foreach ($reserva as $campo => $valor):
                if (!isset($etiquetas[$campo])) continue;
            ?>
                <li><strong><?= $etiquetas[$campo] ?>:</strong> <?= htmlspecialchars($valor ?? '—') ?></li>
            <?php endforeach; ?>
    </ul>

    <a href="panelUsuario.php" class="btn-volver">⬅ Volver al panel</a>
</section>

</body>
</html>
<?php