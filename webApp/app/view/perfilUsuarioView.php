<?php
function mostrarVistaPerfilUsuario($usuario, $actualizado) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panelUsuario.css">
</head>
<body>
<?php include '../shared/header.php'; ?>

<main class="pa-main">
    <h1 class="pa-h1">Editar Perfil</h1>
    <p class="pa-p1">Aquí puedes editar tu perfil de usuario</p>

    <?php if ($actualizado): ?>
        <p class="perfil-actualizado">✅ Perfil actualizado correctamente.</p>
    <?php endif; ?>

    <form class="editar-formulario" method="POST">
        <label>Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required></label><br>
        <label>Apellido 1: <input type="text" name="apellido1" value="<?= htmlspecialchars($usuario['apellido1']) ?>" required></label><br>
        <label>Apellido 2: <input type="text" name="apellido2" value="<?= htmlspecialchars($usuario['apellido2']) ?>"></label><br>
        <label>Dirección: <input type="text" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>"></label><br>
        <label>Código Postal: <input type="text" name="codigoPostal" value="<?= htmlspecialchars($usuario['codigoPostal']) ?>"></label><br>
        <label>Ciudad: <input type="text" name="ciudad" value="<?= htmlspecialchars($usuario['ciudad']) ?>"></label><br>
        <label>País: <input type="text" name="pais" value="<?= htmlspecialchars($usuario['pais']) ?>"></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required></label><br>
        <label>Contraseña: <input type="password" name="password" value="<?= htmlspecialchars($usuario['password']) ?>" required></label><br>

        <button type="submit">Guardar cambios</button>
        <a href="../usuario/perfilUsuario.php" class="btn-cancelar">Cancelar</a>
    </form>
</main>
</body>
</html>
<?php
