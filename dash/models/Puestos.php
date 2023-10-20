<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Puesto
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $sql = "SELECT p.idpuesto, s.idsolicitud as idsolicitud, u.nombres as usuario, p.titulo, p.imagen, CONCAT(DAY(p.fecha_hora), ' de ', 
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
            END, ' del ', YEAR(p.fecha_hora)) as fecha_hora, p.estado FROM puestos p
            INNER JOIN solicitudes s ON p.idsolicitud = s.idsolicitud
            INNER JOIN usuarios u ON p.idusuario = u.idusuario ORDER BY p.idpuesto DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPorUsuario($usuario)
    {
        $sql = "SELECT p.idpuesto, s.idsolicitud as idsolicitud, u.nombres as usuario, p.titulo, p.imagen, CONCAT(DAY(p.fecha_hora), ' de ', 
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
            END, ' del ', YEAR(p.fecha_hora)) as fecha_hora, p.estado FROM puestos p
            INNER JOIN solicitudes s ON p.idsolicitud = s.idsolicitud
            INNER JOIN usuarios u ON p.idusuario = u.idusuario WHERE p.idusuario = '$usuario' ORDER BY p.idpuesto DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPuestosDashboard()
    {
        $sql = "SELECT p.idpuesto, u.nombres as usuario, p.titulo, p.imagen, CONCAT(DAY(p.fecha_hora), ' de ', 
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
                END, ' del ', YEAR(p.fecha_hora)) as fecha_hora, p.estado FROM puestos p 
                INNER JOIN usuarios u ON p.idusuario = u.idusuario
                ORDER BY p.idpuesto DESC
                LIMIT 3";
        return ejecutarConsulta($sql);
    }

    public function listarPuestosDashboardPorUsuario($usuario)
    {
        $sql = "SELECT p.idpuesto, u.nombres as usuario, p.titulo, p.imagen, CONCAT(DAY(p.fecha_hora), ' de ', 
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
            END, ' del ', YEAR(p.fecha_hora)) as fecha_hora, p.estado FROM puestos p 
            INNER JOIN usuarios u ON p.idusuario = u.idusuario WHERE p.idusuario = '$usuario'
            ORDER BY p.idpuesto DESC
            LIMIT 3";
        return ejecutarConsulta($sql);
    }

    public function agregar($idsolicitud, $usuario, $titulo, $descripcion, $ubicacion, $horario, $empresa, $imagen, $modalidad, $area, $genero, $beneficios, $requisitos, $ofrendas, $conocimientos, $fecha_hora)
    {
        $sql = "INSERT INTO puestos (idsolicitud,idusuario,titulo,descripcion,ubicacion,horario,empresa,imagen,modalidad,area,genero,beneficios,requisitos,ofrendas,conocimientos,fecha_hora,estado)
    VALUES ('$idsolicitud','$usuario','$titulo','$descripcion','$ubicacion','$horario','$empresa','$imagen','$modalidad','$area','$genero','$beneficios','$requisitos','$ofrendas','$conocimientos','$fecha_hora','pendiente')";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idpuesto)
    {
        $sql = "SELECT p.idpuesto, p.idsolicitud, s.puesto as puesto, p.idusuario, u.nombres as usuario, p.titulo, p.descripcion, p.ubicacion, p.horario, p.empresa, p.imagen, p.modalidad, p.area, p.genero, p.beneficios, p.requisitos, p.ofrendas, p.conocimientos, p.fecha_hora, p.estado FROM puestos p INNER JOIN solicitudes s ON p.idusuario = s.idusuario INNER JOIN usuarios u ON p.idusuario = u.idusuario WHERE p.idpuesto = '$idpuesto'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function editar($idpuesto, $titulo, $descripcion, $ubicacion, $horario, $empresa, $imagen, $modalidad, $area, $genero, $beneficios, $requisitos, $ofrendas, $conocimientos, $fecha_hora)
    {
        $sql = "UPDATE puestos SET titulo='$titulo',descripcion='$descripcion',ubicacion='$ubicacion',horario='$horario',empresa='$empresa',imagen='$imagen',modalidad='$modalidad',area='$area',genero='$genero',beneficios='$beneficios',requisitos='$requisitos',ofrendas='$ofrendas',conocimientos='$conocimientos',fecha_hora='$fecha_hora' WHERE idpuesto='$idpuesto'";
        return ejecutarConsulta($sql);
    }

    public function eliminar($idpuesto)
    {
        $sql = "DELETE FROM puestos WHERE idpuesto='$idpuesto'";
        return ejecutarConsulta($sql);
    }

    public function actualizarDisponibilidadSolicitud($idsolicitud, $status)
    {
        $sql = "UPDATE solicitudes SET disponibilidad='$status' WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }

    public function selectSolicitudes()
    {
        $sql = "SELECT * FROM solicitudes WHERE estado='aceptado'";
        return ejecutarConsulta($sql);
    }

    public function selectSolicitudesPorUsuario($usuario)
    {
        $sql = "SELECT * FROM solicitudes WHERE estado='aceptado' AND idusuario='$usuario'";
        return ejecutarConsulta($sql);
    }

    public function selectSolicitudesDisponibles()
    {
        $sql = "SELECT * FROM solicitudes WHERE estado='aceptado' AND disponibilidad='0'";
        return ejecutarConsulta($sql);
    }

    public function selectSolicitudesDisponiblesPorUsuario($usuario)
    {
        $sql = "SELECT * FROM solicitudes WHERE estado='aceptado' AND disponibilidad='0' AND idusuario='$usuario'";
        return ejecutarConsulta($sql);
    }

    public function publicar($idpuesto)
    {
        $sql = "UPDATE puestos SET estado='publicado' WHERE idpuesto='$idpuesto'";
        return ejecutarConsulta($sql);
    }

    public function remover($idpuesto)
    {
        $sql = "UPDATE puestos SET estado='pendiente' WHERE idpuesto='$idpuesto'";
        return ejecutarConsulta($sql);
    }

    public function listarTienda()
    {
        $sql = "SELECT t.idtienda, t.idusuario, u.nombres as usuario, t.nombre, t.direccion, t.telefono, DATE_FORMAT(t.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, t.estado FROM tiendas t INNER JOIN usuarios u ON t.idusuario = u.idusuario ORDER BY t.idtienda DESC LIMIT 5";
        return ejecutarConsulta($sql);
    }

    public function listarTiendaPorUsuario($usuario)
    {
        $sql = "SELECT t.idtienda, t.idusuario, u.nombres as usuario, t.nombre, t.direccion, t.telefono, DATE_FORMAT(t.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, t.estado FROM tiendas t INNER JOIN usuarios u ON t.idusuario = u.idusuario WHERE t.idusuario = '$usuario' ORDER BY t.idtienda DESC LIMIT 5";
        return ejecutarConsulta($sql);
    }

    public function listarEvaluaciones()
    {
        $sql = "SELECT e.idevaluacion, e.idusuario, u.nombres as usuario, u.rol as rol, e.titulo, DATE_FORMAT(e.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora FROM evaluaciones e INNER JOIN usuarios u ON e.idusuario = u.idusuario ORDER BY e.idevaluacion DESC LIMIT 5";
        return ejecutarConsulta($sql);
    }

    public function listarEvaluacionesPorUsuario($usuario)
    {
        $sql = "SELECT e.idevaluacion, e.idusuario, u.nombres as usuario, e.titulo, DATE_FORMAT(e.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora FROM evaluaciones e INNER JOIN usuarios u ON e.idusuario = u.idusuario WHERE e.idusuario = '$usuario' ORDER BY e.idevaluacion DESC LIMIT 5";
        return ejecutarConsulta($sql);
    }
}
