<?php
session_start();

require_once '../model/database.php';
require_once '../model/reservasModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new ReservasModel($conn);

$id = $_GET['id'] ?? null; // Obtener el ID de la reserva desde la URL
$reserva = $model->obtenerReservaPorId($id); // Obtener la reserva

if ($reserva === null) {
    echo "❌ Reserva no encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva #<?= htmlspecialchars($reserva['id_reserva']) ?></title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
</head>
<body>
     <!-- Encabezado -->
     <?php include '../shared/header.php'; ?>
    <!---FIN ENCABEZADO-->

<form class="form-h2-airport" method="POST" action="../controller/reservasController.php">
    <h2>Editar Reserva #<?= htmlspecialchars($reserva['id_reserva']) ?></h2>
    
    <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">

    <!-- Campo no editable para el localizador -->
    <label>Localizador (no editable):</label>
    <input type="text" disabled value="<?= htmlspecialchars($reserva['localizador']) ?>" required>

    <?php
    $excluir = ['id_reserva', 'localizador'];
    foreach ($reserva as $campo => $valor):
        if (in_array($campo, $excluir)) continue;

        $tipo = 'text';
        if (str_contains($campo, 'fecha')) $tipo = 'date';
        if (str_contains($campo, 'hora')) $tipo = 'time';
    ?>
        <label for="<?= $campo ?>"><?= ucfirst(str_replace('_', ' ', $campo)) ?>:</label>
        <input type="<?= $tipo ?>" name="<?= $campo ?>" id="<?= $campo ?>" value="<?= htmlspecialchars($valor ?? '') ?>" required>
    <?php endforeach; ?>

    <div class="optionbuttons">
        <div class="left">
            <a href="../admin/panelAdministrador.php" class="btn-volver">⬅ Volver al panel</a>
        </div>
        <div class="right">
            <button type="submit">Actualizar</button>
        </div>
    </div>
</form>

</body>
</html>
