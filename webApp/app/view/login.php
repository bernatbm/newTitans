<?php
require_once '../model/database.php'; 
require_once '../controller/travellerController.php'; 

// Verificar si hay parámetros en la URL (registrado exitosamente)
if (isset($_GET['registro']) && $_GET['registro'] == 'registrado') {
    $nombre = $_GET['nombre'];
    $isAdmin = $_GET['isAdmin'];
    $tipoUsuario = ($isAdmin == '1') ? 'Administrador' : (($isAdmin == '2') ? 'Corporativo' : 'Usuario');

    // Mostrar alerta con mensaje de éxito
    echo "<script>
            window.addEventListener('DOMContentLoaded', function() {
                alert('¡$nombre, $tipoUsuario ha sido registrado con éxito!');
            });
          </script>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isla Transfers</title>
    <link rel="stylesheet" href="../css/formLogIn.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>

      <!-- Encabezado -->
    <?php include '../shared/header.php'; ?>
    <!---FIN ENCABEZADO-->

    <div class="LogInForm">
    <h1>LOG IN</h1>
    <form method="POST" action="../controller/travellerController.php?accion=login">
        <label class="Name">Usuario:</label>
        <input type="text" name="user" required>
        <label class="Name">Contraseña</label><br>
        <input type="password" name="password" required><br>
        <input type="hidden" name="isAdmin" value="2">
    
        <div class="botones">
            <button type="submit" id="btnLogIn">ENTRAR</button>
            <a href="../view/registroView.php" id="btnRegistrarse">REGISTRARSE</a>
        </div>
    </form>
         <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p> 
        <?php endif; ?>
    </div>
    <?php 
if (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            alert("Usuario o contraseña incorrectos.");
        });
    </script>
<?php endif; ?>
</body>
</html>
