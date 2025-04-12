<?php
require_once '../model/database.php';

header('Content-Type: application/json');

$response = ['exists' => false];

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $db = new database();
    $conn = $db->getConn();

    $stmt = $conn->prepare("SELECT email FROM transfer_viajeros WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response['exists'] = true;
    }
}

echo json_encode($response);