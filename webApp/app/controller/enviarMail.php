<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require_once  '../vendor/autoload.php';

function enviarCorreoReserva($emailCliente, $datosReserva)
{
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'reservasnewtitans@gmail.com';
        $mail->Password   = 'sclwecasirpllpuk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('reservasnewtitans@gmail.com', 'Transfer Isla Transfers');
        $mail->addAddress($emailCliente);

        $mail->isHTML(true);
        $mail->Subject = '✔ Reserva confirmada';

        $mail->Body = "
            <h2>¡Gracias por tu reserva!</h2>
            <p>Tu reserva ha sido confirmada correctamente. Aquí tienes los detalles:</p>
            <ul>
                <li><strong>Localizador:</strong> {$datosReserva['localizador']}</li>
                <li><strong>Fecha de llegada:</strong> {$datosReserva['fechaEntrada']}</li>
                <li><strong>Hora de llegada:</strong> {$datosReserva['horaEntrada']}</li>
                <li><strong>Número de vuelo:</strong> {$datosReserva['numeroVuelo']}</li>
                <li><strong>Aeropuerto de origen:</strong> {$datosReserva['aeropuertoOrigen']}</li>
                <li><strong>Hotel ID:</strong> {$datosReserva['hotel']}</li>
                <li><strong>Número de viajeros:</strong> {$datosReserva['numViajeros']}</li>
            </ul>
            <p>Si necesitas modificar algo, contáctanos respondiendo este correo.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Error al enviar correo: ' . $mail->ErrorInfo;
    }
}