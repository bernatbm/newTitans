<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: login.php?error=acceso_denegado");
    exit;
}
require_once '../model/database.php';
require_once '../model/hotelModel.php';
require_once '../model/zoneModel.php'; 

$db = new Database();
$conn = $db->getConn();
$model = new HotelModel($conn);
$zoneModel = new ZoneModel($conn); 
$hoteles = $model->obtenerHoteles();
$zonas = $zoneModel->obtenerZonas();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>

<?php include '../shared/header.php'; ?>


<!-- Formulario para añadir hotel -->
<form class="form-h2-airport" method="POST" action="../controller/hotelController.php">
    <h2 class="pa-h2-airport">Añadir Nuevo Hotel</h2>
    
    <label class="name-airport">Nombre del hotel:</label>
    <input class="input-name" type="text" name="nombre_hotel" required>

    <label class="name-airport">ID Zona:</label>
    <select class="input-name" name="id_zona" required>
        <?php foreach ($zonas as $zona): ?>
            <option value="<?= $zona['id_zona'] ?>"><?= htmlspecialchars($zona['descripcion']) ?></option>
        <?php endforeach; ?>
    </select>
    </br>
    <label class="name-airport">Precio:</label>
    <input class="input-name" type="number" name="Comision" value="<?= isset($comision) ? htmlspecialchars($comision) : 10 ?>" required></br>

    <label class="name-airport">Usuario:</label>
    <input class="input-name" type="text" name="usuario" required>

    <label class="name-airport">Password:</label>
    <input class="input-name" type="password" name="password" required>

    <button type="submit" class="btn-reserva">➕ Añadir Hotel</button>
</form>

<!-- Listado de hoteles -->
<div class="form-list">
    <section class="pa-lista-reservas">
        <h2 class="pa-h2-lista">Listado de Hoteles</h2>
        <div class="tabla-wrapper" style="overflow-x:auto;">
            <table class="pa-tabla-reservas" style="width:100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead>
                    <tr style="background:#f3c158;">
                        <th style="padding: 8px; border: 1px solid #ddd;">ID</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Nombre</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">ID de la Zona</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Zona</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Precio</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Usuario</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Password</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($hoteles)): ?>
                        <?php foreach ($hoteles as $hotel): ?>
                            <tr class="pa-casillas-reservas" style="color:white">
                                <td data-label="ID"style="text-align:center"><?= htmlspecialchars($hotel['id_hotel']) ?></td>
                                <td data-label="HOTEL"style="text-align:center"><?= htmlspecialchars($hotel['nombre_hotel']) ?></td>
                                <td data-label="ID ZONA"style="text-align:center"><?= htmlspecialchars($hotel['id_zona']) ?></td>
                                <td data-label="NOMBRE CIUDAD"style="text-align:center"><?= htmlspecialchars($hotel['descripcion'] ?? 'No disponible') ?></td>
                                <td data-label="PRECIO"style="text-align:center"><?= htmlspecialchars($hotel['Comision']) . "€" ?></td>
                                <td data-label="USUARIO "style="text-align:center"><?= htmlspecialchars($hotel['usuario']) ?></td>
                                <td data-label="CONTRASEÑA"style="text-align:center"><?= htmlspecialchars($hotel['password']) ?></td>
                                <td style="text-align:center">
                                <a class="btn-reserva btn-editar" href="editarHotel.php?id_hotel=<?= $hotel['id_hotel'] ?>">Editar</a>
                                    <a href="../controller/hotelController.php?accion=eliminar&id=<?= $hotel['id_hotel'] ?>" class="btn-reserva btn-borrar" onclick="return confirm('¿Eliminar este hotel?')"> Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center">No se encontraron hoteles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
