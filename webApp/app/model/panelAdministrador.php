<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../shared/header.php'; ?>

<main>
    <h1>PANEL DE ADMINISTRADOR</h1>
    <p>Bienvenido, aquí puedes crear y gestionar reservas.</p>
</main>

</body>
</html>