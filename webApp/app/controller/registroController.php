<?php
session_start();
require_once '../model/database.php'; 
require_once '../model/registroModel.php'; 

class RegistroController {
    private $model;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConn();
        $this->model = new RegistroModel($conn);
    }

    // Método para cargar el registro y ver si el admin está logueado
    public function cargarRegistro() {
        $adminLogIn = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
        $totalAdmins = $this->model->contarAdministradores();

        include '../view/registroView.php';
    }

    
    public function registrarUsuario($datos) {
        
        $this->model->registrarUsuario($datos);
        if($_SESSION[$totalAdmins]==1){
            header("Location: ../view/registroView.php?registro=registrado&nombre=$nombre&isAdmin=$isAdmin");
        }else{
            echo "HOLA QUE TAL";
        }
        
    }
    public function nextPage($nombre, $isAdmin){
        $nombre = urlencode($nombre);
        $isAdmin = urlencode($isAdmin);
        $totalAdmins = $this->model->contarAdministradores();
         
        // Si no hay sesión iniciada, redirige al login
    if (!isset($_SESSION['isAdmin'])) {
        header("Location: ../view/login.php");
        exit;
    }

    // Si hay sesión y el usuario es admin, redirige al registro
    if ($_SESSION['isAdmin'] == 1) {
        header("Location: ../view/registroView.php?registro=registrado&nombre=$nombre&isAdmin=$isAdmin");
        exit;
    }

    // Si ya hay un admin creado o no es admin, también va a login
    if ($totalAdmins >= 1) {
        header("Location: ../view/login.php");
        exit;
    }
    }
}

if (isset($_GET['accion'])) {
    $controller = new RegistroController();
    switch ($_GET['accion']) {
        case 'cargarRegistro':
            $controller->cargarRegistro();
            break;
        case 'registrarUsuario':
            $controller->registrarUsuario($_POST);
            break;
    }
}
?>
