<?php
$servername = "baseDatosNewTitans"; 
$username = "root";
$password = "";
$database = "dataBaseNewTitans";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";
?>
