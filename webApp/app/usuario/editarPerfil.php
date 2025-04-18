<?php
require_once '../model/database.php';
session_start();
 
// 1. Comprobar si el usuario está logueado
if (!isset($_SESSION['userName']) || $_SESSION['isAdmin'] != 0) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}

$userName_original = $_SESSION['userName'];
$db = new Database();
$conn = $db->getConn();

// 2. Obtener datos del usuario
$tablaUser = 'transfer_viajeros'; 
$getUser = $conn->prepare("SELECT * FROM $tablaUser WHERE nombre = :nombre");
$getUser->bindParam(':nombre', $userName_original);
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
        'email' => '',
        'password' => ''
    ];
}

// 3. Procesar actualización del perfil
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
        $stmt = $conn->prepare("UPDATE $tablaUser SET 
            nombre = :nombre, 
            apellido1 = :apellido1, 
            apellido2 = :apellido2, 
            direccion = :direccion, 
            codigoPostal = :codigoPostal, 
            ciudad = :ciudad, 
            pais = :pais, 
            email = :email, 
            password = :password
            WHERE nombre = :nombre_original"); 

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido1', $apellido1);
        $stmt->bindParam(':apellido2', $apellido2);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':codigoPostal', $codigoPostal);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':nombre_original', $userName_original); 

        $stmt->execute();

        // Actualizar el nombre en sesión si se modificó
        if ($nombre != $userName_original) {
            $_SESSION['userName'] = $nombre;
        }

        header("Location: editarPerfil.php?actualizado=1");
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
    <p class="perfil-actualizado">✅ Perfil actualizado correctamente.</p>
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