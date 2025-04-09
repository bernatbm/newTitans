<?php
require_once '../model/database.php'; // Asumiendo que tienes el archivo Database.php

// Recoger los datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellido1 = $_POST['apellido1'] ?? '';
$apellido2 = $_POST['apellido2'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$codigoPostal = $_POST['codigoPostal'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$pais = $_POST['pais'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validar campos
if (
    empty($nombre) || empty($apellido1) || empty($apellido2) || empty($direccion) ||
    empty($codigoPostal) || empty($ciudad) || empty($pais) || empty($email) || empty($password)
) {
    echo "Por favor ingrese todos los campos obligatorios.";
    exit;
}


// Verificar que los campos no estén vacíos
if (empty($nombre) || empty($apellido1) || empty($email) || empty($password)) {
    die('Por favor ingrese todos los campos obligatorios.');
}


// Insertar el nuevo usuario en la base de datos
$db = new Database();
$conn = $db->getConn();

try {
    // Preparar la sentencia SQL para insertar los datos en la tabla
    $stmt = $conn->prepare("INSERT INTO transfer_viajeros 
                            (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, isAdmin)
                            VALUES (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, :ciudad, :pais, :email, :password, :isAdmin)");

    // Vincular los valores a los parámetros de la consulta
    $stmt->bindValue(':nombre', $_POST['nombre']);
    $stmt->bindValue(':apellido1', $_POST['apellido1']);
    $stmt->bindValue(':apellido2', $_POST['apellido2']);
    $stmt->bindValue(':direccion', $_POST['direccion']);
    $stmt->bindValue(':codigoPostal', $_POST['codigoPostal']);
    $stmt->bindValue(':ciudad', $_POST['ciudad']);
    $stmt->bindValue(':pais', $_POST['pais']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':password', $_POST['password']); 
    $stmt->bindValue(':isAdmin', 0); 

    // Ejecutar la consulta
    $stmt->execute();

    echo "Registro exitoso!";
} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}
?>
