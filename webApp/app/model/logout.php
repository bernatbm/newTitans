<?php
session_start(); // 'Iniciar 'la sesión', como todas las otras
session_unset(); // Eliminar todas las variables de la sesión
session_destroy(); // Destruir la sesión 'POR ESPAAARTAAAAA'

$referer = $_SERVER['HTTP_REFERER'] ?? '';//donde estamos

if (strpos($referer, 'perfil.php') !== false) {
    header("Location: ../model/login.php");// Si cerramos sesión desde perfil, va a login
} else if (strpos($referer, 'registro.php') !== false) {//Si estamos en reistro va a registro(Solo cambia a login)
    header("Location: ../registro/registro.php");
} else {
    header("Location: ../index.php");//Para todo lo demás va a index.php
}
exit();//Se va
?>


