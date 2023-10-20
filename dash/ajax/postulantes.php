<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

require_once "../models/Postulantes.php";

$postulantes = new Postulante();

$usuario = $_SESSION['idusuario'];

$idpostulante = isset($_POST["idpostulante"]) ? limpiarCadena($_POST["idpostulante"]) : "";
$idpuesto = isset($_POST["idpuesto"]) ? limpiarCadena($_POST["idpuesto"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";

$idevaluacion = isset($_POST["idevaluacion"]) ? limpiarCadena($_POST["idevaluacion"]) : "";
$comentario = isset($_POST["comentario"]) ? limpiarCadena($_POST["comentario"]) : "";
$reunion = isset($_POST["reunion"]) ? limpiarCadena($_POST["reunion"]) : "";

$puntaje2 = isset($_POST["puntaje2"]) ? limpiarCadena($_POST["puntaje2"]) : "";
$puntaje3 = isset($_POST["puntaje3"]) ? limpiarCadena($_POST["puntaje3"]) : "";

switch ($_GET["op"]) {

    case 'listarPuestosActivos':
        $rspta = $postulantes->listarPuestosActivos();
        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $row['botones'] = '
                <div class="d-flex justify-content-center p-0 m-0 botones">
                    <button onclick="window.location.href=\'postulantes.php?idpuesto=' . $row['idpuesto'] . '&titulo=' . $row['titulo'] . '\'" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 120px;">
                        Ver postulantes
                    </button>
                </div>
            ';
        }

        echo json_encode($rows);
        break;

    case 'listarPostulantesDePuesto':
        $rspta = $postulantes->listarPostulantesDePuesto($idpuesto);
        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        $rol = $_SESSION['rol'];

        // ESTADOS DEL POSTULANTE

        // Por defecto, el postulante tiene como estado "fase1".

        // fase1 -> jefe_rrhh va a calcular el puntaje.
        // subfase1 -> el puntaje se calculó (del 0 al 50), ahora el jefe_rrhh tiene que aprobar o rechazar.

        // SI APRUEBA, VAMOS A FASE 2
        // SI RECHAZA, ACABA EL FLUJO (Y DEBE PONER COMENTARIO)

        // fase2 -> psicologo o jefe_rrhh le va a asignar la evaluación.
        // pendiente -> psicologo o jefe_rrhh le envió la evaluación.
        // subfase2 -> el postulante realizó la evaluación, el psicólogo o jefe_rrhh tiene que colocar puntaje del 0 al 25.

        // AL SER EVALUADO EL PUNTAJE, VAMOS A LA FASE 3

        // fase3 -> psicologo o jefe_rrhh va a asignarle un enlace zoom o meet.
        // subfase3 -> el postulante ya fe asignado su enlace zoom o meet.

        // Asignar zoom o meet -> le asigna el zoom o meet.
        // Aceptar -> el postulante es "aprobado", se suma 25 puntos.
        // Rechazar -> el postulante es "rechazado".

        foreach ($rows as &$row) {
            $estado = $row['estado'];

            if ($estado == "fase1") {
                if ($rol == "jefe_rrhh" || $rol == "admin") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="puntaje(' . $row['idpostulante'] . ', ' . $row['idpuesto'] . ')" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center puntaje_' . $row['idpostulante'] . '" style="font-size: 13px; width: 130px;">
                                Calcular puntaje
                            </button>
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
                if ($rol == "psicologo") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "subfase1") {
                if ($rol == "jefe_rrhh" || $rol == "admin") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="aceptarSubfase1(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ', \'' . $row['nombres'] . '\')" class="btn bg-gradient-success col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Aceptar
                            </button>
                            <button onclick="rechazar(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ', \'' . $row['nombres'] . '\')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Rechazar
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 240px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
                if ($rol == "psicologo") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "fase2") {
                if ($rol == "jefe_rrhh" || $rol == "admin" || $rol == "psicologo") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="darEvalucion(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ', \'' . $row['nombres'] . '\')" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 130px;">
                                Dar evaluación
                            </button>
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "pendiente") {
                if ($rol == "jefe_rrhh" || $rol == "admin" || $rol == "psicologo") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" disabled style="font-size: 13px; width: 130px;">
                                Evaluación enviada
                            </button>
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "subfase2") {
                if ($rol == "jefe_rrhh" || $rol == "admin" || $rol == "psicologo") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'respuestas-detail.php?idpuesto=' . $row['idpuesto'] . '&idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Ver respuestas
                            </button>
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "fase3") {
                if ($rol == "jefe_rrhh" || $rol == "admin" || $rol == "psicologo") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="reunionZoom(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ', \'' . $row['nombres'] . '\')" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 130px;">
                                Crear reunión
                            </button>
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "subfase3") {
                if ($rol == "jefe_rrhh" || $rol == "admin" || $rol == "psicologo") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="calificarEntrevista(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ')" class="btn bg-gradient-success col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Aceptar
                            </button>
                            <button onclick="rechazar(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ', \'' . $row['nombres'] . '\')" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Rechazar
                            </button>
                        </div>
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="reunionZoom(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ', \'' . $row['nombres'] . '\')" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Editar reunión
                            </button>
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "finalizado") {
                if ($rol == "jefe_rrhh" || $rol == "admin") {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="seleccionarPostulante(' . $row['idpostulante'] . ',' . $row['idpuesto'] . ', \'' . $row['nombres'] . '\')" class="btn bg-gradient-info col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Seleccionar
                            </button>
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                                Detalles
                            </button>
                        </div>
                    ';
                } else {
                    $row['botones'] = '
                        <div class="d-flex justify-content-center p-0 m-0 botones">
                            <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 98%;">
                                Detalles
                            </button>
                        </div>
                    ';
                }
            }

            if ($estado == "aprobado") {
                $row['botones'] = '
                    <div class="d-flex justify-content-center p-0 m-0 botones">
                        <button class="btn bg-gradient-success col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" disabled style="font-size: 13px; width: 115px;">
                            Aprobado
                        </button>
                        <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 115px;">
                            Detalles
                        </button>
                    </div>
                ';
            }

            if ($estado == "rechazado") {
                $row['botones'] = '
                    <div class="d-flex justify-content-center p-0 m-0 botones">
                        <button onclick="window.location.href=\'postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '\'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 98%;">
                            Detalles
                        </button>
                    </div>
                ';
            }
        }

        echo json_encode($rows);
        break;

    case 'mostrarDatosPostulante':
        $rspta = $postulantes->mostrarDatosPostulante($idpostulante);
        echo json_encode($rspta);
        break;

        /* ========================== CAMBIOS FINALES ========================== */

    case 'rechazarPostulante':
        $rspta = $postulantes->rechazarPostulante($idpuesto, $idpostulante, $comentario);
        echo $rspta ? "true" : "false";
        break;

        /* ========================== PUNTAJE 1 ========================== */

    case 'calcularPuntajeDelPostulante':
        $rspta = $postulantes->calcularPuntajeDelPostulante($idpuesto, $idpostulante);
        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $conocimientosPostulante = preg_split('/[\r\n\s,]+/', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($row['conocimientos_postulante'])));
            $conocimientosPuesto = preg_split('/[\r\n\s,]+/', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($row['conocimientos_puesto'])));

            $aciertos = 0;

            foreach ($conocimientosPuesto as $conocimiento) {
                if (in_array($conocimiento, $conocimientosPostulante)) {
                    $aciertos++;
                }
            }

            $puntaje = count($conocimientosPostulante) > 0 ? ($aciertos / count($conocimientosPuesto)) * 50 : 0;
            $row['puntaje'] = $puntaje;

            $puntaje_total = $row['puntaje_total'] + $puntaje;
        }

        $rspta = $postulantes->calcularPuntajeDelPostulante($idpuesto, $idpostulante);
        $rspta = $postulantes->actualizarSubfase1Postulante($idpuesto, $idpostulante, $puntaje, $puntaje_total);

        echo json_encode($rows);
        break;

    case 'aceptarSubfase1':
        $rspta = $postulantes->aceptarSubfase1($idpuesto, $idpostulante);
        echo $rspta ? "true" : "false";
        break;

        /* ========================== PUNTAJE 2 ========================== */

    case 'selectEvaluaciones':
        $rol = $_SESSION['rol'];
        if ($rol == 'admin' || $rol == 'jefe_rrhh') {
            $rspta = $postulantes->selectEvaluaciones();
        } else {
            $rspta = $postulantes->selectEvaluacionesPorUsuario($usuario);
        }

        $rows = $rspta->fetchAll(PDO::FETCH_ASSOC);

        echo '<option value="">- Seleccione -</option>';

        foreach ($rows as &$row) {
            echo '<option value=' . $row["idevaluacion"] . '>' . $row["titulo"] . '</option>';
        }
        break;

    case 'asignarEvaluacionPostulante':
        $rspta = $postulantes->asignarEvaluacionPostulante($idpostulante, $idpuesto, $idevaluacion);
        $rspta = $postulantes->actualizarSubfase2PendientePostulante($idpuesto, $idpostulante);
        echo $rspta ? "true" : "false";
        break;

    case 'mostrarRespuestasPostulante':
        $rspta = $postulantes->mostrarRespuestasPostulante($idpostulante, $idpuesto);
        $respuestas = str_replace("\n", "\\n", $rspta['respuestas']);
        $preguntas = json_encode($rspta['preguntas']);
        $titulo = json_encode($rspta['titulo']);
        echo '{"preguntas": ' . $preguntas . ',"respuestas": ' . $respuestas . ',"titulo": ' . $titulo . '}';
        break;

    case 'aceptarSubfase2':
        $rspta = $postulantes->aceptarSubfase2($idpuesto, $idpostulante, $puntaje2);
        echo $rspta ? "true" : "false";
        break;

        /* ========================== PUNTAJE 3 ========================== */

    case 'enviarEnlacePostulante':
        $rspta = $postulantes->enviarEnlacePostulante($idpuesto, $idpostulante, $reunion);
        echo $rspta ? "true" : "false";
        break;

    case 'aceptarSubfase3':
        $rspta = $postulantes->aceptarSubfase3($idpuesto, $idpostulante, $puntaje3);
        echo $rspta ? "true" : "false";
        break;

        /* ========================== SELECCIONADOS ========================== */

    case 'seleccionarPostulante':
        $rspta = $postulantes->seleccionarPostulante($idpuesto, $idpostulante);
        echo $rspta ? "true" : "false";
        break;
}

ob_end_flush();
