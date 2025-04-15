<?php
// controller/ReservasController.php
require_once '../model/database.php';
require_once '../model/reservasModel.php'; // Incluimos el modelo

class ReservasController {

    private $model;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConn();
        $this->model = new ReservasModel($conn); // Instanciamos el modelo
    }

    // Método para procesar la reserva
    public function procesarReserva() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                // Recogemos los datos enviados
                $tipoReserva = $_POST['id_tipo_reserva'] ?? null;
                $emailCliente = $_POST['email_cliente'] ?? null;

                if (!$tipoReserva || !$emailCliente) {
                    echo "Faltan tipo de reserva o email.";
                    exit;
                }

                // Datos personales del cliente
                $datosPersonales = [
                    'nombre' => $_POST['nombre'] ?? null,
                    'apellido1' => $_POST['apellido1'] ?? null,
                    'apellido2' => $_POST['apellido2'] ?? null,
                    'direccion' => $_POST['direccion'] ?? null,
                    'codigoPostal' => $_POST['codigoPostal'] ?? null,
                    'ciudad' => $_POST['ciudad'] ?? null,
                    'pais' => $_POST['pais'] ?? null,
                    'password' => $_POST['password'] ?? null
                ];

                // Llamamos al modelo para insertar el viajero si no existe
                $this->model->insertarViajeroSiNoExiste($emailCliente, $datosPersonales);

                // Seleccionar un vehículo aleatorio
                $idVehiculo = $this->model->seleccionarVehiculoAleatorio();

                // Fecha de la reserva
                $fechaReserva = date('Y-m-d H:i:s');
                $localizador = $this->model->generarLocalizador();

                // Datos comunes para la reserva
                $comunes = [
                    ':localizador' => $localizador,
                    ':fecha_entrada' => $_POST['fecha_llegada'] ?? $_POST['dia_vuelo'] ?? null,
                    ':hora_entrada' => $_POST['hora_llegada'] ?? $_POST['hora_recogida'] ?? null,
                    ':id_tipo_reserva' => $tipoReserva,
                    ':id_hotel' => $_POST['id_hotel'] ?? null,
                    ':num_viajeros' => $_POST['num_viajeros'] ?? null,
                    ':email_cliente' => $emailCliente,
                    ':id_vehiculo' => $idVehiculo,
                    ':fecha_reserva' => $fechaReserva
                ];

                // Ejecutar la inserción en la base de datos dependiendo del tipo de reserva
                if ($tipoReserva == '1') {
                    // Reserva solo de ida
                    $this->model->insertarReservaIda($comunes, $_POST);
                } else {
                    // Reserva de vuelta
                    $this->model->insertarReservaVuelta($comunes, $_POST);
                }

                // Redirigir con el localizador
                $this->model->redirigirConLocalizador($localizador);

            } catch (PDOException $e) {
                echo "❌ Error al procesar la reserva: " . $e->getMessage();
            }
        } else {
            echo "Método no permitido.";
        }
    }
    public function verReserva($id) {
        // Obtiene la reserva desde el modelo
        $reserva = $this->model->obtenerReservaPorId($id);
        if (!$reserva) {
            echo "❌ No se encontró la reserva.";
            exit;
        }

        // Cargar la vista
        require_once '../view/verReserva.php';
    }
    public function listarReservas() {
        $reservas = $this->model->obtenerTodasLasReservas();
        require_once '../view/listarReservasView.php';
    }
  
    
}
// Comprobamos si se ha llamado con una acción
    $accion = $_GET['accion'] ?? '';

    $controller = new ReservasController();

    switch ($accion) {
        case 'listar':
            $controller->listarReservas();
            break;
        // otras acciones como crear, editar, borrar, etc.
        default:
            echo "Acción no válida";
    }
    
?>