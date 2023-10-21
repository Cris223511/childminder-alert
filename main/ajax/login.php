<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Login.php";

$usuarios = new Login();

$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$fecha_nac = isset($_POST["fecha_nac"]) ? limpiarCadena($_POST["fecha_nac"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";

$usuario = isset($_POST["usuario"]) ? limpiarCadena($_POST["usuario"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";

switch ($_GET["op"]) {

    case 'registro':
        $rspta = $usuarios->agregar($nombres, $apellidos, $tipo_documento, $num_documento, $fecha_nac, $telefono, $email, $usuario, $clave);
        echo $rspta ? "true1" : "false1";
        break;

    case 'verificar':
        $verificarUsuario = $_POST['usuario'];
        $verificarClave = $_POST['clave'];

        $rspta = $usuarios->verificar($verificarUsuario, $verificarClave);
        $fetch = $rspta->fetch(PDO::FETCH_OBJ);

        if ($fetch !== false) {
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['usuario'] = $fetch->usuario;
            $_SESSION['nombres'] = $fetch->nombres;
            $_SESSION['rol'] = $fetch->rol;

            switch ($fetch->rol) {
                case 'admin':
                    $_SESSION['rol_descripcion'] = 'Administrador';
                    break;
                case 'usuario':
                    $_SESSION['rol_descripcion'] = 'Usuario';
                    break;
                default:
                    $_SESSION['rol_descripcion'] = 'Rol desconocido';
                    break;
            }

            $usuarios->actualizarEstadoUsuario($fetch->idusuario, 1);
        }
        echo json_encode($fetch);
        break;
}

ob_end_flush();
