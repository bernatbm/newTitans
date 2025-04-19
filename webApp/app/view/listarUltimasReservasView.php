<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
<!-- Encabezado -->
<?php include '../shared/header.php'; ?>
<!-- FIN ENCABEZADO -->

<div class="form-list" style="max-height: 200px; margin: 0 auto; width: 100%;">
    <section class="pa-lista-reservas">
        <h2 class="pa-h2-lista">5 ÚLTIMAS RESERVAS</h2>
        <div class="tabla-wrapper" style="overflow-x:auto; max-width: 800px; margin: 0 auto;">
            <table class="pa-tabla-reservas tabla-reservas-estrecha" style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
                <thead>
                    <tr style="background:rgb(236, 163, 5);">
                        <th style="padding: 4px 8px; border: 1px solid #ddd;">ID</th>
                        <th style="padding: 4px 8px; border: 1px solid #ddd;">Localizador</th>
                        <th style="padding: 4px 8px; border: 1px solid #ddd;">Hotel</th>
                        <th style="padding: 4px 8px; border: 1px solid #ddd;">Tipo</th>
                        <th style="padding: 4px 8px; border: 1px solid #ddd;">Nombre Cliente</th>
                        <th style="padding: 4px 8px; border: 1px solid #ddd;">Fecha Reserva</th>
                        <th style="background:#221a1a;">
                            <a href="/public/listarReservas.php" class="btn-reserva btn-more-details" style="border: 1px solid white; color: yellow; padding: 6px 12px; border-radius: 6px; display: inline-block; text-decoration: none;">
                                Ver todas las reservas
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($reservas)): ?>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr class="pa-casillas-reservas" style="color:white">
                            <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                            <td><?= htmlspecialchars($reserva['localizador']) ?></td> 
                            <td data-label="Hotel"><?= htmlspecialchars($reserva['nombre_hotel'] ?? 'Sin nombre') ?></td>
                            <td data-label="Tipo"><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                            <td data-label="Nombre Cliente"><?= htmlspecialchars($reserva['nombre_completo']) ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td> <!-- Asegúrate de que 'fecha_reserva' esté en la consulta -->
                            <td data-label="Acciones" style="background:#221a1a;">
                            <br><br>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No se encontraron reservas.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
