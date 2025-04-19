<?php
session_start();
require_once '../model/database.php';
require_once '../model/travellerModel.php';

class TravellerController {

    private $model;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConn();
        $this->model = new TravellerModel($conn);
    }

    public function logIn() {
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
        if (!isset($_POST['user']) || !isset($_POST['password'])) {
            echo 'Faltan datos';
            return;
        }

        $usuario = $_POST['user'];
        $password = $_POST['password'];

        $resultado = $this->model->loginUnificado($usuario, $password);

        if ($resultado['success']) {
            $_SESSION['userName'] = $resultado['user']['nombre'];
            $_SESSION['isAdmin'] = $resultado['user']['isAdmin'];

            // Redirección según el tipo de usuario
            if ($_SESSION['isAdmin'] == 1) {
                header("Location: ../admin/panelAdministrador.php");
            } elseif ($_SESSION['isAdmin'] == 2) {
                header("Location: ../view/panelCorpView.php");
            } else {
                header("Location: ../usuario/perfilUsuario.php");
            }
            exit;
        } else {
            // Login fallido
            header("Location: ../view/login.php?error=1");
            exit;
        }
    }

    public function emailExist() {
        $this->model->emailExist();
    }
}

// Llamador del controlador por acción
if (isset($_GET['accion'])) {
    $controller = new TravellerController();

    switch ($_GET['accion']) {
        case 'checkEmail':
            $controller->emailExist();
            break;
        case 'login':
            $controller->logIn();
            break;
    }
}
