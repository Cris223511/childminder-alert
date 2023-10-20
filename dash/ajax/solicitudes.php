<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Solicitudes.php";

$solicitudes = new Solicitud();

$usuario = $_SESSION['idusuario'];
$rolSession = $_SESSION['rol'];

$idsolicitud = isset($_POST["idsolicitud"]) ? limpiarCadena($_POST["idsolicitud"]) : "";
$idtienda = isset($_POST["idtienda"]) ? limpiarCadena($_POST["idtienda"]) : "";
$puesto = isset($_POST["puesto"]) ? limpiarCadena($_POST["puesto"]) : "";
$cant_vacantes = isset($_POST["cant_vacantes"]) ? limpiarCadena($_POST["cant_vacantes"]) : "";
$salario_neto = isset($_POST["salario_neto"]) ? limpiarCadena($_POST["salario_neto"]) : "";
$tiempo_contrato = isset($_POST["tiempo_contrato"]) ? limpiarCadena($_POST["tiempo_contrato"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$motivo = isset($_POST["motivo"]) ? limpiarCadena($_POST["motivo"]) : "";
$comentario = isset($_POST["comentario"]) ? limpiarCadena($_POST["comentario"]) : "";

switch ($_GET["op"]) {

    case 'agregaryeditar':
        if (empty($idsolicitud)) {
            $rspta = $solicitudes->agregar($idtienda, $usuario, $puesto, $cant_vacantes, $salario_neto, $tiempo_contrato, $fecha_hora, $motivo);
            echo $rspta ? "true1" : "false1";
        } else {
            if ($rolSession == 'jefe_rrhh' || $rolSession == 'admin') {
                $rspta = $solicitudes->editarRRHH($idsolicitud, $idtienda, $puesto, $cant_vacantes, $salario_neto, $tiempo_contrato, $fecha_hora, $motivo);
                echo $rspta ? "true2" : "false2";
            } else {
                $rspta = $solicitudes->editar($idsolicitud, $idtienda, $puesto, $cant_vacantes, $salario_neto, $tiempo_contrato, $fecha_hora, $motivo);
                echo $rspta ? "true3" : "false3";
            }
        }
        break;

    case 'eliminar':
        $rspta = $solicitudes->eliminar($idsolicitud);
        echo $rspta ? "true" : "false";
        break;

    case 'mostrar':
        $rspta = $solicitudes->mostrar($idsolicitud);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rol = $_SESSION['rol'];

        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $solicitudes->listar();
        } else {
            $rspta = $solicitudes->listarPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $row['rol'] = $rol;
            $estado = $row['estado'];

            if ($rol == 'admin') {
                // Botones para el rol de administrador
                if ($estado == 'aceptado') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
                if ($estado == 'pendiente') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="aceptarSolicitud(' . $row['idsolicitud'] . ')" class="btn bg-gradient-success col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Aceptar
                            </button>
                            <button onclick="rechazarSolicitud(' . $row['idsolicitud'] . ')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Rechazar
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="eliminar(' . $row['idsolicitud'] . ')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 210px; cursor: pointer;">
                                Eliminar
                            </button>
                        </div>
                    ';
                }
                if ($estado == 'rechazado') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="aceptarSolicitud(' . $row['idsolicitud'] . ')" class="btn bg-gradient-success col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Aceptar
                            </button>
                            <button onclick="verComentario(' . $row['idsolicitud'] . ')" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                                Comentarios
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="eliminar(' . $row['idsolicitud'] . ')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 210px; cursor: pointer;">
                                Eliminar
                            </button>
                        </div>
                    ';
                }
            } elseif ($rol == 'jefe_tienda') {
                if ($estado == 'aceptado') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }

                if ($estado == 'pendiente') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="eliminar(' . $row['idsolicitud'] . ')" class="btn bg-gradient-danger col-12 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 210px; cursor: pointer;">
                                Eliminar
                            </button>
                        </div>
                    ';
                }

                if ($estado == 'rechazado') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="eliminar(' . $row['idsolicitud'] . ')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                                Eliminar
                            </button>
                            <button onclick="verComentario(' . $row['idsolicitud'] . ')" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                                Comentarios
                            </button>
                        </div>
                    ';
                }
            } elseif ($rol == 'jefe_rrhh') {
                if ($estado == 'aceptado') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }

                if ($estado == 'pendiente') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="aceptarSolicitud(' . $row['idsolicitud'] . ')" class="btn bg-gradient-success col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Aceptar
                            </button>
                            <button onclick="rechazarSolicitud(' . $row['idsolicitud'] . ')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Rechazar
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'solicitudes-edit.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Editar
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }

                if ($estado == 'rechazado') {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="verComentario(' . $row['idsolicitud'] . ')" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                                Comentarios
                            </button>
                            <button onclick="window.location.href=\'solicitudes-detail.php?idsolicitud=' . $row['idsolicitud'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }
        }

        echo json_encode($rows);
        break;

    case 'selectTiendas':
        $rol = $_SESSION['rol'];
        // if ($rol == 'admin' || $rol == 'jefe_rrhh') {
        //     $rspta = $solicitudes->selectTiendas();
        // } else {
        //     $rspta = $solicitudes->selectTiendasPorUsuario($usuario);
        // }

        $rspta = $solicitudes->selectTiendas();
        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        echo '<option value="">- Seleccione -</option>';

        foreach ($rows as &$row) {
            echo '<option value=' . $row["idtienda"] . '>' . $row["nombre"] . '</option>';
        }
        break;

    case 'aceptar':
        $rspta = $solicitudes->aceptar($idsolicitud);
        echo $rspta ? "true" : "false";
        break;

    case 'rechazar':
        $rspta = $solicitudes->rechazar($idsolicitud, $comentario);
        echo $rspta ? "true" : "false";
        break;

    case 'verComentario':
        $rspta = $solicitudes->verComentario($idsolicitud);
        echo json_encode($rspta);
        break;
}

ob_end_flush();
