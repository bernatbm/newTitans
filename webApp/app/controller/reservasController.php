<?php
require_once '../model/database.php';
require_once '../model/reservasModel.php';
require_once __DIR__ . '/enviarMail.php';

class ReservasController {

    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); 
        }
        $db = new Database();
        $conn = $db->getConn();
        $this->model = new ReservasModel($conn);
    }
    public function procesarReserva() {
        if (!isset($_SESSION['userName'])) {
            header("Location: ../view/login.php?error=acceso_denegado");
            exit;
        }
    
        $datos = $_POST;
    
        // Si es una ACTUALIZACIÓN (existe id_reserva)
        if (!empty($datos['id_reserva'])) {
            $id = $datos['id_reserva'];
    
            // Validar que el usuario es dueño o admin
            if ($_SESSION['isAdmin'] != 1) {
                $reserva = $this->model->obtenerReservaPorId($id);
                
            }
    
            // Actualizar reserva
            if ($this->model->actualizarReserva($id, $datos)) {
                $redirectUrl = ($_SESSION['isAdmin'] == 1)
                    ? "../admin/panelAdministrador.php?mensaje=actualizado"
                    : "../usuario/perfilUsuario.php?mensaje=actualizado";
                header("Location: $redirectUrl");
            } else {
                echo "<p class='error'>❌ Error al actualizar la reserva.</p>";
            }
            exit;
        } 
        // Bloque de CREACIÓN
        else {
            $tipoReserva = $datos['id_tipo_reserva'] ?? null;
    
            if ($tipoReserva == '1') {
                $localizador = $this->model->addAeropuertoHotel();
            } elseif ($tipoReserva == '2') {
                $localizador = $this->model->addHotelAeropuerto();
            } else {
                $localizador = $this->model->addIdaVuelta();
            }
    
            enviarCorreoReserva($emailCliente, $datos);
    
            $redirectUrl = ($_SESSION['isAdmin'] == 1)
                ? "../admin/panelAdministrador.php?reservado=ok&localizador=$localizador"
                : "../usuario/perfilUsuario.php?reservado=ok&localizador=$localizador";
            header("Location: $redirectUrl");
            exit;
        }
    }
    
    public function verReserva($id) {
       
        $reserva = $this->model->obtenerReservaPorId($id);
    
        if ($reserva) {
            require '../view/verReservaView.php';
        } else {
            echo "❌ Reserva no encontrada.";
        }
    }
    
    

    public function listarReservas() {
        
        $reservas = $this->model->obtenerTodasLasReservas();
        require_once '../view/listarReservasView.php';
    }
    //Creo que se puede deletear.
    public function updateReservas($id, $datos) {
        if (!$id || empty($datos)) {
            echo "ID o datos de reserva no proporcionados.";
            exit;
        }
    
        $resultado = $this->model->actualizarReserva($id, $datos);
    
       
        header("Location: ../public/verReserva.php?id=" . $id . "&mensaje=Reserva%20Actualizada");
        exit;
    }
    public function eliminarReserva() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "<p style='color: red;'>❌ ID de reserva no válido.</p>";
            return;
        }

        $id = (int)$_GET['id'];

        if ($this->model->deleteReserva($id)) {
            $redirectUrl = ($_SESSION['isAdmin'] == 1)
                ? "../admin/panelAdministrador.php?mensaje=eliminado"
                : "../usuario/perfilUsuario.php?mensaje=eliminado";
            header("Location: $redirectUrl");
            exit;
        } else {
            echo "<p style='color: red;'>❌ Error al borrar la reserva.</p>";
        }
    }

public function listarReservasUsuario() {
    if (!isset($_SESSION['userName']) || $_SESSION['isAdmin'] != 0) {
        header("Location: ../view/login.php?error=acceso_denegado");
        exit;
    }

    try {
        $userName = $_SESSION['userName'];
        $email = $this->model->obtenerEmailPorNombre($userName);
        $reservas = $this->model->obtenerReservasPorEmail($email);

        if (!$reservas) {
            header("Location: ../view/reservasUsuarioSinResultados.php");
            exit;
        }

        $etiquetas = [
            'id_reserva' => 'Número de reserva',
            'localizador' => 'Localizador',
            'id_hotel' => 'ID Hotel',
            'id_tipo_reserva' => 'Tipo de reserva (ID)',
            'tipo_reserva_desc' => 'Tipo de reserva',
            'email_cliente' => 'Email del cliente',
            'fecha_reserva' => 'Fecha de reserva',
            'fecha_modificacion' => 'Fecha de modificación',
            'id_destino' => 'Destino',
            'fecha_entrada' => 'Fecha de entrada',
            'hora_entrada' => 'Hora de entrada',
            'numero_vuelo_entrada' => 'Número de vuelo (ida)',
            'origen_vuelo_entrada' => 'Origen del vuelo',
            'hora_vuelo_salida' => 'Hora del vuelo de salida',
            'fecha_vuelo_salida' => 'Fecha del vuelo de salida',
            'num_viajeros' => 'Número de viajeros',
            'id_vehiculo' => 'ID Vehículo',
            'numero_vuelo_salida' => 'Número de vuelo (vuelta)',
            'hora_recogida' => 'Hora de recogida'
        ];

        require_once '../view/reservasUsuarioView.php';
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}

public function editar() {
    if (!isset($_SESSION['userName'])) {
        header("Location: ../view/login.php?error=acceso_denegado");
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id || !is_numeric($id)) {
        header("Location: ../usuario/perfilUsuario.php?error=id_invalido");
        exit;
    }

    $reserva = $this->model->obtenerReservaPorId($id);
    
    if (!$reserva) {
        header("Location: ../usuario/perfilUsuario.php?error=reserva_no_encontrada");
        exit;
    }

   
    require '../view/editarReservaView.php';
}


private $errores = [
    'acceso_denegado' => '❌ Acceso denegado',
    'reserva_no_encontrada' => '❌ Reserva no encontrada',
    'no_autorizado' => '❌ No tienes permisos para esta acción'
];

}


 $controller = new ReservasController();

 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->procesarReserva();
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'eliminar':
            $controller->eliminarReserva();
            break;
        case 'editar':
            $controller->editar();
            break;
        case 'listarUsuario':
            $controller->listarReservasUsuario();
            break;
        case 'listar':
            $controller->listarReservas();
            break;
    }
}

