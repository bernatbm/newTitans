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
                <h2 class="pa-h2" id="h2-selector">Crear reserva - Seleccione el trayecto que quiere reservar</h2>
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
                
                    <!---------------------- Formulario Aeropuerto-> Hotel------------------------>

                    <div id="form-aeropuerto-hotel" style="display: none;">
                    
                        <form class="pa-form" action="../controller/reservarAeropuertoHotel.php" method="POST">
                        <input type="hidden" name="id_tipo_reserva" value="1">
                            <div class="pa-form-dia-llegada">
                                <label for="fecha-llegada">Dia de llegada:</label>
                                <input class="pa-input-dia-llegada" type="date" id="fecha-llegada" name="fecha_llegada" required>
                            </div>

                            <div class="pa-form-hora-llegada">
                                <label for="hora-llegada">Hora de llegada:</label>
                                <input class="pa-input-hora-llegada" type="time" id="hora-llegada" name="hora_llegada" required>
                            </div>
                            <div class="pa-form-numero-vuelo">
                                <label for="numero-vuelo">Numero de vuelo:</label>
                                <input class="pa-input-numero-vuelo" type="text" id="numero-vuelo-ida" name="numero_vuelo_entrada" required>
                            </div>
                            <div class="pa-form-aeropuerto-origen">
                                <label for="aeropuerto-origen" >Aeropuerto de origen:</label>
                                <input class="pa-input-aeropuerto-origen" type="text" id="aeropuerto-origen" name="aeropuerto_origen" required>
                            </div>

                            <div class="pa-form-zona">
                                <label for="id-zona">Zona:</label>
                                <select class="pa-input-zona" id="id-zona" name="id_zona" required>
                                    <option value="" disabled selected>Selecciona una zona</option>
                                    <?php include '../controller/getZonas.php'; ?>
                                </select>
                            </div>
                            <div class="pa-form-hotel-destino">
                                <label for="id-hotel">Hotel de destino:</label>
                                <select class="pa-select-hotel-destino" id="id-hotel" name="id_hotel" required>
                                    <option  disabled selected>Primero selecciona una zona</option>
                                </select>
                            </div>

                            <div class="pa-form-numero-viajeros">
                                <label for="numero-viajeros">Número de viajeros:</label>
                                <select class="pa-select-numero-viajeros" id="numero-viajeros" name="num_viajeros" required>
                                <option value="" disabled selected>Selecciona</option>
                                <?php
                                    for ($i = 1; $i <= 8; $i++) {
                                        echo "<option value='$i'>$i viajero" . ($i > 1 ? "s" : "") . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="pa-form-email">
                                <label for="email-cliente">Email:</label>
                                <input class="pa-input-email email-cliente" type="email" name="email_cliente" required>
                            </div>

                            <div class="pa-aeropuerto-hotel-submit">
                                <button class="pa-btn-cambiar-trayecto" style="display: none;">Volver a selección de trayecto</button>
                                <button class="pa-aeropuerto-hotel-button" id="submit-aeropuerto-hotel" type="submit">Confirmar reserva</button>
                            </div>

                            <!---------------------- Formulario Opcional Usuario------------------------>

                            <div class="datos-viajero-adicionales" style="display: none;">
                                <div>
                                    <label>Nombre:</label>
                                    <input class="pa-form-opcional" type="text" name="nombre" id="nombre" >
                                </div>
                                <div>
                                    <label>Apellido 1:</label>
                                    <input class="pa-form-opcional" type="text" name="apellido1" id="apellido1" >
                                </div>
                                <div>
                                    <label>Apellido 2:</label>
                                    <input class="pa-form-opcional" type="text" name="apellido2" id="apellido2">
                                </div>
                                <div>
                                    <label>Dirección:</label>
                                    <input class="pa-form-opcional" type="text" name="direccion" id="direccion" >
                                </div>
                                <div>
                                    <label>Código Postal:</label>
                                    <input class="pa-form-opcional" type="text" name="codigoPostal" id="codigoPostal" >
                                </div>
                                <div>
                                    <label>Ciudad:</label>
                                    <input class="pa-form-opcional" type="text" name="ciudad" id="ciudad" >
                                </div>
                                <div>
                                    <label>País:</label>
                                    <input class="pa-form-opcional" type="text" name="pais" id="pais" >
                                </div>
                                <div>
                                    <label>Contraseña:</label>
                                    <input class="pa-form-opcional" type="password" name="password" id="password" >
                                </div>
                            </div>
                        </form>

                        
                                    
                        
                    </div>

                        <!---------------------- Formulario Hotel -> Aeropuerto---------------------->

                    <div id="form-hotel-aeropuerto" style="display: none;">
                        <form class="pa-form" action="../controller/reservarHotelAeropuerto.php" method="POST">
                        <input type="hidden" name="id_tipo_reserva" value="2">
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
                            <div class="pa-form-zona">
                                <label for="id-zona">Zona:</label>
                                <select class="pa-input-zona" id="id-zona" name="id_zona" required>
                                    <option value="" disabled selected>Selecciona una zona</option>
                                    <?php include '../controller/getZonas.php'; ?>
                                </select>
                            </div>
                            <div class="pa-form-hotel-destino">
                                <label for="id-hotel">Hotel de recogida</label>
                                <select class="pa-select-hotel-destino" id="id-hotel" name="id_hotel" required>
                                    <option  disabled selected>Primero selecciona una zona</option>
                                </select>
                            </div>

                            <div class="pa-form-aeropuerto-origen">
                                <label for="aeropuerto-origen">Aeropuerto de destino:</label>
                                <select class="pa-input-aeropuerto-origen" id="aeropuerto-destino" name="id_destino" required>
                                    <option value="" disabled selected>Selecciona un aeropuerto</option>
                                </select>
                            </div>

                        
                            <div class="pa-form-numero-viajeros">
                                <label for="numero-viajeros">Número de viajeros:</label>
                                <select class="pa-select-numero-viajeros" id="numero-viajeros" name="num_viajeros" required>
                                <option value="" disabled selected>Selecciona</option>
                                <?php
                                    for ($i = 1; $i <= 8; $i++) {
                                        echo "<option value='$i'>$i viajero" . ($i > 1 ? "s" : "") . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="pa-form-email">
                                <label for="email-cliente">Email:</label>
                                <input class="pa-input-email email-cliente" type="email" name="email_cliente" required>
                            </div>

                            <div class="pa-hotel-aeropuerto-submit">
                                <button class="pa-btn-cambiar-trayecto" style="display: none;">Volver a selección de trayecto</button>
                                <button class="pa-hotel-aeropuerto-button" id="hotel-aeropuerto" type="submit">Confirmar reserva</button>
                            </div>

                            <!---------------------- Formulario Opcional Usuario------------------------>
                            <div class="datos-viajero-adicionales" style="display: none;">
                                <div>
                                    <label>Nombre:</label>
                                    <input class="pa-form-opcional" type="text" name="nombre" id="nombre" >
                                </div>
                                <div>
                                    <label>Apellido 1:</label>
                                    <input class="pa-form-opcional" type="text" name="apellido1" id="apellido1" >
                                </div>
                                <div>
                                    <label>Apellido 2:</label>
                                    <input class="pa-form-opcional" type="text" name="apellido2" id="apellido2">
                                </div>
                                <div>
                                    <label>Dirección:</label>
                                    <input class="pa-form-opcional" type="text" name="direccion" id="direccion" >
                                </div>
                                <div>
                                    <label>Código Postal:</label>
                                    <input class="pa-form-opcional" type="text" name="codigoPostal" id="codigoPostal" >
                                </div>
                                <div>
                                    <label>Ciudad:</label>
                                    <input class="pa-form-opcional" type="text" name="ciudad" id="ciudad" >
                                </div>
                                <div>
                                    <label>País:</label>
                                    <input class="pa-form-opcional" type="text" name="pais" id="pais" >
                                </div>
                                <div>
                                    <label>Contraseña:</label>
                                    <input class="pa-form-opcional" type="password" name="password" id="password" >
                                </div>
                            </div>
                        </form>


                        </form>

                    </div>



                        <!-- Formulario ida y vuelta-->

                    <div id="from-ida-vuelta" style="display: none;">
                        <form class="pa-form" action="../controller/reservarIdaVuelta.php" method="POST">
                        <input type="hidden" name="id_tipo_reserva" value="3">

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
                                    
                                    <div class="pa-form-email">
                                        <label for="email-cliente">Email:</label>
                                        <input class="pa-input-email email-cliente" type="email" name="email_cliente" required>
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
                        </form>

                    </div>
                        

                       
 
                </form>
            </div>
        
        </section>

        
        
</main>
<script src="../js/tipoFormulario.js"></script>
<script src="../js/filtroHoteles.js"></script>
<script src="../js/comprobarEmail.js"></script>
<script src="../js/cargarAeropuertos.js"></script>
</body>
</html>