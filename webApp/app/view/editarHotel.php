<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: login.php?error=acceso_denegado");
    exit;
}
require_once '../model/database.php';
require_once '../model/hotelModel.php';

if (!isset($_GET['id'])) {
    header("Location: hotelView.php?error=falta_id");
    exit;
}

$db = new Database();
$conn = $db->getConn();
$model = new HotelModel($conn);

$hotel = $model->obtenerHotelPorId($_GET['id']);
if (!$hotel) {
    header("Location: hotelView.php?error=no_encontrado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hotel</title>
     <!-- Encabezado -->
  <?php include '../shared/header.php'; ?>
    <!---FIN ENCABEZADO-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

</head>
<body>
    <h2>Editar Hotel</h2>
    <form class="form-h2-airport"method="POST" action="../controller/hotelController.php?accion=editar">
        <input type="hidden" name="id" value="<?= $hotel['id_hotel'] ?>">
        <input type="hidden" name="editar">

        <label>Nombre del Hotel:</label>
        <input type="text" name="nombre_hotel" value="<?= htmlspecialchars($hotel['nombre_hotel']) ?>" required><br>

        <label>ID Zona:</label>
        <input type="number" name="id_zona" value="<?= $hotel['id_zona'] ?>" required><br>

        <label>Comisión:</label>
        <input type="text" name="Comision" value="<?= $hotel['Comision'] ?>" required><br>

        <label>Usuario:</label>
        <input type="text" name="usuario" value="<?= htmlspecialchars($hotel['usuario']) ?>" required><br>

        <label>Password:</label>
        <input type="password" name="password" value="<?= $hotel['password'] ?>" required><br>

        <div class="optionbuttons">
            <a href="hotelView.php" class="btn-volver">⬅ Volver al panel</a>
            <button type="submit">Actualizar</button>
        </div>
    </form>
</body>
</html>
