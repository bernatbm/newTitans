<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isla Transfers</title>
    <link rel="stylesheet" href="../css/formRegistro.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="titleLogo">
        <img src="../assets/imagenes/newTitans.svg" class="service-img">
        <a href="../index.php"><h1>Isla Transfers</h1></a>
        </div>
        <nav>
    <?php if (isset($_SESSION['userName'])): ?>
             <span><a href="../model/perfil.php"><?php echo "Hola, " . strtoupper($_SESSION['userName']); ?></a></span>
             <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
            <p class="admin-label">[ Admin ]</p>
            <?php elseif (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 2): ?>
            <p class="admin-label">[ Corp ]</p>
        
        <?php endif; ?>

                <!-- Hacef Log OUT o Cerral Sesión -->
                <a href="../model/logout.php">CERRAR SESIÓN</a>
            <?php else: ?>
                <!-- Si no hay usuario, REGISTRO y/o LOGIN -->
                <a href="../registro/registro.php">REGISTRO</a>
                <a href="../model/login.php">LOGIN</a>
            <?php endif; ?>
        </nav>
    </header>
    <!--EL FORM DEL REGISTRO-->
    <div class="registroForm">
    <h1>REGISTRAR USUARIO</h1>
    <form method="POST" action="registroDB.php">
    <label class="Name">Nombre:</label>
    <input type="text" name="nombre" required>
    <label class="Name">Primer Apellido:</label>
    <input type="text" name="apellido1" required>
    <label class="Name">Segundo Apellido:</label>
    <input type="text" name="apellido2" required>
    <label class="Name">Email</label>
    <input type="email" name="email" required>
    <label class="Name">Contraseña</label><br>
    <input type="password" name="password" required><br>
    <label class="Name"> Dirección</label>
    <input type="text" name="direccion" required>
    <label class="Name">Codigo Postal:</label>
    <input type="text" name="codigoPostal" required>
    <label class="Name">Ciudad:</label>
    <input type="text" name="ciudad" required>
    <label class="Name">País:</label>
    <input type="text" name="pais" required>
    <label class="Name">¿Tipo Usuario?:</label>
    <select name="isAdmin" required>
    <option value="" disabled selected>Selecciona tipo Usuario</option>
    <option value="1">Administrador</option>
    <option value="0">Usuario</option>
    <option value="2">Corporativo</option>
</select>

    
    <button type="submit" id="btnRegistro">REGISTRARSE</button>
    </form>
</div>
<!--Si el usuario es registrado, pasara por aquí-->
<?php if (isset($_GET['registro']) && $_GET['registro'] == 'registrado'): ?>
    <script>
        window.registrado = {//preparara una ventana(popup) con los datos de registrado
        
            nombre: "<?php echo htmlspecialchars($_GET['nombre']); ?>", // guardamos el valor de nombre
            isAdmin: "<?php echo htmlspecialchars($_GET['isAdmin']); ?>"//lo mismo con isAdmin
        };
    </script>
<?php endif; ?>
<script src="../js/script.js"></script><!--Va al script.js, para realizar el popup y abrirla



</body>

</html>
