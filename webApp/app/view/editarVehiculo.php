<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: login.php?error=acceso_denegado");
    exit;
}

require_once '../model/database.php';
require_once '../model/vehicleModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new VehicleModel($conn);

if (!isset($_GET['id_vehiculo'])) {
    header("Location: vehicleView.php");
    exit;
}
$vehicle = $model->obtenerVehiclePerId($_GET['id_vehiculo']);


$vehicle = $model->obtenerVehiclePerId($_GET['id_vehiculo']);
if (!$vehicle) {
    header("Location: vehicleView.php?error=no_encontrado");
    exit;
}
?>

<?php include '../shared/header.php'; ?>
<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

<div class="form-list">
    
    <form class="form-h2-airport" method="POST" action="../controller/vehicleController.php">
    <h2 class="pa-h2-airport">Editar Vehiculo</h2>
        <input type="hidden" name="editar" value="1">
        <input type="hidden" name="id_vehiculo" value="<?= $vehicle['id_vehiculo'] ?>">

        <label class="name-airport">Descripción:</label>
        <input class="input-name" type="text" name="descripcion" value="<?= htmlspecialchars($vehicle['Descripción'] ?? '') ?>" required>

        <label class="name-airport">Email Conductor:</label>
        <input class="input-email" type="email" name="email_conductor" value="<?= htmlspecialchars($vehicle['email_conductor'] ?? '') ?>" required>

        <label class="name-airport">Password:</label>
        <input class="input-name" type="password" name="password" value="<?= htmlspecialchars($vehicle['password'] ?? '') ?>" required>

        <button type="submit" class="btn-reserva">💾 Guardar Cambios</button>
        <a href="vehicleView.php" class="btn-reserva btn-cancelar">↩️ Cancelar</a>
    </form>
</div>