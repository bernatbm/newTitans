<?php
require_once '../model/database.php';
session_start();

$db = new Database();
$conn = $db->getConn();

if ($emailExiste > 0) {

    $getUser = $conn->prepare("SELECT * FROM $tablaUser WHERE email = :email");
    $getUser->bindParam(':email', $email);
    $getUser->execute();
    $usuarioExistente = $getUser->fetch(PDO::FETCH_ASSOC);
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $codigoPostal = $_POST['codigoPostal'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $conn->prepare("UPDATE transfer_viajeros SET 
            nombre = :nombre, 
            apellido1 = :apellido1, 
            apellido2 = :apellido2, 
            direccion = :direccion, 
            codigoPostal = :codigoPostal, 
            ciudad = :ciudad, 
            pais = :pais, 
            email = :email, 
            password = :password
            WHERE id = :id");

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':codigoPostal', $codigoPostal);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); 
        $stmt->bindParam(':id', $userId);

        $stmt->execute();

        header("Location: perfil.php?actualizado=1");
        exit;

    } catch (PDOException $e) {
        echo "Error al actualizar el perfil: " . $e->getMessage();
    }
}
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
    <h1 class="pa-h1">Editar Perfil</h1>
    <p class="pa-p1">Aquí puedes editar tu perfil de usuario</p>

    <?php if (isset($_GET['actualizado'])): ?>
        <p class="pa-p1">Perfil actualizado correctamente.</p>
    <?php endif; ?>
<form class="editar-formulario" method="POST" action="editarPerfil.php">
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
    <a href="perfilUsuario.php" class="btn-cancelar">Cancelar</a>

</form>

<?php