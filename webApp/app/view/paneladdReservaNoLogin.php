<?php
session_start();
require_once '../controller/reservasController.php';
$controller = new ReservasController();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include '../shared/header.php'; ?>

<main class="pa-main">
    <h1 class="pa-h1"style="display: none;">Perfil de Administrador</h1>
    <p class="pa-p1"style="display: none;">Bienvenido, aquí puedes crear y gestionar reservas</p>
    <!-- Formulario "Crear reserva"-->
        <section class="pa-crear-reserva"  style="display: none;" id= "options">
            <div>
                <h2 class="pa-h2" id="h2-selector">Crear reserva - Seleccione el trayecto que quiere reservar</h2>
                <h3 class="pa-h3-titulo-trayecto" id="titulo-trayecto" style="display: none;"></h3>

                <!--Selector de formulario con imagenes -->

                <div class="pa-selector-trayecto">
                    <div class="pa-trayecto-opcion" data-tipo="aeropuerto-hotel" style="display: none;" id= "aeroHotel">
                        <img src="../assets/imagenes/aero-hotel.png" alt="Aeropuerto a Hotel">
                    </div>
                    <div class="pa-trayecto-opcion" data-tipo="hotel-aeropuerto" style="display: none;" id= "hotelAero">
                        <img src="../assets/imagenes/hotel-aero.jpg" alt="Hotel a Aeropuerto">
                    </div>
                    <div class="pa-trayecto-opcion" data-tipo="ida-vuelta"  style="display: none;" id= "idaVuelta">
                        <img src="../assets/imagenes/idavuelta.jpg" alt="">
                    </div>

                </div>
                
                    <!---------------------- Formulario Aeropuerto-> Hotel------------------------>

                    <div id="form-aeropuerto-hotel" style="display: none;">
                    
                        <form class="pa-form" action="../controller/reservasController.php" method="POST">
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
                                        <select class="pa-input-aeropuerto-origen aeropuerto-select" name="id_destino" required>
                                            <option value="" disabled selected>Selecciona un aeropuerto</option>
                                        </select>
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
                        <form class="pa-form" action="../controller/reservasController.php" method="POST">
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
                                        <select class="pa-input-aeropuerto-origen aeropuerto-select" name="id_destino" required>
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

                    <div id="form-ida-vuelta" style="display: none;">
                        <form class="pa-form" action="../controller/reservasController.php" method="POST">
                        <input type="hidden" name="id_tipo_reserva" value="3">

                            <div class="pa-dos-columnas">
                                <!-- Columna izquierda-->
                                <div class="pa-columna">
                                    <h3 class="pa-titulo-ida-y-vuelta">Ida</h3>

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
                                    < <div class="pa-form-aeropuerto-origen">
                                        <label for="aeropuerto-origen">Aeropuerto de destino:</label>
                                        <select class="pa-input-aeropuerto-origen aeropuerto-select" name="id_destino" required>
                                            <option value="" disabled selected>Selecciona un aeropuerto</option>
                                            
                                        </select>
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
                                    
                                    <div class="pa-form-aeropuerto-origen">
                                        <label for="aeropuerto-origen">Aeropuerto de destino:</label>
                                        <select class="pa-input-aeropuerto-origen aeropuerto-select" name="id_destino" required>
                                            <option value="" disabled selected>Selecciona un aeropuerto</option>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="pa-form-email">
                                        <label for="email-cliente">Email:</label>
                                        <input class="pa-input-email email-cliente" type="email" name="email_cliente" required>
                                    </div>

                                </div>
                                
                                <div class="pa-ida-vuelta-submit">
                                    <button id="btn-cambiar-trayecto" class="pa-btn-cambiar-trayecto" style="display: none;">Volver a selección de trayecto</button>
                                    <button class="pa-ida-vuelta-button" id="ida-vuelta" type="submit">Confirmar reserva</button>
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

                                
                            </div>
                        </form>

                    </div>
                        

                       
 
                </form>
            </div>
        
        </section>
        <script src="../js/tipoFormulario.js"></script>
        <script src="../js/filtroHoteles.js"></script>
        <script src="../js/comprobarEmail.js"></script>
        <script src="../js/cargarAeropuertos.js"></script>
        <script src="../js/getReservaNoLogin.js"></script>
        <script>
document.addEventListener("DOMContentLoaded", () => {
    // Obtener los parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const reservado = urlParams.get('reservado');
    const localizador = urlParams.get('localizador');

    // Verificar si la URL contiene los parámetros adecuados
    if (reservado === "reserva" && localizador) {
        // Mostrar el popup con el localizador de la reserva
        alert(`¡Reserva creada con éxito! Localizador: ${localizador}`);

        // Limpiar la URL para evitar mostrar el popup dos veces
        const nuevaURL = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, nuevaURL);
    }
});
</script>
</body>
</html>