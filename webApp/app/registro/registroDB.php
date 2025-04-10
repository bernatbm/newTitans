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
$isAdmin = $_POST['isAdmin'] ?? '';


// Validamos los campos
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
    // Si la columna no existe, la creamos
    $alterSQL = "ALTER TABLE transfer_viajeros ADD isAdmin TINYINT DEFAULT 0";

    $conn->exec($alterSQL);
}

try {

    // Preparar la sentencia SQL para insertar los datos en la tabla transfer_viajeros(los usuarios)
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
    $stmt->bindValue(':isAdmin',$_POST['isAdmin'] ); 

    // Ejecutar la consulta
    $stmt->execute();
    //Una vez ejecutado la consulta guarda el nombre y el tipo de isAdmin[0:User,1:Admin,2:Corp]
    $nombre = urlencode($_POST['nombre']);
    $isAdmin = urlencode($_POST['isAdmin']);
    header("Location: ../registro/registro.php?registro=registrado&nombre=$nombre&isAdmin=$isAdmin");//vuelve a la página de registro con lo guardado
    exit;

    } catch (PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
?>
