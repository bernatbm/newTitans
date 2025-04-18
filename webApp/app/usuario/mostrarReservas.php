<?php
session_start();

require_once '../model/database.php';

if (!isset($_SESSION['userName']) || $_SESSION['isAdmin'] != 0) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}


try {
    $db = new database();
    $conn = $db->getConn();

    $userName_usuario = $_SESSION['userName'];
    $sql_email = "SELECT email FROM transfer_viajeros WHERE nombre = :nombre";
    $stmt_email = $conn->prepare($sql_email);
    $stmt_email->bindParam(':nombre', $userName_usuario);
    $stmt_email->execute();
    $email_usuario = $stmt_email->fetchColumn();


    $sql = "SELECT r.*, t.`Descripción` AS tipo_reserva_desc
        FROM transfer_reservas r
        LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
        WHERE r.email_cliente = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email_usuario);
    $stmt->execute();
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (!$reservas) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Sin Reservas</title>
            <link rel="stylesheet" href="../css/panelUsuario.css?v=<?php echo time(); ?>">
        </head>
        <body>
            <div class="mensaje-vacio">
                <h2>❌ No se han encontrado reservas</h2>
                <p>Actualmente no tienes ninguna reserva registrada.</p>
                <a href="perfilUsuario.php" class="btn-volver">⬅ Volver al panel</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }

} catch (PDOException $e) {
    echo "❌ Error al obtener los datos: " . $e->getMessage();
    exit;
}
$etiquetas = [
    'id_reserva' => 'Número de reserva',
    'localizador' => 'Localizador',
    'id_hotel' => 'ID Hotel',
    'id_tipo_reserva' => 'Tipo de reserva (ID)',
    'tipo_reserva_desc' => 'Tipo de reserva', // <-- Descripción
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
    'id_vehiculo' => 'ID Vehículo',
    'numero_vuelo_salida' => 'Número de vuelo (vuelta)',
    'hora_recogida' => 'Hora de recogida'
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Reserva</title>
    <link rel="stylesheet" href="../css/panelUsuario.css">
</head>
<body>
<section class="pa-detalle-reserva">
    <h2 class="pa-h2">Detalles de la Reserva</h2>
    <div class="tarjetas-container">
    <?php foreach ($reservas as $reserva): ?>
        <div class="tarjeta">
            <?php foreach ($etiquetas as $campo => $etiqueta): ?>
                <?php if (!is_null($reserva[$campo])): ?>
                    <p><strong><?= $etiqueta ?>:</strong> <?= htmlspecialchars($reserva[$campo]) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
            <a href="editarReservas.php?id=<?= $reserva['id_reserva'] ?>" class="btn-reserva btn-editar">Editar</a>
            <a href="borrarReservas.php?id=<?= $reserva['id_reserva'] ?>" class="btn-reserva btn-borrar" onclick="return confirm('¿Seguro que quieres borrar esta reserva?')">Borrar</a>
        </div>
    <?php endforeach; ?>
    </div>
    <a href="perfilUsuario.php" class="btn-volver">⬅ Volver al panel</a>
</section>

</body>
</html>
<?php