<?php

$db_server = "baseDatosNewTitansApp";  
$db_user = "bernat";   
$db_pass = "newtitansdb"; 
$db_name = "dataBaseNewTitans"; 

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if ($conn) {
    echo "Conectado a la base de datos";
} else {
    echo "No se ha conectado a la base de datos: " . mysqli_connect_error();
}

?>