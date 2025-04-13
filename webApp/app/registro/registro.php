<?php
session_start();
require_once '../model/database.php'; 
$db = new database();
$conn = $db->getConn();

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM transfer_administradores WHERE isAdmin = 1");
$stmt->execute();
$administrador = $stmt->fetch(PDO::FETCH_ASSOC);
$totalAdmins = $administrador['total'];

$adminLogIn = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/formRegistro.css?v=<?php echo time(); ?>">
</head>
<body>
  <!-- Encabezado -->
  <?php include '../shared/header.php'; ?>
    <!---FIN ENCABEZADO-->
<div class="registroForm">
    
    <?php if($adminLogIn):?>
    <!-- Pestañas -->
    <div class="tabs">
        <div class="tab active" data-tab="usuario">Usuario</div>
        <div class="tab" data-tab="administrador">Administrador</div>
        <div class="tab" data-tab="corporativo">Corporativo</div>
    </div>

    <form method="POST" action="registroDB.php">
        <!-- USUARIO -->
        <div class="tab-content active" id="usuario">
            <?php include 'formComposeBase.php'; ?>
            <input type="hidden" name="isAdmin" value="0">
        </div>

        <!-- ADMINISTRADOR -->
        <div class="tab-content" id="administrador">
            <?php include 'formComposeAdmin.php'; ?>
            <input type="hidden" name="isAdmin" value="1">
        </div>

        <!-- CORPORATIVO -->
        <div class="tab-content" id="corporativo">
            <?php include 'formComposeBase.php'; ?>
            <input type="hidden" name="isAdmin" value="2">
            <button id="btnRegistro" type="submit">REGISTRAR</button>
        </div>

        
        </form>

    <?php elseif ($totalAdmins == 0): ?>
        <form method="POST" action="registroDB.php">
            <h1>BIENVENIDO, ADMINISTRADOR</h1>
            <label class="registerName">Nombre:</label>
            <input type="text" name="nombre" required>

            <label class="registerName">Primer Apellido:</label>
            <input type="text" name="apellido1" required>

            <label class="registerName">Email:</label>
            <input type="email" name="email" required>

            <label class="registerName">Contraseña:</label>
            <input type="password" name="password" required>
            <input type="hidden" name="isAdmin" value="1">
            <button id="btnRegistro" type="submit">REGISTRARSE</button>
        </div>
       
        </form>

    <?php elseif (!$adminLogIn): ?>
        <form method="POST" action="registroDB.php">
            <h1>REGISTRATE</h1>
            <label class="registerName">Nombre:</label>
            <input type="text" name="nombre" required>

            <label class="registerName">Primer Apellido:</label>
            <input type="text" name="apellido1" required>

            <label class="registerName">Segundo Apellido:</label>
            <input type="text" name="apellido2" required>

            <label class="registerName">Email:</label>
            <input type="email" name="email" required>

            <label class="registerName">Contraseña:</label>
            <input type="password" name="password" required>

            <label class="registerName">Dirección:</label>
            <input type="text" name="direccion" required>

            <label class="registerName">Código Postal:</label>
            <input type="text" name="codigoPostal" required>

            <label class="registerName">Ciudad:</label>
            <input type="text" name="ciudad" required>

            <label class="registerName">País:</label>
            <input type="text" name="pais" required>

            <input type="hidden" name="isAdmin" value="0">
            <button id="btnRegistro" type="submit">REGISTRARSE</button>
            
        </form>
    <?endif?>

    
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Obtener los parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const registrado = urlParams.get('registro');
    const nombre = urlParams.get('nombre');
    const isAdmin = urlParams.get('isAdmin');

    // Verificar si la URL contiene los parámetros
    if (registrado === "registrado" && nombre && isAdmin !== null) {
        let tipoUsuario = ""; // Usuario, saldrá vacío
        if (isAdmin === "1") tipoUsuario = "Administrador";
        else if (isAdmin === "2") tipoUsuario = "Corporativo";

        // Mostrar alerta con el popup
        alert(`¡${nombre}, ${tipoUsuario} ha sido registrado con éxito!`);

        // Limpiar la URL para evitar mostrar el popup dos veces
        const nuevaURL = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, nuevaURL);
    }
});
</script>
<script src="../js/script.js"></script>


</body>
</html>
