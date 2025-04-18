<?php
session_start();
require_once './model/database.php'; 
$db = new database(); // database
$conn = $db->getConn(); //conexión database

// Crear tabla transfer_administradores si no existe
$db->crearTablaAdmin();

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM transfer_administradores WHERE isAdmin = 1");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result['total'] == 0) {
    // No hay administradores, redirige a la página de registro inicial
    header("Location: /view/registroView.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isla Transfers</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Encabezado -->
    <?php include 'shared/header.php'; ?>
    <!---FIN ENCABEZADO-->


    <section class="hero" id="inicio">
        <div class="hero-content">
            <h1 style="color: #FFFFFF;">Bienvenido a Nuestra Empresa</h1>
            <p style="color: #FFFFFF;">Ofrecemos servicios de transporte confiables y seguros.</p>
        </div>
    </section>
    

    <!-- Sección Servicios -->
    <section class="services" id="servicios">
        <h2>NUESTROS SERVICIOS</h2>
        <div class="service">
                <img src="assets/imagenes/van.jpeg" alt="Transporte Aeropuerto" class="service-img">
                <h3>Traslados Aeropuerto-Hotel y Hotel-Aeropuerto</h3>
                <p>Pulsa para más información</p>
        </div>
        <div class="service">
                <img src="assets/imagenes/vip.jpg" alt="Viajes Corporativos" class="service-img">
                <h3>Traslados VIP</h3>
                <p>Pulsa para más información</p>
        </div>
        <div class="service">
                <img src="assets/imagenes/limusina.jpg" alt="Tours Turísticos" class="service-img">
            <h3>Traslados a Eventos Especiales</h3>
            <p>Pulsa para más información</p>
        </div>
    </section>

    <section class="ventajas" id="ventajas">
        <h2>VENTAJAS DE CONTRATAR NUESTROS SERVICIOS</h2>
        <div class="ventaja">
                <img src="assets/imagenes/reloj.png" alt="Transporte Aeropuerto" class="service-img">
                <h3>Puntualidad Garantizada</h3>
                <p>Sabemos lo importante que es llegar a tiempo. Nuestros conductores siempre están preparados 
                    para llegar puntuales a tu lugar de recogida, evitando que tengas que esperar o te preocupes por el tiempo.</p>
        </div>
        <div class="ventaja">
                <img src="assets/imagenes/dinero.png" alt="Viajes Corporativos" class="service-img">
                <h3>Precios transparentes</h3>
                <p>Olvídate de sorpresas con tarifas ocultas. Nuestros precios son claros y transparentes, 
                    con opciones accesibles para diferentes tipos de clientes. Al contratar nuestros servicios, 
                    sabrás exactamente lo que estás pagando, sin cargos adicionales al momento del servicio.</p>
        </div>
        <div class="ventaja">
                <img src="assets/imagenes/coche.png" alt="Tours Turísticos" class="service-img">
            <h3>Conductores profesionales</h3>
            <p>Todos nuestros conductores son profesionales y están capacitados para ofrecerte 
                un servicio seguro. Además, nuestros vehículos están en perfectas condiciones, 
                con mantenimiento regular y adaptados para garantizar tu seguridad y confort durante el trayecto.</p>
        </div>
    </section>


    <!-- Sección Contacto -->
    <section class="contact" id="contacto">
        
        
    
        <!-- Formulario básico -->
        <form action="#" method="post">
        
          <h2>Contáctanos</h2>
            <label for="nombre">Nombre:</label><br/>
            <input type="text" id="nombre" name="nombre" required><br/><br/>

            <label for="email">Email:</label><br/>
            <input type="email" id="email" name="email" required><br/><br/>

            <label for="mensaje">Mensaje:</label><br/>
            <textarea id="mensaje" name="mensaje" rows="4" required></textarea><br/><br/>

            <button type="submit">Enviar</button>
        </form>

        <p>Email: info@transfers.com</p>
        <p>Teléfono: +34 123 456 789</p>
    </section>



    <!-- JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>