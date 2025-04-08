<?php
// Incluir configuración
require_once 'config.php';

// Crear conexión usando los datos del archivo config.php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";

// Aquí puedes realizar consultas SQL o lógica adicional

$conn->close(); // Cerrar conexión
?>
