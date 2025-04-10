<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 0) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../shared/header.php'; ?>

<main>
    <h1>PERFIL DE USUARIO</h1>
    <p>Bienvenido, <?php echo strtoupper($_SESSION['userName']); ?>.</p>
    <p>Aquí podrás ver tus reservas, crear nuevas y modificar tu información personal.</p>
</main>

</body>
</html>