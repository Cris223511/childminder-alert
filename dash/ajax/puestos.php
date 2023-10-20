<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Puestos.php";

$puestos = new Puesto();

$usuario = $_SESSION['idusuario'];

$idpuesto = isset($_POST["idpuesto"]) ? limpiarCadena($_POST["idpuesto"]) : "";
$idsolicitud = isset($_POST["idsolicitud"]) ? limpiarCadena($_POST["idsolicitud"]) : "";
$titulo = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$ubicacion = isset($_POST["ubicacion"]) ? limpiarCadena($_POST["ubicacion"]) : "";
$horario = isset($_POST["horario"]) ? limpiarCadena($_POST["horario"]) : "";
$empresa = isset($_POST["empresa"]) ? limpiarCadena($_POST["empresa"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$modalidad = isset($_POST["modalidad"]) ? limpiarCadena($_POST["modalidad"]) : "";
$area = isset($_POST["area"]) ? limpiarCadena($_POST["area"]) : "";
$genero = isset($_POST["genero"]) ? limpiarCadena($_POST["genero"]) : "";
$beneficios = isset($_POST["beneficios"]) ? limpiarCadena($_POST["beneficios"]) : "";
$requisitos = isset($_POST["requisitos"]) ? limpiarCadena($_POST["requisitos"]) : "";
$ofrendas = isset($_POST["ofrendas"]) ? limpiarCadena($_POST["ofrendas"]) : "";
$conocimientos = isset($_POST["conocimientos"]) ? limpiarCadena($_POST["conocimientos"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";

switch ($_GET["op"]) {

    case 'agregaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../files/" . $imagen);
            }
        }
        if (empty($idpuesto)) {
            $rspta = $puestos->agregar($idsolicitud, $usuario, $titulo, $descripcion, $ubicacion, $horario, $empresa, $imagen, $modalidad, $area, $genero, $beneficios, $requisitos, $ofrendas, $conocimientos, $fecha_hora);
            $rspta = $puestos->actualizarDisponibilidadSolicitud($idsolicitud, 1);
            echo $rspta ? "true1" : "false1";
        } else {
            $rspta = $puestos->editar($idpuesto, $titulo, $descripcion, $ubicacion, $horario, $empresa, $imagen, $modalidad, $area, $genero, $beneficios, $requisitos, $ofrendas, $conocimientos, $fecha_hora);
            echo $rspta ? "true2" : "false2";
        }
        break;

    case 'mostrar':
        $rspta = $puestos->mostrar($idpuesto);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $puestos->listar();
        } else {
            $rspta = $puestos->listarPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $estado = $row['estado'];

            $row['botones'] = '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="window.location.href=\'puestos-edit.php?idpuesto=' . $row['idpuesto'] . '\'" class="btn bg-gradient-warning w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-left: 0px !important;">
                        Editar
                    </button>
                    <button onclick="window.location.href=\'puestos-detail.php?idpuesto=' . $row['idpuesto'] . '\'" class="btn bg-gradient-primary w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-right: 0px !important;">
                        Detalles
                    </button>
                </div>
            ';

            if ($estado == "pendiente" && ($rol == 'jefe_tienda') || $estado == "publicado" && ($rol == 'jefe_tienda')) {
                $row['botones'] .= '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="eliminar(' . $row['idpuesto'] . ', \'' . $row['idsolicitud'] . '\')" class="btn bg-gradient-danger w-100 boton text-center p-0 pt-2 pb-2 m-0 mt-1 mb-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                        Eliminar
                    </button>
                ';
            } else if ($estado == "pendiente" && ($rol == 'admin' || $rol == 'jefe_rrhh')) {
                $row['botones'] .= '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="eliminar(' . $row['idpuesto'] . ', \'' . $row['idsolicitud'] . '\')" class="btn bg-gradient-danger w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer; margin-left: 0px !important;">
                        Eliminar
                    </button>
                    <button onclick="publicar(' . $row['idpuesto'] . ', \'' . $row['titulo'] . '\')" class="btn bg-gradient-success w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer; margin-right: 0px !important;">
                        Publicar
                    </button>
                ';
            } else {
                $row['botones'] .= '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="eliminar(' . $row['idpuesto'] . ', \'' . $row['idsolicitud'] . '\')" class="btn bg-gradient-danger w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer; margin-left: 0px !important;">
                        Eliminar
                    </button>
                    <button onclick="remover(' . $row['idpuesto'] . ', \'' . $row['titulo'] . '\')" class="btn bg-gradient-info w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer; margin-right: 0px !important;">
                        Remover
                    </button>
                ';
            }

            $row['botones'] .= '
                </div>
            ';
        }

        echo json_encode($rows);
        break;

    case 'listarPuestosDashboard':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh' || $rol == 'psicologo') {
            $rspta = $puestos->listarPuestosDashboard();
        } else {
            $rspta = $puestos->listarPuestosDashboardPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $estado = $row['estado'];

            if ($rol != 'psicologo') {
                $row['botones'] = '
                    <div class="d-flex justify-content-center p-0 m-0 botones">
                        <a href="../puestos/puestos.php" class="btn bg-gradient-warning w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-left: 0px !important;">
                            Ver más
                        </a>
                        <a href="../puestos/puestos-detail.php?idpuesto=' . $row['idpuesto'] . '" class="btn bg-gradient-primary w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-right: 0px !important;">
                            Detalles
                        </a>
                    </div>
                ';
            } else {
                $row['botones'] = '';
            }
        }

        echo json_encode($rows);
        break;

    case 'listarTablaDashboard':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin') {
            $rspta = $puestos->listarTienda();
        } else if ($rol == 'jefe_tienda') {
            $rspta = $puestos->listarTiendaPorUsuario($usuario);
        } else if ($rol == 'jefe_rrhh') {
            $rspta = $puestos->listarEvaluaciones();
        } else {
            $rspta = $puestos->listarEvaluacionesPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        $roles = array(
            'admin' => 'Administrador',
            'jefe_rrhh' => 'Jefe RRHH',
            'jefe_tienda' => 'Jefe de Tiendas',
            'psicolog' => 'Psicólogo'
        );

        $cabecera = '';

        if ($rol == 'admin' || $rol == 'jefe_tienda') {
            $cabecera = '
                <tr class="w-30">
                    <td>
                        <div class="text-center fw-bold text-sm">Agregado por</div>
                    </td>
                    <td>
                        <div class="text-center fw-bold text-sm">Tienda</div>
                    </td>
                    <td>
                        <div class="text-center fw-bold text-sm">Teléfono</div>
                    </td>
                    <td>
                        <div class="text-center fw-bold text-sm">Fecha y hora</div>
                    </td>
                    <td>
                        <div class="text-center fw-bold text-sm">Estado</div>
                    </td>
                </tr>
            ';
        } else {
            $cabecera = '
                <tr class="w-30">
                    <td>
                        <div class="text-center fw-bold text-sm">Agregado por</div>
                    </td>
                    <td>
                        <div class="text-center fw-bold text-sm">Rol</div>
                    </td>
                    <td>
                        <div class="text-center fw-bold text-sm">Título</div>
                    </td>
                    <td>
                        <div class="text-center fw-bold text-sm">Fecha y hora</div>
                    </td>
                </tr>
            ';
        }

        foreach ($rows as &$row) {
            $rolValidado = isset($roles[$rol]) ? $roles[$rol] : '';

            if ($rol == 'admin' || $rol == 'jefe_tienda') {

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
                            <h6 class="text-sm fw-normal mb-0">' . $row['nombre'] . '</h6>
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . $row['telefono'] . '</h6>
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
            } else {
                $row['filas'] = '
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . ucfirst($row['usuario']) . '</h6>
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . $rolValidado . '</h6>
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . ucfirst($row['titulo']) . '</h6>
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <h6 class="text-sm fw-normal mb-0">' . $row['fecha_hora'] . '</h6>
                        </div>
                    </td>
                ';
            }
        }

        $respuesta = array(
            'cabecera' => $cabecera,
            'filas' => $rows,
            'titulo' => ($rol == 'admin' || $rol == 'jefe_tienda') ? 'Lista de tiendas' : 'Lista de evaluaciones'
        );

        echo json_encode($respuesta);
        break;

    case 'eliminar':
        $rspta = $puestos->eliminar($idpuesto);
        $rspta = $puestos->actualizarDisponibilidadSolicitud($idsolicitud, 0);
        echo $rspta ? "true" : "false";
        break;

    case 'publicar':
        $rspta = $puestos->publicar($idpuesto);
        echo $rspta ? "true" : "false";
        break;

    case 'remover':
        $rspta = $puestos->remover($idpuesto);
        echo $rspta ? "true" : "false";
        break;

    case 'selectSolicitudes':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $puestos->selectSolicitudes();
        } else {
            $rspta = $puestos->selectSolicitudesPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        echo '<option value="">- Seleccione -</option>';

        $i = 1;
        foreach ($rows as &$row) {
            $motivo = strlen($row["motivo"]) > 30 ? substr($row["motivo"], 0, 30) . "..." : $row["motivo"];
            echo '<option value=' . $row["idsolicitud"] . '>' . $i++ . ' - ' . ucwords($row["puesto"]) . ' - ' . $motivo . '</option>';
        }
        break;

    case 'selectSolicitudesDisponibles':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $puestos->selectSolicitudesDisponibles();
        } else {
            $rspta = $puestos->selectSolicitudesDisponiblesPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        echo '<option value="">- Seleccione -</option>';

        $i = 1;
        foreach ($rows as &$row) {
            $motivo = strlen($row["motivo"]) > 30 ? substr($row["motivo"], 0, 30) . "..." : $row["motivo"];
            echo '<option value=' . $row["idsolicitud"] . '>' . $i++ . ' - ' . ucwords($row["puesto"]) . ' - ' . $motivo . '</option>';
        }
        break;
}

ob_end_flush();
