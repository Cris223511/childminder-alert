<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Actividades.php";

$actividades = new Actividad();

$idusuario = $_SESSION['idusuario'];

$idactividad = isset($_POST["idactividad"]) ? limpiarCadena($_POST["idactividad"]) : "";
$titulo = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";

switch ($_GET["op"]) {

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
        if (empty($idactividad)) {
            $rspta = $actividades->agregar($idusuario, $titulo, $descripcion, $imagen, $fecha_hora);
            echo $rspta ? "true1" : "false1";
        } else {
            $rspta = $actividades->editar($idactividad, $titulo, $descripcion, $imagen, $fecha_hora);
            echo $rspta ? "true2" : "false2";
        }
        break;

    case 'mostrar':
        $rspta = $actividades->mostrar($idactividad);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin') {
            $rspta = $actividades->listar();
        } else {
            $rspta = $actividades->listarPorUsuario($idusuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $estado = $row['estado'];

            $row['botones'] = '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="window.location.href=\'actividades-edit.php?idactividad=' . $row['idactividad'] . '\'" class="btn bg-gradient-warning w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-left: 0px !important;">
                        Editar
                    </button>
                    <button onclick="window.location.href=\'actividades-detail.php?idactividad=' . $row['idactividad'] . '\'" class="btn bg-gradient-primary w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-right: 0px !important;">
                        Detalles
                    </button>
                </div>
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="eliminar(' . $row['idactividad'] . ')" class="btn bg-gradient-danger w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer; margin-left: 0px !important;">
                        Eliminar
                    </button>
            ';

            if ($estado == "pendiente") {
                $row['botones'] .= '
                    <button onclick="finalizar(' . $row['idactividad'] . ', \'' . $row['titulo'] . '\')" class="btn bg-gradient-success w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer; margin-right: 0px !important;">
                        Finalizar
                    </button>
                ';
            } else {
                $row['botones'] .= '
                    <button onclick="activar(' . $row['idactividad'] . ', \'' . $row['titulo'] . '\')" class="btn bg-gradient-info w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer; margin-right: 0px !important;">
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

    case 'listarDashboard':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin') {
            $rspta = $actividades->listarActividadesDashboard();
        } else {
            $rspta = $actividades->listarActividadesDashboardPorUsuario($idusuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $estado = $row['estado'];

            $row['botones'] = '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="window.location.href=\'../actividades/actividades-edit.php?idactividad=' . $row['idactividad'] . '\'" class="btn bg-gradient-warning w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-left: 0px !important;">
                        Editar
                    </button>
                    <button onclick="window.location.href=\'../actividades/actividades-detail.php?idactividad=' . $row['idactividad'] . '\'" class="btn bg-gradient-primary w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-right: 0px !important;">
                        Detalles
                    </button>
                </div>
                ';
        }
        echo json_encode($rows);
        break;

    case 'eliminar':
        $rspta = $actividades->eliminar($idactividad);
        echo $rspta ? "true" : "false";
        break;

    case 'finalizar':
        $rspta = $actividades->finalizar($idactividad);
        echo $rspta ? "true" : "false";
        break;

    case 'activar':
        $rspta = $actividades->activar($idactividad);
        echo $rspta ? "true" : "false";
        break;
}

ob_end_flush();
