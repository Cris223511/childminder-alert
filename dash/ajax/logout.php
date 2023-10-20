<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Usuarios.php";

$usuario = new Usuario();

$idusuario = $_SESSION["idusuario"];

switch ($_GET["op"]) {
    case 'logout':
        $rspta = $usuario->actualizarEstadoUsuario($idusuario, 0);
        echo $rspta ? "true" : "false";
        break;
}