<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Perfil.php";

$perfil = new Perfil();

$idusuario = $_SESSION["idusuario"];

$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$usuario = isset($_POST["usuario"]) ? limpiarCadena($_POST["usuario"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$fecha_nac = isset($_POST["fecha_nac"]) ? limpiarCadena($_POST["fecha_nac"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $perfil->listarPerfilUsuario($idusuario);
        $fetch = $rspta->fetch(PDO::FETCH_OBJ);
        echo json_encode($fetch);
        break;

    case 'editar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/" . $imagen);
            }
        }

        $rspta = $perfil->editar($idusuario, $nombres, $apellidos, $usuario, $email, $imagen, $fecha_nac, $tipo_documento, $num_documento, $telefono, $direccion, $descripcion);
        $_SESSION['nombres'] = $nombres;
        echo $rspta ? "true" : "false";
        break;

    case 'actualizarSession':
        $info = array(
            'nombres' => $_SESSION['nombres']
        );
        echo json_encode($info);
        break;
}

ob_end_flush();