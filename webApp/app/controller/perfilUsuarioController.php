<?php
session_start();
require_once '../model/perfilUsuarioModel.php';
require_once '../view/perfilUsuarioView.php';

// Verificación de sesión
if (!isset($_SESSION['userName']) || $_SESSION['isAdmin'] != 0) {
    header("Location: ../view/login.php?error=acceso_denegado");
    exit;
}

$model = new PerfilUsuarioModel();
$userNameOriginal = $_SESSION['userName'];

// Obtener datos actuales del usuario
$usuario = $model->obtenerUsuarioPorNombre($userNameOriginal);
if (!$usuario) {
    $usuario = [
        'nombre' => '',
        'apellido1' => '',
        'apellido2' => '',
        'direccion' => '',
        'codigoPostal' => '',
        'ciudad' => '',
        'pais' => '',
        'email' => '',
        'password' => ''
    ];
}

$actualizado = false;

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => $_POST['nombre'] ?? '',
        'apellido1' => $_POST['apellido1'] ?? '',
        'apellido2' => $_POST['apellido2'] ?? '',
        'direccion' => $_POST['direccion'] ?? '',
        'codigoPostal' => $_POST['codigoPostal'] ?? '',
        'ciudad' => $_POST['ciudad'] ?? '',
        'pais' => $_POST['pais'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? ''
    ];

    try {
        $model->actualizarUsuario($datos, $userNameOriginal);

        // Actualizar sesión si cambia el nombre
        if ($datos['nombre'] !== $userNameOriginal) {
            $_SESSION['userName'] = $datos['nombre'];
        }

        $actualizado = true;
        $usuario = $model->obtenerUsuarioPorNombre($datos['nombre']);
    } catch (PDOException $e) {
        echo "Error al actualizar el perfil: " . $e->getMessage();
    }
}

// Mostrar la vista
mostrarVistaPerfilUsuario($usuario, $actualizado);
?>
<?php