<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Tiendas.php";

$tiendas = new Tienda();

$usuario = $_SESSION['idusuario'];

$idtienda = isset($_POST["idtienda"]) ? limpiarCadena($_POST["idtienda"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";

switch ($_GET["op"]) {

    case 'agregaryeditar':
        if (empty($idtienda)) {
            $rspta = $tiendas->agregar($usuario, $nombre, $direccion, $telefono, $fecha_hora);
            echo $rspta ? "true1" : "false1";
        } else {
            $rspta = $tiendas->editar($idtienda, $nombre, $direccion, $telefono, $fecha_hora);
            echo $rspta ? "true2" : "false2";
        }
        break;

    case 'mostrar':
        $rspta = $tiendas->mostrar($idtienda);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $tiendas->listar();
        } else {
            $rspta = $tiendas->listarPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $estado = $row['estado'];

            $row['botones'] = '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="window.location.href=\'tiendas-edit.php?idtienda=' . $row['idtienda'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                        Editar
                    </button>
                    <button onclick="window.location.href=\'tiendas-detail.php?idtienda=' . $row['idtienda'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                        Detalles
                    </button>
            ';

            if ($estado === 'activado') {
                $row['botones'] .= '
                    <button onclick="desactivar(' . $row['idtienda'] . ', \'' . $row['nombre'] . '\')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                        Desactivar
                    </button>
                ';
            }

            if ($estado === 'desactivado') {
                $row['botones'] .= '
                    <button onclick="activar(' . $row['idtienda'] . ', \'' . $row['nombre'] . '\')" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                        Activar
                    </button>
                ';
            }

            $row['botones'] .= '
                </div>
            ';
        }

        echo json_encode($rows);
        break;

    case 'activar':
        $rspta = $tiendas->activar($idtienda);
        echo $rspta ? "true" : "false";
        break;

    case 'desactivar':
        $rspta = $tiendas->desactivar($idtienda);
        echo $rspta ? "true" : "false";
        break;
}

ob_end_flush();
