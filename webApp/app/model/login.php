<?php
session_start();
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
// conexión a la base de datos
$db = new database(); // database
$conn = $db->getConn(); //conexión database
$usuario = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {//Esto luego, cuando demos clic a ENTRAR, si no, entra en bucle cuando busca si es Admin,Corp o User
    if ($conn) {
        $controller = new travellerController($conn); 
        $resultado = $controller->loginTraveller($usuario, $password);

        if ($resultado['success']) {
            $_SESSION['userName'] = $resultado['user']['nombre'];
            $_SESSION['isAdmin'] = $resultado['user']['isAdmin'];
            $_SESSION['email'] = $usuario; 

            // Redirección según el tipo de usuario
            if ($_SESSION['isAdmin'] == 1) {
                header("Location: ../admin/panelAdministrador.php");
            } elseif ($_SESSION['isAdmin'] == 2) {
                header("Location: ../corporativo/panelCorporativo.php");
            } else {
                header("Location: ../usuario/perfilUsuario.php");
            }
            exit;
        } else {
            // Login fallido (usuario o contraseña incorrectos)
            $error = 'Usuario o contraseña incorrectos.';
        }

    } else {
        // Fallo en la conexión a la base de datos
        $error = 'No hay conexión a la base de datos.';
    }
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
        <form method="POST" action="login.php">
            <label class="Name">Usuario:</label>
            <input type="text" name="user" required>
            <label class="Name">Contraseña</label><br>
            <input type="password" name="password" required><br>
        
            <div class="botones">
                <button type="submit" id="btnLogIn">ENTRAR</button>
                <a href="../registro/registro.php" id="btnRegistrarse">REGISTRARSE</a>
            </div>
        </form>

        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p> 
        <?php endif; ?>
    </div>
</body>
</html>
