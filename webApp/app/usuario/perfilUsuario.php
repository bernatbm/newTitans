<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 0) {
    header("Location: login.php?error=acceso_denegado");
    exit;
}
require_once '../model/database.php';

$db = new Database();
$conn = $db->getConn();

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
    <h1 class="pa-h1">Perfil de Usuario</h1>
    <p class="pa-p1">Bienvenid@, aquí puedes crear y gestionar tus reservas</p>

    <ul class="user-panel-menu">
        <li><a href="../controller/reservasUsuarioController.php">📄 Mis reservas</a></li>
        <li><a href="../view/nuevaResUsuarioView.php">➕ Nueva reserva</a></li>
        <li><a href="../controller/perfilUsuarioController.php">👤 Editar perfil</a></li>
    </ul>


</main>
</body>
</html>
<?php