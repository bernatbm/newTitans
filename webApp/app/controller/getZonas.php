git <?php
require_once '../model/database.php';

$db = new database();
$conn = $db->getConn();

$stmt = $conn->query("SELECT id_zona, descripcion FROM transfer_zona");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='{$row['id_zona']}'>{$row['descripcion']}</option>";
}
?>