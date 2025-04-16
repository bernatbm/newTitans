<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
  <!-- Encabezado -->
  <?php include '../shared/header.php'; ?>
    <!---FIN ENCABEZADO-->
<div class="form-list">
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
                

                <?php if (!empty($reservas)): ?>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr class="pa-casillas-reservas" style="color:white">
                            <td data-label="ID"><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                            <td data-label="Localizador"><?= htmlspecialchars($reserva['localizador']) ?></td>
                            <td data-label="Hotel"><?= htmlspecialchars($reserva['nombre_hotel'] ?? 'Sin nombre') ?></td>
                            <td data-label="Tipo"><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($reserva['email_cliente']) ?></td>
                            <td data-label="Fecha Reserva"><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                            <td data-label="Fecha Modificación"><?= htmlspecialchars($reserva['fecha_modificacion'] ?? 'Sin modificar') ?></td>
                            <td data-label="Acciones">
                                <a href="../public/verReserva.php?id=<?= $reserva['id_reserva'] ?>" class="btn-detalles">Detalles</a>
                                <a href="../view/editarReservaView.php?id=<?= $reserva['id_reserva'] ?>" class="btn-reserva btn-editar">Editar</a>
                                <a href="../controller/reservasController.php?action=eliminar&id=<?= $reserva['id_reserva'] ?>" class="btn-reserva btn-borrar" onclick="return confirm('¿Seguro que quieres borrar esta reserva?')">Borrar</a>
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

