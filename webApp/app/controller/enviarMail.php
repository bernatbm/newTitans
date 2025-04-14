<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 

function enviarCorreoReserva($destinatario, $nombreCliente, $localizador, $detalles = '') {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'reservasnewtitans@gmail.com';
        $mail->Password = 'pdeo jfez uelr vsf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente
        $mail->setFrom('reservasnewtitans@gmail.com', 'Reservas Transfer Isla Transfers');
        $mail->addAddress($destinatario);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de Reserva';
        $mail->Body    = "
            <h2>¡Gracias por reservar con nosotros, $nombreCliente!</h2>
            <p>Tu reserva ha sido confirmada con el siguiente localizador:</p>
            <strong>$localizador</strong>
            <br><br>
            $detalles
            <br><br>
            <em>Nos vemos pronto,<br>Reservas Transfer Isla Transfers</em>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("❌ Error al enviar correo: {$mail->ErrorInfo}");
        return false;
    }
}