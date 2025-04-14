<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panelUsuario.css">
    </head>
<body>

<?php include '../shared/header.php'; ?>

<main class="pa-main">
    <h1 class="pa-h1">Tus reservas</h1>
    <p class="pa-p1">Bienvenid@, aquí puedes ver todas tus reservas</p>
       

    <!-- Sección para mostrar las reservas -->
    <section class="pa-reservas">
        <?php if (!empty($reservas)): ?>
            <table class="pa-tabla-reservas">
                <thead>
                    <tr>
                        <th>ID Reserva</th>
                        <th>Tipo de Reserva</th>
                        <th>Fecha de Llegada</th>
                        <th>Hora de Llegada</th>
                        <th>Numero de Vuelo</th>
                        <th>Zona</th>
                        <th>Hotel</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo $reserva['id_reserva']; ?></td>
                            <td><?php echo $reserva['tipo_reserva']; ?></td>
                            <td><?php echo $reserva['fecha_llegada']; ?></td>
                            <td><?php echo $reserva['hora_llegada']; ?></td>
                            <td><?php echo $reserva['numero_vuelo']; ?></td>
                            <td><?php echo $reserva['zona']; ?></td>
                            <td><?php echo $reserva['hotel']; ?></td>
                            <td>
                                <a href="ver_reserva.php?id=<?php echo $reserva['id_reserva']; ?>" class="pa-btn-ver">Ver</a>
                                <a href="editar_reserva.php?id=<?php echo $reserva['id_reserva']; ?>" class="pa-btn-editar">Editar</a>
                                <a href="eliminar_reserva.php?id=<?php echo $reserva['id_reserva']; ?>" class="pa-btn-eliminar">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="pa-no-reservas">No tienes reservas actuales.</p>
        <?php endif; ?>
    </section>
</main>