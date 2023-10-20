<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

if (empty($_SESSION['idusuario'])) {
    echo json_encode(['error' => 'No está autorizado para realizar esta acción.']);
    exit();
}

require_once "../models/Reportes.php";

$reportes = new Reporte();

switch ($_GET["op"]) {
    case 'mostrarDatosReporte':
        $rspta1 = $reportes->mostrarDatosReporte1();
        $rows1 = $rspta1->fetchAll(PDO::FETCH_ASSOC);

        $rspta2 = $reportes->mostrarDatosReporte2();
        $rows2 = $rspta2->fetchAll(PDO::FETCH_ASSOC);

        $rspta3 = $reportes->mostrarDatosReporte3();
        $rows3 = $rspta3->fetchAll(PDO::FETCH_ASSOC);

        $rspta4 = $reportes->mostrarDatosReporte4();
        $rows4_postulados = $rspta4['postulados'];
        $rows4_postulantes = $rspta4['postulantes'];

        foreach ($rows3 as &$row) {
            $row['boton'] = '<a class="text-sm mb-0 font-weight-bold" href="../../views/postulantes/postulantes-detail.php?idpostulante=' . $row['idpostulante'] . '"><i class="fas fa-eye text-sm mb-0 me-2" aria-hidden="true"></i>Detalles</a>';
        }

        echo json_encode(['fila1' => $rows1, 'fila2' => $rows2, 'fila3' => $rows3, 'fila4_postulados' => $rows4_postulados, 'fila4_postulantes' => $rows4_postulantes]);
        break;
}

ob_end_flush();
