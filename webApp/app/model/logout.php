<?php
session_start(); // 'Iniciar 'la sesión', como todas las otras
session_unset(); // Eliminar todas las variables de la sesión
session_destroy(); // Destruir la sesión 'POR ESPAAARTAAAAA'

$referer = $_SERVER['HTTP_REFERER'] ?? '';//donde estamos

//Aqui estan els logOuts o CERRAR SESSIONES segun PERFIL
if (
    strpos($referer, 'panelAdministrador.php') !== false ||
    strpos($referer, 'panelCorporativo.php') !== false ||
    strpos($referer, 'perfilUsuario.php') !== false
) {
    header("Location: ../view/login.php");// Si cerramos sesión desde cualquier perfil, va a login
} else if (strpos($referer, 'registro.php') !== false) {//Si estamos en reistro va a registro(Solo cambia a login)
    header("Location: ../registro/registro.php");
} else {
    header("Location: ../index.php");//Para todo lo demás va a index.php
}
exit();//Se va
?>


