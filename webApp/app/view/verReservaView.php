<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
<?php
// Verificar si el parámetro 'mensaje' está presente en la URL
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje']; // Obtener el mensaje desde la URL
    echo "<script type='text/javascript'>
            alert('$mensaje');
          </script>";
}


   
if (isset($reserva) && !empty($reserva)): ?>
    <section class="pa-detalle-reserva">
        <h2 class="pa-h2">Detalles de la Reserva</h2>
        <ul>
            <?php
            $etiquetas = [
                'id_reserva' => 'Número de reserva',
                'localizador' => 'Localizador',
                'nombre_hotel' => 'Hotel',
                'tipo_reserva' => 'Tipo de reserva',
                'email_cliente' => 'Email del cliente',
                'fecha_reserva' => 'Fecha de reserva',
                'fecha_modificacion' => 'Fecha de modificación',
                'id_destino' => 'Destino',
                'fecha_entrada' => 'Fecha de entrada',
                'hora_entrada' => 'Hora de entrada',
                'numero_vuelo_entrada' => 'Número de vuelo (ida)',
                'origen_vuelo_entrada' => 'Origen del vuelo',
                'hora_vuelo_salida' => 'Hora del vuelo de salida',
                'fecha_vuelo_salida' => 'Fecha del vuelo de salida',
                'num_viajeros' => 'Número de viajeros',
                'numero_vuelo_salida' => 'Número de vuelo (vuelta)',
                'hora_recogida' => 'Hora de recogida',
            ];
            


            foreach ($reserva as $campo => $valor):
                if (!isset($etiquetas[$campo])) continue;
            ?>
                <li><strong><?= $etiquetas[$campo] ?>:</strong> <?= htmlspecialchars($valor ?? '—') ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="../admin/panelAdministrador.php" class="btn-volver">⬅ Volver al panel</a>
    </section>
<?php else: ?>
    <p>No se encontró la reserva.</p>
<?php endif; ?>
