<?php
session_start();
require_once '../model/database.php'; 
require_once '../controller/travellerController.php'; 

// conexión a la base de datos
$db = new database(); // database
$conn = $db->getConn(); //conexión database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';

    
    if ($conn) {
        $controller = new travellerController($conn); 
        $resultado = $controller->loginTraveller($usuario, $password);

        if ($resultado['success']) {
            $_SESSION['userName'] = $resultado['user']['nombre']; // Aqui busca el nombre
            $_SESSION['isAdmin'] = $resultado['user']['isAdmin']; //Aqui busca si es Admin[0: No Admin,1:[Admin]]
            

            header("Location: perfil.php"); //Si se hace match, va al perfil de usuario
            exit;//Corto y cambio
        } 
    } else {
       
        $error = 'No hay conexión a la database';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isla Transfers</title>
    <link rel="stylesheet" href="../css/formLogIn.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="titleLogo">
        <img src="../assets/imagenes/newTitans.svg" class="service-img">
        <a href="../index.php"><h1>Isla Transfers</h1></a>
        </div>
        <nav>
            <!--Este de aqui lo he dejado por si acaso(Se que si esta logeado, no saldrá esta pantalla-->
    <?php if (isset($_SESSION['userName'])): ?>
        
             <span><a href="./model/perfil.php"><?php echo "Hola, " . strtoupper($_SESSION['userName']); ?></a></span>
             <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
            <p class="admin-label">[ Admin ]</p>
        <?php endif; ?>

                <!-- Hacef Log OUT o Cerral Sesión -->
                <a href="logout.php">CERRAR SESIÓN</a>
            <?php else: ?>
                <!-- Si no hay usuario, REGISTRO y/o LOGIN -->
                <a href="../registro/registro.php">REGISTRO</a>
                <a href="../model/login.php">LOGIN</a>
            <?php endif; ?>
        </nav>
    </header>

    <!--FORMULARIO DE LOGIN--->

    <div class="LogInForm">
        <h1>LOG IN</h1>
        <form method="POST" action="login.php">
            <label class="Name">Usuario:</label>
            <input type="text" name="user" required>
            <label class="Name">Contraseña</label><br>
            <input type="password" name="password" required><br>

            <button type="submit" id="btnLogIn">ENTRAR</button>
        </form>

        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p> 
        <?php endif; ?>
    </div>
</body>
</html>
