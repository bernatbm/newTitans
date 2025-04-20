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
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>


<?php include '../shared/header.php'; ?>

<!-- Formulario para añadir zona -->
<!-- Formulario para añadir zona -->
<form class="form-h2-airport" method="POST" action="../controller/zoneController.php">
    <h2 class="pa-h2-airport">Agregar Zona</h2>
    <input type="hidden" name="crear" value="1">

    <label class="name-airport">Nueva Zona:</label>
    <input type="text" class="input-name" name="descripcion" required placeholder="Nombre de la zona">


    <button type="submit" class="btn-reserva">➕ Añadir Zona</button>
</form>
<div class="form-list">
    <section class="pa-lista-reservas">
        <h2 class="pa-h2-lista">Listado de Zonas</h2>
        <div class="tabla-wrapper" style="overflow-x:auto;">
            <table class="pa-tabla-reservas">
                <thead>
                    <tr style="background:#f3c158;">
                        <th style="padding: 8px;">ID</th>
                        <th style="padding: 8px;">Descripción</th>
                        <th style="padding: 8px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($zonas as $zona): ?>
                        <tr class="pa-casillas-reservas"style="color:white">
                            <td data-label="ID"style="text-align:center;"><?= $zona['id_zona'] ?></td>
                            <td  data-label="Zona" style="text-align:center;"><?= htmlspecialchars($zona['descripcion']) ?></td>
                            <td style="text-align:center">
                                <a class="btn-reserva btn-editar" href="editarZona.php?id=<?= $zona['id_zona'] ?>">Editar</a>
                                <a class="btn-reserva btn-borrar" href="#" onclick="confirmarEliminacion(<?= $zona['id_zona'] ?>)">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmarEliminacion(idZona) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: '¿Quieres eliminar esta zona? Si hay hoteles asociados, no se podrá eliminar.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `../controller/zoneController.php?accion=eliminar&id=${idZona}`;
    }
  });
}
</script>

<?php if (isset($_GET['error']) && $_GET['error'] === 'no_se_puede_eliminar'): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'No se puede eliminar',
  text: 'Esta zona está asociada a uno o más hoteles.',
});
</script>
<?php endif; ?>

