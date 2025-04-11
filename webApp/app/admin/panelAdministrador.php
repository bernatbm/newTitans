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
    <!-- Formulario "Crear reserva"-->
        <section class="pa-crear-reserva">
            <div>
                <h2 class="pa-h2" id="h2-selector">Seleccione el trayecto que quiere reservar</h2>
                <h3 class="pa-h3-titulo-trayecto" id="titulo-trayecto" style="display: none;"></h3>

                <!--Selector de formulario con imagenes -->

                <div class="pa-selector-trayecto">
                    <div class="pa-trayecto-opcion" data-tipo="aeropuerto-hotel">
                        <img src="../assets/imagenes/aero-hotel.png" alt="Aeropuerto a Hotel">
                    </div>
                    <div class="pa-trayecto-opcion" data-tipo="hotel-aeropuerto">
                        <img src="../assets/imagenes/hotel-aero.jpg" alt="Hotel a Aeropuerto">
                    </div>
                    <div class="pa-trayecto-opcion" data-tipo="ida-vuelta">
                        <img src="../assets/imagenes/idavuelta.jpg" alt="">
                    </div>

                </div>
                
                    <!-- Formulario Aeropuerto-> Hotel-->

                    <div id="form-aeropuerto-hotel" style="display: none;">

                        <div class="pa-form-dia-llegada">
                            <label for="dia-llegada">Dia de llegada:</label>
                            <input class="pa-input-dia-llegada" type="date" id="dia-llegada" name="dia-llegada" required>
                        </div>

                        <div class="pa-form-hora-llegada">
                            <label for="hora-llegada">Hora de llegada:</label>
                            <input class="pa-input-hora-llegada" type="time" id="hora-llegada" name="hora_llegada" required>
                        </div>
                        <div class="pa-form-numero-vuelo">
                            <label for="numero-vuelo">Numero de vuelo:</label>
                            <input class="pa-input-numero-vuelo" type="text" id="numero-vuelo-ida" name="numero_vuelo_ida">
                        </div>
                        <div class="pa-form-aeropuerto-origen">
                            <label for="aeropuerto-origen" >Aeropuerto de origen:</label>
                            <input class="pa-input-aeropuerto-origen" type="text" id="aeropuerto-origen" name="aeropuerto_origen" required>
                        </div>
                        <div class="pa-form-hotel-destino">
                            <label for="hotel-destino">Hotel de destino:</label>
                            <input class="pa-input-hotel-destino" type="text" id="hotel-destino" name="hotel_destino" required>
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
                        <div class="pa-form-nombre-cliente">
                            <label for="nombre-cliente">Nombre completo:</label>
                            <input class="pa-input-nombre-cliente" type="text" id="nombre-cliente" name="nombre_cliente" required>
                        </div>
                        <div class="pa-form-email">
                            <label for="email-cliente">Email:</label>
                            <input class="pa-input-email" type="email" id="email-cliente" name="email_cliente" required>
                        </div>

                        <div class="pa-aeropuerto-hotel-submit">
                            <button class="pa-btn-cambiar-trayecto" style="display: none;">Volver a selección de trayecto</button>
                            <button class="pa-aeropuerto-hotel-button" id="submit-aeropuerto-hotel" type="submit">Confirmar reserva</button>
                        </div>
                        


                    </div>

                        <!-- Formulario Hotel -> Aeropuerto--->

                    <div id="form-hotel-aeropuerto" style="display: none;">
                        <div class="pa-form-dia-vuelo">
                            <label for="dia-vuelo">Dia del vuelo:</label>
                            <input class="pa-input-dia-vuelo" type="date" name="dia_vuelo" id="dia-vuelo" required>
                        </div>
                        <div class="pa-form-hora-vuelo">
                            <label for="hora-vuelo">Hora del vuelo:</label>
                            <input class="pa-input-hora-vuelo" type="time" name="hora_vuelo" id="hora-vuelo" required>
                        </div>
                        <div class="pa-form-numero-vuelo">
                            <label for="numero-vuelo">Numero de vuelo:</label>
                            <input class="pa-input-numero-vuelo" type="text" id="numero-vuelo-vuelta" name="numero_vuelo_vuelta" required>
                        </div>
                        <div class="pa-form-hora-recogida">
                            <label for="hora-recogida">Hora de recogida:</label>
                            <input class="pa-input-hora-recogida" type="time" id="hora-recogida" name="hora_recogida" required>
                        </div>
                        <div class="pa-form-hotel-recogida">
                            <label for="hotel-recogida">Hotel de recogida</label>
                            <input class="pa-input-hotel-recogida" type="text" id="hotel-recogida" name="hotel_recogida" required>
                        </div>
                        <div class="pa-form-aeropuerto-destino">
                            <label for="aeropuerto-destino">Aeropuerto de destino</label>
                            <input class="pa-input-aeropuerto-destino" type="text" id="aeropuerto-recogida" name="aeropuerto_recogia" required>
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
                        <div class="pa-form-nombre-cliente">
                            <label for="nombre-cliente">Nombre completo:</label>
                            <input class="pa-input-nombre-cliente" type="text" id="nombre-cliente" name="nombre_cliente" required>
                        </div>
                        <div class="pa-form-email">
                            <label for="email-cliente">Email:</label>
                            <input class="pa-input-email" type="email" id="email-cliente" name="email_cliente" required>
                        </div>

                        <div class="pa-hotel-aeropuerto-submit">
                            <button class="pa-btn-cambiar-trayecto" style="display: none;">Volver a selección de trayecto</button>
                            <button class="pa-hotel-aeropuerto-button" id="hotel-aeropuerto" type="submit">Confirmar reserva</button>
                        </div>

                    </div>

                        <!-- Formulario ida y vuelta-->

                    <div id="from-ida-vuelta" style="display: none;">

                        <div class="pa-dos-columnas">
                            <!-- Columna izquierda-->
                            <div class="pa-columna">
                                <h3 class="pa-titulo-ida-y-vuelta">Ida</h3>

                                <div class="pa-form-dia-llegada">
                                    <label for="dia-llegada">Dia de llegada:</label>
                                    <input class="pa-input-dia-llegada" type="date" id="dia-llegada" name="dia-llegada" required>
                                </div>
                                <div class="pa-form-hora-llegada">
                                    <label for="hora-llegada">Hora de llegada:</label>
                                    <input class="pa-input-hora-llegada" type="time" id="hora-llegada" name="hora_llegada" required>
                                </div>
                                <div class="pa-form-numero-vuelo">
                                    <label for="numero-vuelo">Numero de vuelo:</label>
                                    <input class="pa-input-numero-vuelo" type="text" id="numero-vuelo-ida" name="numero_vuelo_ida">
                                </div>
                                <div class="pa-form-aeropuerto-origen">
                                    <label for="aeropuerto-origen" >Aeropuerto de origen:</label>
                                    <input class="pa-input-aeropuerto-origen" type="text" id="aeropuerto-origen" name="aeropuerto_origen" required>
                                </div>
                                <div class="pa-form-hotel-destino">
                                    <label for="hotel-destino">Hotel de destino:</label>
                                    <input class="pa-input-hotel-destino" type="text" id="hotel-destino" name="hotel_destino" required>
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
                                <div class="pa-form-nombre-cliente">
                                    <label for="nombre-cliente">Nombre completo:</label>
                                    <input class="pa-input-nombre-cliente" type="text" id="nombre-cliente" name="nombre_cliente" required>
                                </div>
                                <div class="pa-form-email">
                                    <label for="email-cliente">Email:</label>
                                    <input class="pa-input-email" type="email" id="email-cliente" name="email_cliente" required>
                                </div>
                            </div>

                            <!--Columna derecha-->

                            <div class="pa-columna">
                            <h3 class="pa-titulo-ida-y-vuelta">Vuelta</h3>
                                <div class="pa-form-dia-vuelo">
                                    <label for="dia-vuelo">Dia del vuelo:</label>
                                    <input class="pa-input-dia-vuelo" type="date" name="dia_vuelo" id="dia-vuelo" required>
                                </div>
                                <div class="pa-form-hora-vuelo">
                                    <label for="hora-vuelo">Hora del vuelo:</label>
                                    <input class="pa-input-hora-vuelo" type="time" name="hora_vuelo" id="hora-vuelo" required>
                                </div>
                                <div class="pa-form-numero-vuelo">
                                    <label for="numero-vuelo">Numero de vuelo:</label>
                                    <input class="pa-input-numero-vuelo" type="text" id="numero-vuelo-vuelta" name="numero_vuelo_vuelta" required>
                                </div>
                                <div class="pa-form-hora-recogida">
                                    <label for="hora-recogida">Hora de recogida:</label>
                                    <input class="pa-input-hora-recogida" type="time" id="hora-recogida" name="hora_recogida" required>
                                </div>
                                <div class="pa-form-hotel-recogida">
                                    <label for="hotel-recogida">Hotel de recogida</label>
                                    <input class="pa-input-hotel-recogida" type="text" id="hotel-recogida" name="hotel_recogida" required>
                                </div>
                                <div class="pa-form-aeropuerto-destino">
                                    <label for="aeropuerto-destino">Aeropuerto de destino</label>
                                    <input class="pa-input-aeropuerto-destino" type="text" id="aeropuerto-recogida" name="aeropuerto_recogia" required>
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
                                <div class="pa-form-nombre-cliente">
                                    <label for="nombre-cliente">Nombre completo:</label>
                                    <input class="pa-input-nombre-cliente" type="text" id="nombre-cliente" name="nombre_cliente" required>
                                </div>
                                <div class="pa-form-email">
                                    <label for="email-cliente">Email:</label>
                                    <input class="pa-input-email" type="email" id="email-cliente" name="email_cliente" required>
                                </div>


                            </div>

                            

                            <div class="pa-ida-vuelta-submit">
                                <button id="btn-cambiar-trayecto" class="pa-btn-cambiar-trayecto" style="display: none;">Volver a selección de trayecto</button>
                                <button class="pa-ida-vuelta-button" id="ida-vuelta" type="submit">Confirmar reserva</button>
                            </div>
                        </div>

                    </div>
                        

                       
 
                </form>
            </div>
        
        </section>

        
        
</main>
<script src="../js/tipoFormulario.js"></script>
</body>
</html>