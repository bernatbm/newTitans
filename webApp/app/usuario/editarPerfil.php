<?php
require_once '../model/database.php';
session_start();

<<<<<<< HEAD
$db = new Database();
$conn = $db->getConn();

if ($emailExiste > 0) {

    $getUser = $conn->prepare("SELECT * FROM $tablaUser WHERE email = :email");
    $getUser->bindParam(':email', $email);
    $getUser->execute();
    $usuarioExistente = $getUser->fetch(PDO::FETCH_ASSOC);
}

// Procesar actualización
=======
// 1. Comprobar si el usuario está logueado
if (!isset($_SESSION['email'])) {
    echo "Debes iniciar sesión para ver tu perfil.";
    exit;
}

$email_usuario = $_SESSION['email'];
$db = new Database();
$conn = $db->getConn();

// 2. Obtener datos del usuario
$tablaUser = 'transfer_viajeros'; // Cambia esto si tu tabla tiene otro nombre

$getUser = $conn->prepare("SELECT * FROM $tablaUser WHERE email = :email");
$getUser->bindParam(':email', $email_usuario);
$getUser->execute();
$usuario = $getUser->fetch(PDO::FETCH_ASSOC);

// Si no hay usuario, define un array vacío para evitar errores en el formulario
if (!$usuario) {
    $usuario = [
        'nombre' => '',
        'apellido1' => '',
        'apellido2' => '',
        'direccion' => '',
        'codigoPostal' => '',
        'ciudad' => '',
        'pais' => '',
        'email' => $email_usuario,
        'password' => ''
    ];
}

// 3. Procesar actualización del perfil
>>>>>>> 4b44858c71d8a0dd944137cca2377773d65cc230
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
<<<<<<< HEAD
        $stmt = $conn->prepare("UPDATE transfer_viajeros SET 
=======
        $stmt = $conn->prepare("UPDATE $tablaUser SET 
>>>>>>> 4b44858c71d8a0dd944137cca2377773d65cc230
            nombre = :nombre, 
            apellido1 = :apellido1, 
            apellido2 = :apellido2, 
            direccion = :direccion, 
            codigoPostal = :codigoPostal, 
            ciudad = :ciudad, 
            pais = :pais, 
            email = :email, 
            password = :password
<<<<<<< HEAD
            WHERE id = :id");
=======
            WHERE email = :email_usuario");
>>>>>>> 4b44858c71d8a0dd944137cca2377773d65cc230

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':codigoPostal', $codigoPostal);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); 
<<<<<<< HEAD
        $stmt->bindParam(':id', $userId);

        $stmt->execute();

        header("Location: perfil.php?actualizado=1");
=======
        $stmt->bindParam(':email_usuario', $email_usuario);

        $stmt->execute();

        // Actualiza el email en la sesión si el usuario lo cambió
        $_SESSION['email'] = $email;

        header("Location: editarPerfil.php?actualizado=1");
>>>>>>> 4b44858c71d8a0dd944137cca2377773d65cc230
        exit;

    } catch (PDOException $e) {
        echo "Error al actualizar el perfil: " . $e->getMessage();
    }
}
?>

<<<<<<< HEAD
=======

>>>>>>> 4b44858c71d8a0dd944137cca2377773d65cc230
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
<<<<<<< HEAD
<form class="editar-formulario" method="POST" action="editarPerfil.php">
=======
    <form class="editar-formulario" method="POST" action="editarPerfil.php">
>>>>>>> 4b44858c71d8a0dd944137cca2377773d65cc230
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
<<<<<<< HEAD

</form>

=======
</form>


>>>>>>> 4b44858c71d8a0dd944137cca2377773d65cc230
<?php