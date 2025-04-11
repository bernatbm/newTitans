<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../shared/header.php'; ?>

<main class="pa-main">
    <h1 class="pa-h1">Perfil de Administrador</h1>
    <p class="pa-p1">Bienvenido, aquí puedes crear y gestionar reservas</p>
        <section class="pa-crear-reserva">
            <div>
                <h2 class="pa-h2">Crear reserva</h2>
                    <form class="pa-form" action="crearReserva.php" method="POST">
                        <div class="pa-form-tipo">
                            <label for="pa-tipo-trayecto">Tipo de trayecto:</label>
                            <select id="pa-tipo-trayecto" name="tipo_trayecto" required> 
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="aeropuerto-hotel">Aeropuerto → Hotel</option>
                                <option value="hotel-aeropuerto">Hotel → Aeropuerto</option>
                                <option value="ida-vuelta">Ida y vuelta</option>
                            </select>
                        </div>
                        <div class="pa-form-dia-llegada">
                            <label for="dia-llegada">Dia de llegada:</label>
                            <input class="pa-input-dia-llegada" type="date" id="dia-llegada" name="dia-llegada" required>
                        </div>


                        <div class="pa-form-hora-llegada">
                            <label for="hora-llegada">Hora de llegada:</label>
                            <input class="pa-input-hora-llegada" type="time" id="hora-llegada" name="hora-llegada" required>
                        </div>
                        <div class="pa-form-numero-vuelo">
                            <label for="numero-vuelo">Numero de vuelo:</label>
                            <input class="pa-input-numero-vuelo" type="text" id="numero-vuelo" name="numero-vuelo">
                        </div>
                        <div class="pa-form-aeropuerto-origen">
                            <label for="aeropuerto-origen" >Aeropuerto de origen:</label>
                            <input class="pa-input-aeropuerto-origen" type="text" id="aeropuerto-origen" name="aeropuerto-origen" required>
                        </div>
                        <div class="pa-form-hotel-destino">
                            <label for="hotel-destino">Hotel de destino:</label>
                            <input class="pa-input-hotel-destino" type="text" id="hotel-destino" name="hotel-destino" required>
                        </div>
                        <div class="pa-form-numero-viajeros">
                            <label for="numero-viajeros">Número de viajeros:</label>
                            <select class="pa-select-numero-viajeros" id="numero-viajeros" name="numero_viajeros" required>
                                <option value="" disabled selected>Selecciona</option>
                                <option value="1">1 viajero</option>
                                <option value="2">2 viajeros</option>
                                <option value="3">3 viajeros</option>
                                <option value="4">4 viajeros</option>
                                <option value="5">5 viajeros</option>
                                <option value="6">6 viajeros</option>
                            </select>
                        </div>
                        <div class="pa-form-email">
                            <label for="email-cliente">Email:</label>
                            <input class="pa-input-email" type="email" id="email-cliente" name="email_cliente" required>
                        </div>
                    </form>
            </div>
        
        </section>

        
        
</main>

</body>
</html>