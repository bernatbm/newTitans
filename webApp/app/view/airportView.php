<?php 
session_start();
require_once '../model/database.php';
require_once '../model/airportModel.php';

$db = new Database();
$conn = $db->getConn();
$model = new AirportModel($conn);

// Obtener todos los aeropuertos
$aeropuertos = $model->obtenerAeropuertos();


// Verificamos que el usuario esté logueado y sea administrador
if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']) != 1) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}
if (isset($_GET['exito'])): ?>
    <script>alert("Aeropuerto añadido correctamente.");</script>
<?php endif; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>

  <!-- Encabezado -->
  <?php include '../shared/header.php'; ?>
    <!---FIN ENCABEZADO-->



<form class= "form-h2-airport" method="POST" action="../controller/airportController.php">
<h2 class="pa-h2-airport">Agregar Aeropuerto</h2>
    <label class="name-airport">Nombre del aeropuerto:</label>
    <input class="input-name" type="text" name="aeropuerto" required>
    <button type="submit">Añadir Aeropuerto</button>
</form>


<div class="form-list">
    <section class="pa-lista-reservas">
        <h2 class="pa-h2-lista">Listado de Aeropuertos</h2>
        <div class="tabla-wrapper" style="overflow-x:auto;">
            <table class="pa-tabla-reservas" style="width:100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead>
                    <tr style="background:#f3c158;">
                        <th style="padding: 8px; border: 1px solid #ddd;">ID</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Aeropuerto</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($aeropuertos)): ?>
                        <?php foreach ($aeropuertos as $aero): ?>
                            <tr class="pa-casillas-reservas" style="color:white">
                                <td data-label="ID" style="text-align:center"><?= htmlspecialchars($aero['id_destino']) ?></td>
                                <td data-label="Aeropuerto" style="text-align:center"><?= htmlspecialchars($aero['aeropuerto']) ?></td>
                                <td data-label="Acciones" style= "text-align:center">
                                    <a href="../view/editarAeropuerto.php?id=<?= $aero['id_destino'] ?>" class="btn-reserva btn-editar">Editar</a>
                                    <a href="../controller/airportController.php?accion=eliminar&id=<?= $aero['id_destino'] ?>" class="btn-reserva btn-borrar" onclick="return confirm('¿Seguro que quieres eliminar este aeropuerto?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No se encontraron aeropuertos.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
