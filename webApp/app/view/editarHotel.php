<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: login.php?error=acceso_denegado");
    exit;
}

require_once '../model/database.php';
require_once '../model/hotelModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new HotelModel($conn);

if (!isset($_GET['id_hotel'])) {
    header("Location: hotelView.php?error=falta_id");
    exit;
}

$hotel = $model->obtenerHotelPorId($_GET['id_hotel']);
if (!$hotel) {
    header("Location: hotelView.php?error=no_encontrado");
    exit;
}

// Obtener todas las zonas para el select
$zonas = [];
$stmt = $conn->query("SELECT id_zona, descripcion FROM transfer_zona");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $zonas[] = $row;
}
?>

<?php include '../shared/header.php'; ?>
<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

<div class="form-list">
    <form class="form-h2-airport" method="POST" action="../controller/hotelController.php">
        <h2 class="pa-h2-airport">Editar Hotel</h2>
        <input type="hidden" name="editar" value="1">
        <input type="hidden" name="id_hotel" value="<?= htmlspecialchars($hotel['id_hotel']) ?>">

        <div class="form-group">
            <label class="name-airport">Nombre del hotel:</label>
            <input class="input-name" type="text" name="nombre_hotel" 
                value="<?= htmlspecialchars($hotel['nombre_hotel']) ?>" required>
        </div>

        <div class="form-group">
            <label class="name-airport">Zona:</label>
            <select class="input-name" name="id_zona" required>
                <?php foreach ($zonas as $zona): ?>
                <option value="<?= htmlspecialchars($zona['id_zona']) ?>" 
                    <?= ($zona['id_zona'] == $hotel['id_zona']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($zona['descripcion']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="name-airport">Comisión:</label>
            <input class="input-name" type="number" name="comision"
                value="<?= htmlspecialchars($hotel['Comision'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label class="name-airport">Usuario:</label>
            <input class="input-name" type="text" name="usuario" 
                value="<?= htmlspecialchars($hotel['usuario']) ?>" required>
        </div>

        <div class="form-group">
            <label class="name-airport">Password:</label>
            <input class="input-name" type="password" name="password" 
                value="<?= htmlspecialchars($hotel['password']) ?>" required>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-reserva">💾 Guardar Cambios</button>
            <a href="hotelView.php" class="btn-reserva btn-cancelar">↩️ Cancelar</a>
        </div>
    </form>
</div>