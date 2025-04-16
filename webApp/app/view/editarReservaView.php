<?php
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
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
</head>
<body>

<h2 class="pa-h2">Editar Reserva #<?= htmlspecialchars($reserva['id_reserva']) ?></h2>

<!-- Formulario para editar la reserva -->
<form action="../controller/reservasController.php" method="POST" class="pa-form" style="max-width: 700px; margin: auto;">
    <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">
    <label>Localizador (no editable):</label>
    <input type="text" disabled value="<?= htmlspecialchars($reserva['localizador']) ?>" style="width:100%; padding: 8px; margin-bottom: 10px; background-color: #eee;" />

    <?php
    // Campos a excluir del formulario
    $excluir = ['id_reserva', 'localizador'];
    
    // Iterar sobre todos los campos de la reserva
    foreach ($reserva as $campo => $valor):
        if (in_array($campo, $excluir)) continue;

        // Determinar el tipo de input según el nombre del campo
        $tipo = 'text';
        if (str_contains($campo, 'fecha')) $tipo = 'date';
        if (str_contains($campo, 'hora')) $tipo = 'time';
    ?>
        <label for="<?= $campo ?>"><?= ucfirst(str_replace('_', ' ', $campo)) ?>:</label>
        <input type="<?= $tipo ?>" name="<?= $campo ?>" id="<?= $campo ?>" value="<?= htmlspecialchars($valor ?? '') ?>" style="width:100%; padding: 8px; margin-bottom: 10px;" />
    <?php endforeach; ?>

    <!-- Botón para enviar el formulario -->
    <button type="submit" class="pa-ida-vuelta-button">Guardar Cambios</button>
</form>

</body>
</html>
