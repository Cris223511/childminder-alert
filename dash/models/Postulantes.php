<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Postulante
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listarPuestosActivos()
    {
        $sql = "SELECT p.idpuesto, p.titulo, u.nombres as usuario, p.descripcion, p.empresa, p.ubicacion, p.estado, CONCAT(DAY(p.fecha_hora), ' de ', 
            CASE MONTH(p.fecha_hora)
                WHEN 1 THEN 'Enero'
                WHEN 2 THEN 'Febrero'
                WHEN 3 THEN 'Marzo'
                WHEN 4 THEN 'Abril'
                WHEN 5 THEN 'Mayo'
                WHEN 6 THEN 'Junio'
                WHEN 7 THEN 'Julio'
                WHEN 8 THEN 'Agosto'
                WHEN 9 THEN 'Septiembre'
                WHEN 10 THEN 'Octubre'
                WHEN 11 THEN 'Noviembre'
                WHEN 12 THEN 'Diciembre'
            END, ' del ', YEAR(p.fecha_hora)) as fecha_hora FROM puestos p
            INNER JOIN usuarios u ON p.idusuario = u.idusuario
            WHERE p.estado='publicado'
            ORDER BY p.idpuesto DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPostulantesDePuesto($idpuesto)
    {
        $sql = "SELECT po.idpostulante, po.idpuesto, p.nombres, p.apellidos, p.tipo_documento, p.num_documento, p.imagen, po.puntaje1, po.puntaje2, po.puntaje3, po.puntaje_total, po.estado
        FROM postulados po
        INNER JOIN postulantes p ON po.idpostulante = p.idpostulante
        WHERE po.idpuesto = '$idpuesto'
        GROUP BY po.idpostulante, po.idpuesto ORDER BY po.idpostulante DESC";

        return ejecutarConsulta($sql);
    }

    public function mostrarDatosPostulante($idpostulante)
    {
        $sql = "SELECT nombres, apellidos, tipo_documento, num_documento, fecha_nac, genero, telefono, email, titulo, direccion, carrera, descripcion, idiomas, sueldo_estimado, estudios, conocimientos, experiencias, imagen, archivo_cv FROM postulantes WHERE idpostulante = '$idpostulante'";
        return ejecutarConsultaSimpleFila($sql);
    }

    /* ========================== CAMBIOS FINALES ========================== */

    public function rechazarPostulante($idpuesto, $idpostulante, $comentario)
    {
        $sql = "UPDATE postulados SET estado='rechazado', comentario='$comentario' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }

    /* ========================== PUNTAJE 1 ========================== */

    public function calcularPuntajeDelPostulante($idpuesto, $idpostulante)
    {
        $sql = "SELECT p.conocimientos as conocimientos_postulante, pu.conocimientos as conocimientos_puesto, po.puntaje_total
            FROM postulados po
            INNER JOIN postulantes p ON po.idpostulante = p.idpostulante
            INNER JOIN puestos pu ON pu.idpuesto = po.idpuesto
            WHERE po.idpuesto = '$idpuesto' AND po.idpostulante = '$idpostulante'";

        return ejecutarConsulta($sql);
    }

    public function actualizarSubfase1Postulante($idpuesto, $idpostulante, $puntaje, $puntaje_total)
    {
        $sql = "UPDATE postulados SET puntaje1='$puntaje', puntaje_total='$puntaje_total', estado='subfase1' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }

    public function aceptarSubfase1($idpuesto, $idpostulante)
    {
        $sql = "UPDATE postulados SET estado='fase2' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }

    /* ========================== PUNTAJE 2 ========================== */

    public function selectEvaluaciones()
    {
        $sql = "SELECT * FROM evaluaciones";
        return ejecutarConsulta($sql);
    }

    public function selectEvaluacionesPorUsuario($usuario)
    {
        $sql = "SELECT e.idevaluacion, e.titulo FROM evaluaciones e INNER JOIN usuarios u ON e.idusuario = u.idusuario WHERE e.idusuario = '$usuario'";
        return ejecutarConsulta($sql);
    }

    public function asignarEvaluacionPostulante($idpostulante, $idpuesto, $idevaluacion)
    {
        $sql = "INSERT INTO evaluados (idpostulante, idpuesto, idevaluacion) VALUES ('$idpostulante','$idpuesto','$idevaluacion')";
        return ejecutarConsulta($sql);
    }

    public function actualizarSubfase2PendientePostulante($idpuesto, $idpostulante)
    {
        $sql = "UPDATE postulados SET estado='pendiente' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }

    function mostrarRespuestasPostulante($idpostulante, $idpuesto)
    {
        $sql = "SELECT ev.idevaluacion, e.titulo, e.preguntas, p.respuestas
                    FROM evaluados ev
                    INNER JOIN evaluaciones e ON ev.idevaluacion = e.idevaluacion
                    INNER JOIN postulados p ON ev.idpostulante = p.idpostulante AND ev.idpuesto = p.idpuesto
                WHERE ev.idpostulante = '$idpostulante' AND ev.idpuesto = '$idpuesto'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function aceptarSubfase2($idpuesto, $idpostulante, $puntaje2)
    {
        $sql = "UPDATE postulados SET puntaje2='$puntaje2', puntaje_total = puntaje1 + '$puntaje2', estado='fase3' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }

    /* ========================== PUNTAJE 3 ========================== */

    public function enviarEnlacePostulante($idpuesto, $idpostulante, $reunion)
    {
        $sql = "UPDATE postulados SET estado='subfase3', reunion='$reunion' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }

    public function aceptarSubfase3($idpuesto, $idpostulante, $puntaje3)
    {
        $sql = "UPDATE postulados SET puntaje3='$puntaje3', puntaje_total = puntaje1 + puntaje2 + '$puntaje3', estado='finalizado' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }

    /* ========================== SELECCIONADOS ========================== */

    public function seleccionarPostulante($idpuesto, $idpostulante)
    {
        $sql = "UPDATE postulados SET estado='aprobado' WHERE idpuesto = '$idpuesto' AND idpostulante = '$idpostulante'";
        return ejecutarConsulta($sql);
    }
}
