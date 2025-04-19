<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: login.php?error=acceso_denegado");
    exit;
}

require_once '../model/database.php';
require_once '../model/zoneModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new ZoneModel($conn);
$zonas = $model->obtenerZonas();
if (!isset($_GET['id'])) {
    header("Location: zoneView.php");
    exit;
}

$zona = $model->obtenerZonaPorId($_GET['id']);
if (!$zona) {
    header("Location: zoneView.php?error=no_encontrado");
    exit;
}
?>

<?php include '../shared/header.php'; ?>
<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

<div class="form-list">
    
    <form class="form-h2-airport" method="POST" action="../controller/zoneController.php">
    <h2 class="pa-h2-airport">Editar Zona</h2>
        <input type="hidden" name="editar" value="1">
        <input type="hidden" name="id" value="<?= $zona['id_zona'] ?>">

        <label class="name-airport">Descripción:</label>
        <select class="input-name" name="descripcion" required>
            <?php foreach ($zonas as $zonaOption): ?>
                <option value="<?= $zonaOption['id_zona'] ?>" 
                        <?= ($zonaOption['id_zona'] == $zona['id_zona']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($zonaOption['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-reserva">💾 Guardar Cambios</button>
        <a href="zoneView.php" class="btn-reserva btn-cancelar">↩️ Cancelar</a>
    </form>
</div>
