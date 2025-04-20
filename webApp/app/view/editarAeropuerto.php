<?php
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}
require_once '../model/database.php';
require_once '../model/airportModel.php';
include '../shared/header.php';
$db = new Database();
$conn = $db->getConn();
$model = new AirportModel($conn);

$id = $_GET['id'] ?? null;
$aeropuerto = $model->obtenerAeropuertoPorId($id);

if (!$id) {
    header("Location: airportView.php?error=id_faltante");
    exit;
}

$aeropuerto = $model->obtenerAeropuertoPorId($id);

if (!$aeropuerto) {
    header("Location: airportView.php?error=no_encontrado");
    exit;
}

?>


<form class="form-h2-airport"method="POST" action="../controller/airportController.php?accion=editar">
    <h2>Editar Aeropuerto</h2>
    <input type="hidden" name="id" value="<?= $aeropuerto['id_destino'] ?>">
    <input type="text" name="aeropuerto" value="<?= htmlspecialchars($aeropuerto['aeropuerto']) ?>" required>
    <div class="optionbuttons">
    <div class="left">
    <a href="../view/airportView.php" class="btn-volver">⬅ Volver al panel</a>
    </div>
    <div class="right">
    <button type="submit">Actualizar</button>
        
    </div>
</div>
</form>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">