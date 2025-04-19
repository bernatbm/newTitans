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
$vehiculos = $model->obtenerVehicles();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>

<?php include '../shared/header.php'; ?>

<!-- Formulario para añadir vehículo -->
<form class="form-h2-airport" method="POST" action="../controller/vehicleController.php">
    <h2 class="pa-h2-airport">Agregar Vehículo</h2>
    <input type="hidden" name="crear" value="1">

    <label class="name-airport">Descripción:</label>
    <input class="input-name" type="text" name="descripcion" required>

    <label class="name-airport">Email del conductor:</label>
    <input class="input-name" type="email" name="email_conductor" required>

    <label class="name-airport">Contraseña:</label>
    <input class="input-name" type="password" name="password" required>

    <button type="submit" class="btn-reserva">➕ Añadir Vehículo</button>
</form>

<div class="form-list">
    <section class="pa-lista-reservas">
        <h2 class="pa-h2-lista">Listado de Vehículos</h2>
        <div class="tabla-wrapper" style="overflow-x:auto;">
            <table class="pa-tabla-reservas">
                <thead>
                    <tr style="background:#f3c158;">
                        <th style="padding: 8px;">ID</th>
                        <th style="padding: 8px;">Descripción</th>
                        <th style="padding: 8px;">Email Conductor</th>
                        <th style="padding: 8px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <tr class="pa-casillas-reservas"style="color:white">
                            <td data-label="ID"style="text-align:center;"><?= $vehiculo['id_vehiculo'] ?></td>
                            <td data-label="VEHICULO"style="text-align:center;"><?= htmlspecialchars($vehiculo['Descripción'] ?? '') ?></td>
                            <td data-label="EMAIL CONDUCTOR" style="text-align:center;"><?= htmlspecialchars($vehiculo['email_conductor']) ?></td>
                            <td style="text-align:center">
                                <a class="btn-reserva btn-editar" href="editarVehiculo.php?id_vehiculo=<?= $vehiculo['id_vehiculo'] ?>">Editar</a>
                                <a class="btn-reserva btn-borrar" href="../controller/vehicleController.php?accion=eliminar&id_vehiculo=<?= $vehiculo['id_vehiculo'] ?>" onclick="return confirm('¿Eliminar este vehículo?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

