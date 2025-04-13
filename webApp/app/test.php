<!-- Miriam prueba test para la conexión de BBDD -->
<?php
try {
    $db = new PDO("mysql:host=mysql;port=3308;dbname=dataBaseNewTitans", "bernat", "newtitansdb");
    echo "✅ Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>
