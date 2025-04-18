<?php

require_once '../model/database.php';
require_once '../controller/registroController.php';
$controller = new RegistroController;



// Recogemos los datos del form (login.php)
$nombre = $_POST['nombre'] ?? '';
$apellido1 = $_POST['apellido1'] ?? '';
$apellido2 = $_POST['apellido2'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$codigoPostal = $_POST['codigoPostal'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$pais = $_POST['pais'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$isAdmin = $_POST['isAdmin'] ?? 0;

// Validar campos obligatorios
if ($isAdmin == 1) {
    // Registro de administrador solo requiere nombre, apellido1, email, password
    if (empty($nombre) || empty($apellido1) || empty($email) || empty($password)) {
        echo "Por favor ingrese todos los campos obligatorios.";
        exit;
    }
} else {
    // Usuario o corporativo requieren todos los campos
    if (
        empty($nombre) || empty($apellido1) || empty($apellido2) || empty($direccion) ||
        empty($codigoPostal) || empty($ciudad) || empty($pais) || empty($email) || empty($password)
    ) {
        echo "Por favor ingrese todos los campos obligatorios.";
        exit;
    }
}

$db = new Database();
$conn = $db->getConn();

// Determinar tabla destino
$tablaUser = ($isAdmin == 1) ? 'transfer_administradores' : 'transfer_viajeros';

// Validar si el email ya existe en la tabla correspondiente
$checkEmail = $conn->prepare("SELECT COUNT(*) FROM $tablaUser WHERE email = :email");
$checkEmail->bindParam(':email', $email);
$checkEmail->execute();
$emailExiste = $checkEmail->fetchColumn();

if ($emailExiste > 0) {
    $error = urlencode("El usuario con este email ya existe.");
    header("Location: registro.php?error=$error");
    exit;
}



// Si el destino es transfer_viajeros, aseguramos que la columna isAdmin existe
if ($tablaUser === 'transfer_viajeros') {
    $checkColumnSQL = "
        SELECT COUNT(*) AS existe 
        FROM information_schema.COLUMNS 
        WHERE TABLE_NAME = 'transfer_viajeros' 
        AND COLUMN_NAME = 'isAdmin' 
        AND TABLE_SCHEMA = 'dataBaseNewTitans';
    ";
    $result = $conn->query($checkColumnSQL);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row['existe'] == 0) {
        $conn->exec("ALTER TABLE transfer_viajeros ADD isAdmin TINYINT DEFAULT 0");
    }
}

try {
    // Preparar la consulta para la tabla correcta
    if ($tablaUser === 'transfer_administradores') {
        $stmt = $conn->prepare("INSERT INTO $tablaUser 
            (nombre, apellido1, email, password,isAdmin)
            VALUES (:nombre, :apellido1, :email, :password,:isAdmin)");
        
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':apellido1', $apellido1);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':isAdmin', $isAdmin);
    } else {
        // Para la tabla transfer_viajeros, mantenemos los campos originales
        $stmt = $conn->prepare("INSERT INTO $tablaUser 
            (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, isAdmin)
            VALUES (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, :ciudad, :pais, :email, :password, :isAdmin)");
    
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':apellido1', $apellido1);
        $stmt->bindValue(':apellido2', $apellido2);
        $stmt->bindValue(':direccion', $direccion);
        $stmt->bindValue(':codigoPostal', $codigoPostal);
        $stmt->bindValue(':ciudad', $ciudad);
        $stmt->bindValue(':pais', $pais);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password); 
        $stmt->bindValue(':isAdmin', $isAdmin); 
    }
    
    $stmt->execute();

    $nombre = urlencode($nombre);
    $isAdmin = urlencode($isAdmin);
   
   $controller->nextPage($nombre, $isAdmin);

    

} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}
?>
