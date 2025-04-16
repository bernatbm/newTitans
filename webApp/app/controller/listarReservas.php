<?php
require_once '../model/database.php';

/*try {
    $db = new database();
    $conn = $db->getConn();

    $sql = "SELECT 
            r.id_reserva, 
            r.localizador, 
            h.nombre_hotel, 
            t.Descripción AS tipo_reserva,
            r.email_cliente, 
            r.fecha_reserva, 
            r.fecha_modificacion
        FROM transfer_reservas r
        LEFT JOIN transfer_hotel h ON r.id_hotel = h.id_hotel
        LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
        ORDER BY r.fecha_reserva DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error al obtener reservas: " . $e->getMessage() . "</p>";
    exit;
}*/
?>

<section class="pa-lista-reservas">
    <h2 class="pa-h2-lista">Listado de Reservas</h2>
    <div class="tabla-wrapper" style="overflow-x:auto;">
        <table class="pa-tabla-reservas" style="width:100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="background:rgb(236, 163, 5);">
                    <th style="padding: 8px; border: 1px solid #ddd;">ID</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Localizador</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Hotel</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Tipo</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Fecha Reserva</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Fecha Modificación</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr class="pa-casillas-reservas">
                    <td data-label="ID"><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                    <td data-label="Localizador"><?= htmlspecialchars($reserva['localizador']) ?></td>
                    <td data-label="Hotel"><?= htmlspecialchars($reserva['nombre_hotel'] ?? 'Sin nombre') ?></td>
                    <td data-label="Tipo"><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                    <td data-label="Email"><?= htmlspecialchars($reserva['email_cliente']) ?></td>
                    <td data-label="Fecha Reserva"><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                    <td data-label="Fecha Modificación"><?= htmlspecialchars($reserva['fecha_modificacion'] ?? 'Sin modificar') ?></td>
                    <td data-label="Acciones">
                        <a href="../controller/verReserva.php?id=<?= $reserva['id_reserva'] ?>" class="btn-detalles">Detalles</a>
                        <a href="../controller/editarReserva.php?id=<?= $reserva['id_reserva'] ?>" class="btn-reserva btn-editar">Editar</a>
                        <a href="../controller/borrarReserva.php?id=<?= $reserva['id_reserva'] ?>" class="btn-reserva btn-borrar" onclick="return confirm('¿Seguro que quieres borrar esta reserva?')">Borrar</a>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>