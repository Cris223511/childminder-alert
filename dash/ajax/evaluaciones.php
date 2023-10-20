<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Evaluaciones.php";

$evaluaciones = new Evaluacion();

$usuario = $_SESSION['idusuario'];

$idevaluacion = isset($_POST["idevaluacion"]) ? limpiarCadena($_POST["idevaluacion"]) : "";
$titulo = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";
$preguntas = isset($_POST["preguntas"]) ? $_POST["preguntas"] : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";

switch ($_GET["op"]) {

    case 'agregaryeditar':
        if (empty($idevaluacion)) {
            $rspta = $evaluaciones->agregar($usuario, $titulo, $preguntas, $fecha_hora);
            echo $rspta ? "true1" : "false1";
        } else {
            $rspta = $evaluaciones->editar($idevaluacion, $titulo, $preguntas, $fecha_hora);
            echo $rspta ? "true2" : "false2";
        }
        break;

    case 'mostrar':
        $rspta = $evaluaciones->mostrar($idevaluacion);
        echo json_encode($rspta);
        break;

    case 'eliminar':
        $rspta = $evaluaciones->eliminar($idevaluacion);
        echo $rspta ? "true" : "false";
        break;

    case 'listar':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $evaluaciones->listar();
        } else {
            $rspta = $evaluaciones->listarPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            switch ($row['rol']) {
                case 'admin':
                    $row['rol'] = 'Administrador';
                    break;
                case 'jefe_tienda':
                    $row['rol'] = 'Jefe de Tienda';
                    break;
                case 'jefe_rrhh':
                    $row['rol'] = 'Jefe de RRHH';
                    break;
                case 'psicologo':
                    $row['rol'] = 'Psicólogo';
                    break;
                default:
                    $row['rol'] = 'Rol desconocido';
                    break;
            }

            $row['botones'] = '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="window.location.href=\'evaluaciones-edit.php?idevaluacion=' . $row['idevaluacion'] . '\'" class="btn bg-gradient-warning col-4 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                        Editar
                    </button>
                    <button onclick="window.location.href=\'evaluaciones-detail.php?idevaluacion=' . $row['idevaluacion'] . '\'" class="btn bg-gradient-primary col-4 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                        Detalles
                    </button>
                    <button onclick="eliminar(' . $row['idevaluacion'] . ')" class="btn bg-gradient-danger col-4 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                        Eliminar
                    </button>
                </div>
            ';
        }

        echo json_encode($rows);
        break;
}

ob_end_flush();
