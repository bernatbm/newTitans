<?php
session_start();

require_once '../model/reservasUsuarioModel.php';

if (isset($_GET['borrado'])) {
    echo "<p class='exito'>✅ Reserva borrada correctamente.</p>";
}
if (isset($_GET['error'])) {
    $errores = [
        'reserva_no_encontrada' => '❌ Reserva no encontrada.',
        'no_puede_borrar' => '❌ No puedes borrar reservas con menos de 2 días.',
        'error_borrar' => '❌ Error al borrar la reserva.',
        'id_invalido' => '❌ ID de reserva inválido.'
    ];
    echo "<p class='error'>" . ($errores[$_GET['error']] ?? '❌ Error desconocido.') . "</p>";
}

if (!isset($_SESSION['userName']) || $_SESSION['isAdmin'] != 0) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}

$model = new ReservasUsuarioModel();
$etiquetas = [
    'id_reserva' => 'Número de reserva',
    'localizador' => 'Localizador',
    'id_hotel' => 'ID Hotel',
    'id_tipo_reserva' => 'Tipo de reserva (ID)',
    'tipo_reserva_desc' => 'Tipo de reserva',
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
    'id_vehiculo' => 'ID Vehículo',
    'numero_vuelo_salida' => 'Número de vuelo (vuelta)',
    'hora_recogida' => 'Hora de recogida'
];

try {
    $userName_usuario = $_SESSION['userName'];
    $email_usuario = $model->obtenerEmailPorNombre($userName_usuario);
    $reservas = $model->obtenerReservasPorEmail($email_usuario);

    if (!$reservas) {
        header("Location: ../view/reservasUsuarioSinResultados.php");
        exit;
    }

    // Carga la vista con los datos
    require_once '../view/reservasUsuarioView.php';

} catch (PDOException $e) {
    echo "❌ Error al obtener los datos: " . $e->getMessage();
    exit;
}