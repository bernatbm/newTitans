<?php
session_start();

if (!isset($_SESSION['userName'])) {
    header("Location: login.php");// Si no hay sesión activa, redirige al login(Precausioon)
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo $_SESSION['userName']; ?> - Isla Transfers</title> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Encabezado -->
    <header>
    <div class="titleLogo">
        <img src="../assets/imagenes/newTitans.svg" class="service-img">
        <a href="../index.php"><h1>Isla Transfers</h1></a>
        </div>
        <nav>
    <?php if (isset($_SESSION['userName'])): ?>
        <a href="../registro/registro.php">REGISTRO</a>
             <span><a href="perfil.php"><?php echo "Hola, " . strtoupper($_SESSION['userName']); ?></a></span>
             <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
            <p class="admin-label">[ Admin ]</p>
            <?php elseif (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 2): ?>
            <p class="admin-label">[ Corp ]</p>
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
            
    
</body>
</html>
