<?php
session_start();

require_once '../model/database.php';
require_once '../model/reservasModel.php';
require_once '../model/vehicleModel.php'; 
require_once '../model/airportModel.php'; 

$db = new Database();
$conn = $db->getConn();
$model = new ReservasModel($conn);
$vehiculoModel = new VehicleModel($conn);
$aeropuertoModel = new AirportModel($conn);


$id = $_GET['id'] ?? null; // Obtener el ID de la reserva desde la URL
$reserva = $model->obtenerReservaPorId($id); // Obtener la reserva

if ($reserva === null) {
    echo "❌ Reserva no encontrada."; 
    exit;
}
$vehiculo = $vehiculoModel->obtenerVehiclePerId($reserva['id_vehiculo']);
var_dump($vehiculo);
$aeropuerto = $aeropuertoModel->obtenerAeropuertoPorId($reserva['id_destino']);

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
    <input type="text" disabled value="<?= htmlspecialchars($reserva['localizador']) ?>" required><br>

    <?php
    $excluir = ['id_reserva', 'localizador'];
    foreach ($reserva as $campo => $valor):
        if (in_array($campo, $excluir)) continue;
    
        $tipo = 'text';
        if (str_contains($campo, 'fecha')) $tipo = 'date';
        if (str_contains($campo, 'hora')) $tipo = 'time';
    
        // Formatear fecha si es necesario
        if ($tipo === 'date' && !empty($valor)) {
            $valor = substr($valor, 0, 10); // De "YYYY-MM-DD HH:MM:SS" a "YYYY-MM-DD"
        }
    
        // Solo poner required si el campo ya tiene valor
        $esRequerido = !is_null($valor) && $valor !== '' ? 'required' : '';
    ?>
         <label for="<?= $campo ?>"><?= ucfirst(str_replace('_', ' ', $campo)) ?>:</label><br>
         <input type="<?= $tipo ?>" name="<?= $campo ?>" id="<?= $campo ?>" value="<?= htmlspecialchars($valor ?? '') ?>" <?= $esRequerido ?>><br>
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
