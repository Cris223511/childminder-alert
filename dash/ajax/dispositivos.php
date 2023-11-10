<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Dispositivos.php";

$dispositivos = new Dispositivo();

$usuario = $_SESSION['idusuario'];

$iddispositivo = isset($_POST["iddispositivo"]) ? limpiarCadena($_POST["iddispositivo"]) : "";
$titulo = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";

switch ($_GET["op"]) {

    case 'agregaryeditar':
        if (empty($iddispositivo)) {
            $rspta = $dispositivos->agregar($usuario, $titulo);
            echo $rspta ? "true1" : "false1";
        } else {
            $rspta = $dispositivos->editar($iddispositivo, $titulo);
            echo $rspta ? "true2" : "false2";
        }
        break;

    case 'mostrar':
        $rspta = $dispositivos->mostrar($iddispositivo);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $dispositivos->listar();
        } else {
            $rspta = $dispositivos->listarPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $estado = $row['estado'];

            $row['botones'] = '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="window.location.href=\'dispositivos-edit.php?iddispositivo=' . $row['iddispositivo'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                        Editar
                    </button>
                    <button onclick="window.location.href=\'dispositivos-detail.php?iddispositivo=' . $row['iddispositivo'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                        Detalles
                    </button>
            ';

            if ($estado === 'activado') {
                $row['botones'] .= '
                    <button onclick="desactivar(' . $row['iddispositivo'] . ', \'' . $row['titulo'] . '\')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                        Desactivar
                    </button>
                ';
            }

            if ($estado === 'desactivado') {
                $row['botones'] .= '
                    <button onclick="activar(' . $row['iddispositivo'] . ', \'' . $row['titulo'] . '\')" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
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

    case 'listarTabla':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin') {
            $rspta = $dispositivos->listarDispositivosDashboard();
        } else {
            $rspta = $dispositivos->listarDispositivosDashboardPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {

            $estado = ($row['estado'] == 'activado') ? 'success' : 'danger';
            $estadoTexto = ($row['estado'] == 'activado') ? 'Activado' : 'Desactivado';

            $row['filas'] = '
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . ucfirst($row['usuario']) . '</h6>
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . strtoupper($row['titulo']) . '</h6>
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . $row['fecha_hora'] . '</h6>
                        </div>
                    </td>
                    <td class="align-middle text-sm text-center">
                        <span class="badge badge-sm bg-gradient-' . $estado . '">' . $estadoTexto . '</span>
                    </td>
                ';
        }

        echo json_encode($rows);
        break;

    case 'activar':
        $rspta = $dispositivos->activar($iddispositivo);
        echo $rspta ? "true" : "false";
        break;

    case 'desactivar':
        $rspta = $dispositivos->desactivar($iddispositivo);
        echo $rspta ? "true" : "false";
        break;
}

ob_end_flush();
