<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

if ((empty($_SESSION['idusuario']) || $_SESSION['rol'] !== 'admin')) {
    echo json_encode(['error' => 'No está autorizado para realizar esta acción.']);
    exit();
}

require_once "../models/Usuarios.php";

$usuarios = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$usuario = isset($_POST["usuario"]) ? limpiarCadena($_POST["usuario"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$fecha_nac = isset($_POST["fecha_nac"]) ? limpiarCadena($_POST["fecha_nac"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$rol = isset($_POST["rol"]) ? limpiarCadena($_POST["rol"]) : "";

switch ($_GET["op"]) {

    case 'listar':
        $rspta = $usuarios->listar();
        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        $rolesModificados = array(
            'admin' => 'Administrador',
            'usuario' => 'Usuario'
        );

        foreach ($rows as &$row) {
            if (isset($rolesModificados[$row['rol']])) {
                $row['rol'] = $rolesModificados[$row['rol']];
            }
        }

        echo json_encode($rows);
        break;

    case 'mostrar':
        $rspta = $usuarios->mostrar($idusuario);
        echo json_encode($rspta);
        break;

    case 'agregaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/" . $imagen);
            }
        }
        if (empty($idusuario)) {
            $rspta = $usuarios->agregar($nombres, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $descripcion, $usuario, $clave, $imagen);
            echo $rspta ? "true" : "false";
        } else {
            $rspta = $usuarios->editar($idusuario, $nombres, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $descripcion, $usuario, $clave, $imagen);
            echo $rspta ? "true" : "false";
        }
        break;

    case 'editarRol':
        $rspta = $usuarios->editarRol($idusuario, $rol);
        echo json_encode($rspta);
        break;

    case 'eliminar':
        $rspta = $usuarios->eliminar($idusuario);
        echo $rspta ? "true" : "false";
        break;
}

ob_end_flush();
