<?php

require_once '../model/database.php';

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
// Si el destino es transfer_administradores, aseguramos que la tabla y las columnas necesarias existen
if ($tablaUser === 'transfer_administradores') {
    // Comprobamos si la tabla 'transfer_administradores' existe
    $checkTableSQL = "
        SELECT COUNT(*) AS existe 
        FROM information_schema.TABLES 
        WHERE TABLE_NAME = 'transfer_administradores' 
        AND TABLE_SCHEMA = 'dataBaseNewTitans';
    ";
    $result = $conn->query($checkTableSQL);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Si la tabla no existe, la creamos
    if ($row['existe'] == 0) {
        $createTableSQL = "
            CREATE TABLE transfer_administradores (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(255) NOT NULL,
                apellido1 VARCHAR(255) NOT NULL,
                apellido2 VARCHAR(255),
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                isAdmin TINYINT DEFAULT 1
            );
        ";
        $conn->exec($createTableSQL);
    }

    // Comprobamos si la columna 'isAdmin' existe en la tabla
    $checkColumnSQL = "
        SELECT COUNT(*) AS existe 
        FROM information_schema.COLUMNS 
        WHERE TABLE_NAME = 'transfer_administradores' 
        AND COLUMN_NAME = 'isAdmin' 
        AND TABLE_SCHEMA = 'dataBaseNewTitans';
    ";
    $result = $conn->query($checkColumnSQL);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Si la columna 'isAdmin' no existe, la agregamos
    if ($row['existe'] == 0) {
        $conn->exec("ALTER TABLE transfer_administradores ADD isAdmin TINYINT DEFAULT 1");
    }

    // Comprobamos si faltan otras columnas necesarias
    $columnsToCheck = ['nombre', 'apellido1', 'apellido2', 'email', 'id', 'password']; // Puedes agregar más columnas si es necesario
    foreach ($columnsToCheck as $column) {
        $checkColumnSQL = "
            SELECT COUNT(*) AS existe 
            FROM information_schema.COLUMNS 
            WHERE TABLE_NAME = 'transfer_administradores' 
            AND COLUMN_NAME = '$column' 
            AND TABLE_SCHEMA = 'dataBaseNewTitans';
        ";
        $result = $conn->query($checkColumnSQL);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Si la columna no existe, la agregamos
        if ($row['existe'] == 0) {
            switch ($column) {
                case 'nombre':
                case 'apellido1':
                case 'apellido2':
                    $conn->exec("ALTER TABLE transfer_administradores ADD $column VARCHAR(255) NOT NULL");
                    break;
                case 'email':
                    $conn->exec("ALTER TABLE transfer_administradores ADD $column VARCHAR(255) NOT NULL");
                    break;
                case 'id':
                    $conn->exec("ALTER TABLE transfer_administradores ADD $column INT NOT NULL");
                    break;
                case 'password':
                    $conn->exec("ALTER TABLE transfer_administradores ADD $column VARCHAR(255) NOT NULL");
                    break;
            }
        }
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

    header("Location: ../model/login.php?registro=registrado&nombre=$nombre&isAdmin=$isAdmin");
    exit();

} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}
?>
