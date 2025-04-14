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
 <!-- Encabezado -->
 <?php include '../shared/header.php'; ?>
    <!---FIN ENCABEZADO-->


    <!--EL FORM DEL REGISTRO-->
    <div class="registroForm">
    <h1>REGISTRAR USUARIO</h1>
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

    <?php if ($totalAdmins == 0): ?>
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
    <?php endif; ?> <!-- Aquí cerramos el 'if' correctamente -->

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
<script>
    <?php if (isset($_GET['error'])): ?>
        // Mostrar el mensaje de error en un popup
        alert("<?php echo htmlspecialchars($_GET['error']); ?>");

        // Limpiar la URL para que no se muestre dos veces el popup
        const nuevaURL = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, nuevaURL);
    <?php endif; ?>
</script>

<script src="../js/script.js"></script><!--Va al script.js, para realizar el popup y abrirla-->


</body>

</html>