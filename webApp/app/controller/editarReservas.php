<?php
require_once '../model/database.php';

if (!isset($_GET['id'])) {
    echo "❌ ID no especificado.";
    exit;
}

$id = $_GET['id'];

$db = new database();
$conn = $db->getConn();

$stmt = $conn->prepare("SELECT *, fecha_reserva FROM transfer_reservas WHERE id_reserva = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    echo "❌ Reserva no encontrada.";
    exit;
}

$fechaReserva = new DateTime($reserva['fecha_reserva']);
$fechaHoy = new DateTime();
$diferencia = $fechaHoy->diff($fechaReserva);
$dias = $diferencia->days;

if ($dias < 2) {
    echo "<p style='color: red;'>❌ No puedes editar esta reserva hasta que pasen 2 días desde la fecha de creación.</p>";
    echo "<a href='../controller/reservasUsuarioController.php'>Volver a mis reservas</a>";
    exit;
}


// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Función para sanitizar fechas y enteros
    function sanitizarCampo($valor, $esFecha = false, $esEntero = false) {
        if ($esFecha) {
            return ($valor === '' || $valor === null) ? null : $valor;
        }
        if ($esEntero) {
            return ($valor === '' || $valor === null) ? null : (int)$valor;
        }
        return $valor;
    }

    // Sanitizar todos los campos
    $datos = [
        ':id_hotel' => sanitizarCampo($_POST['id_hotel'], false, true),
        ':id_tipo_reserva' => sanitizarCampo($_POST['id_tipo_reserva'], false, true),
        ':email_cliente' => $_POST['email_cliente'],
        ':id_destino' => sanitizarCampo($_POST['id_destino'], false, true),
        ':fecha_entrada' => sanitizarCampo($_POST['fecha_entrada'], true),
        ':hora_entrada' => $_POST['hora_entrada'],
        ':numero_vuelo_entrada' => $_POST['numero_vuelo_entrada'],
        ':origen_vuelo_entrada' => $_POST['origen_vuelo_entrada'],
        ':hora_vuelo_salida' => $_POST['hora_vuelo_salida'],
        ':fecha_vuelo_salida' => sanitizarCampo($_POST['fecha_vuelo_salida'], true),
        ':num_viajeros' => sanitizarCampo($_POST['num_viajeros'], false, true),
        ':id_vehiculo' => sanitizarCampo($_POST['id_vehiculo'], false, true),
        ':numero_vuelo_salida' => $_POST['numero_vuelo_salida'],
        ':hora_recogida' => $_POST['hora_recogida'],
        ':id' => $id
    ];

    $sql = "UPDATE transfer_reservas SET
        id_hotel = :id_hotel,
        id_tipo_reserva = :id_tipo_reserva,
        email_cliente = :email_cliente,
        id_destino = :id_destino,
        fecha_entrada = :fecha_entrada,
        hora_entrada = :hora_entrada,
        numero_vuelo_entrada = :numero_vuelo_entrada,
        origen_vuelo_entrada = :origen_vuelo_entrada,
        hora_vuelo_salida = :hora_vuelo_salida,
        fecha_vuelo_salida = :fecha_vuelo_salida,
        num_viajeros = :num_viajeros,
        id_vehiculo = :id_vehiculo,
        numero_vuelo_salida = :numero_vuelo_salida,
        hora_recogida = :hora_recogida
        WHERE id_reserva = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute($datos);

    header("Location: ../controller/reservasUsuarioController.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="pa-h2">Editar Reserva #<?= $reserva['id_reserva'] ?></h2>
<form method="POST" class="pa-form" style="max-width: 700px; margin: auto;">

    <label>Localizador (no editable):</label>
    <input type="text" disabled value="<?= htmlspecialchars($reserva['localizador']) ?>" style="width:100%; padding: 8px; margin-bottom: 10px; background-color: #eee;" />

    <?php
    $excluir = ['id_reserva', 'localizador', 'fecha_reserva', 'fecha_modificacion'];
    foreach ($reserva as $campo => $valor):
        if (in_array($campo, $excluir)) continue;

        // tipo de input
        $tipo = 'text';
        if (str_contains($campo, 'fecha')) $tipo = 'date';
        if (str_contains($campo, 'hora')) $tipo = 'time';
    ?>
        <label><?= ucfirst(str_replace('_', ' ', $campo)) ?>:</label>
        <input type="<?= $tipo ?>" name="<?= $campo ?>" value="<?= htmlspecialchars($valor ?? '') ?>" style="width:100%; padding: 8px; margin-bottom: 10px;" />
    <?php endforeach; ?>

    <button type="submit" class="pa-ida-vuelta-button">Guardar Cambios</button>
    <a href="../usuario/perfilUsuario.php" class="btn-cancelar">Cancelar</a>
    </form>

</body>
</html>
