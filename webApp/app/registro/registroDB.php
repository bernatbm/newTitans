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
$nombreEmpresa = $_POST['nombre_empresa'] ?? '';


// Validar campos obligatorios
if ($isAdmin == 1) {
    // Registro de administrador solo requiere nombre, apellido1, email, password
    if (empty($nombre) || empty($apellido1) || empty($email) || empty($password)) {
        echo "Por favor,Administrador, ingrese todos los campos obligatorios.";
        exit;
    }
} elseif ($isAdmin == 2) {
   
    if (empty($nombreEmpresa) || empty($email) || empty($password)) {
        echo "Por favor,UserCorp, ingrese todos los campos obligatorios";
        exit;
    }
    }else {
    // Usuario o corporativo requieren todos los campos
    if (
        empty($nombre) || empty($apellido1) || empty($apellido2) || empty($direccion) ||
        empty($codigoPostal) || empty($ciudad) || empty($pais) || empty($email) || empty($password)
    ) {
        echo "Por favor, ingrese todos los campos obligatorios.";
        exit;
    }
}

$db = new Database();
$conn = $db->getConn();

// Determinar tabla destino
$tablaUser = ($isAdmin == 1) ? 'transfer_administradores' : (($isAdmin == 2) ? 'transfer_corporativos' : 'transfer_viajeros');


// Validar si el email ya existe en la tabla correspondiente
$checkEmail = $conn->prepare("SELECT COUNT(*) FROM $tablaUser WHERE email = :email");
$checkEmail->bindParam(':email', $email);
$checkEmail->execute();
$emailExiste = $checkEmail->fetchColumn();

if ($emailExiste > 0) {
    $error = urlencode("El usuario con este email ya existe.");
    header("Location: ../view/registroView.php?error=$error");
    exit;
}
if ($tablaUser === 'transfer_corporativos') {
    // Verificar si la columna id_corporativo ya es autoincremental
    $checkColumnSQL = "
        SELECT COLUMN_NAME, EXTRA 
        FROM information_schema.COLUMNS 
        WHERE TABLE_NAME = 'transfer_corporativos' 
        AND COLUMN_NAME = 'id_corporativo' 
        AND TABLE_SCHEMA = 'dataBaseNewTitans';
    ";
    $result = $conn->query($checkColumnSQL);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Si la columna no es autoincremental, la modificamos
    if (strpos($row['EXTRA'], 'auto_increment') === false) {
        $conn->exec("ALTER TABLE transfer_corporativos MODIFY COLUMN id_corporativo INT AUTO_INCREMENT PRIMARY KEY");
    }
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
}elseif ($tablaUser === 'transfer_corporativos') {
    $checkColumnSQL = "
        SELECT COUNT(*) AS existe 
        FROM information_schema.COLUMNS 
        WHERE TABLE_NAME = 'transfer_corporativos' 
        AND COLUMN_NAME = 'isAdmin' 
        AND TABLE_SCHEMA = 'dataBaseNewTitans';
    ";
    $result = $conn->query($checkColumnSQL);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row['existe'] == 0) {
        $conn->exec("ALTER TABLE transfer_corporativos ADD isAdmin TINYINT DEFAULT 2");
    }
}

try {
    // ADMINISTRADORES
    if ($tablaUser === 'transfer_administradores') {
        $stmt = $conn->prepare("INSERT INTO $tablaUser 
            (nombre, apellido1, email, password,isAdmin)
            VALUES (:nombre, :apellido1, :email, :password,:isAdmin)");
        
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':apellido1', $apellido1);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':isAdmin', $isAdmin);
    } elseif (($tablaUser === 'transfer_corporativos') ) {
        // Para la tabla CORPORATIVOS
        $stmt = $conn->prepare("INSERT INTO $tablaUser 
            (nombre_empresa, email, password, isAdmin)
            VALUES (:nombre_empresa, :email, :password, :isAdmin)");
    
        $stmt->bindValue(':nombre_empresa', $nombreEmpresa);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password); 
        $stmt->bindValue(':isAdmin', $isAdmin); 
    }else{
         // PARA USERS
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

    if (empty($nombre) && $isAdmin == 2) {
        $nombre = urlencode($nombreEmpresa);
    } else {
        $nombre = urlencode($nombre);
    }
    $isAdmin = urlencode($isAdmin);
   
   $controller->nextPage($nombre, $isAdmin);

    

} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}
?>