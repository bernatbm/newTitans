<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Reserva</title>
    <link rel="stylesheet" href="../css/panelUsuario.css">
</head>
<body>
<section class="pa-detalle-reserva">
    <h2 class="pa-h2">Detalles de la Reserva</h2>
    <div class="tarjetas-container">
    <?php foreach ($reservas as $reserva): ?>
        <div class="tarjeta">
            <?php foreach ($etiquetas as $campo => $etiqueta): ?>
                <?php if (!is_null($reserva[$campo])): ?>
                    <p><strong><?= $etiqueta ?>:</strong> <?= htmlspecialchars($reserva[$campo]) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
            <a href="../controller/reservasController.php?action=editar&id=<?= $reserva['id_reserva'] ?>" class="btn-reserva btn-editar">Editar</a>
            <a href="../controller/reservasController.php?action=eliminar&id=<?= $reserva['id_reserva'] ?>">Eliminar</a>

            </div>
    <?php endforeach; ?>
    </div>
    <a href="../usuario/perfilUsuario.php" class="btn-volver">⬅ Volver al panel</a>
</section>
</body>
</html>
<?php