<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panelUsuario.css">
    </head>
<body>

<?php include '../shared/header.php'; ?>

<main class="pa-main">
    <h1 class="pa-h1">Modificar datos de usuario</h1>
    <p class="pa-p1">Bienvenid@, aquí puedes modificar tus datos</p>
        
    <form method="POST" class="editar-datos-form">
    <label class="Name">Nombre:</label>
    <input type="text" name="nombre" value="" required>

    <label class="Name">Primer Apellido:</label>
    <input type="text" name="apellido1" value="" required>

    <label class="Name">Segundo Apellido:</label>
    <input type="text" name="apellido2" value="" required>

    <label class="Name">Email:</label>
    <input type="email" name="email" value="" required>

    <label class="Name">Dirección:</label>
    <input type="text" name="direccion" value="" required>

    <label class="Name">Código Postal:</label>
    <input type="text" name="codigoPostal" value="" required>

    <label class="Name">Ciudad:</label>
    <input type="text" name="ciudad" value="" required>

    <label class="Name">País:</label>
    <input type="text" name="pais" value="" required>

    <button type="submit">Actualizar</button>
</form>
</main>

</body>
</html>
