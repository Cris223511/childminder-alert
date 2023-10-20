<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Solicitud
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $sql = "SELECT s.idsolicitud, s.idusuario, t.nombre as tienda, u.nombres as usuario, s.puesto, s.motivo, s.cant_vacantes, s.salario_neto, s.tiempo_contrato, s.comentario, DATE_FORMAT(s.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, s.estado FROM solicitudes s INNER JOIN tiendas t ON s.idtienda = t.idtienda INNER JOIN usuarios u ON s.idusuario = u.idusuario ORDER BY s.idsolicitud DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPorUsuario($usuario)
    {
        $sql = "SELECT s.idsolicitud, s.idusuario, t.nombre as tienda, u.nombres as usuario, s.puesto, s.motivo, s.cant_vacantes, s.salario_neto, s.tiempo_contrato, s.comentario, DATE_FORMAT(s.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, s.estado FROM solicitudes s INNER JOIN tiendas t ON s.idtienda = t.idtienda INNER JOIN usuarios u ON s.idusuario = u.idusuario WHERE s.idusuario = '$usuario' ORDER BY s.idsolicitud DESC";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idsolicitud)
    {
        $sql = "SELECT s.idsolicitud, s.idusuario, t.idtienda as idtienda, t.nombre as tienda, u.nombres as usuario, s.puesto, s.motivo, s.cant_vacantes, s.salario_neto, s.tiempo_contrato, s.comentario, s.fecha_hora, s.estado FROM solicitudes s INNER JOIN tiendas t ON s.idtienda = t.idtienda INNER JOIN usuarios u ON s.idusuario = u.idusuario WHERE s.idsolicitud = '$idsolicitud'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function agregar($idtienda, $usuario, $puesto, $cant_vacantes, $salario_neto, $tiempo_contrato, $fecha_hora, $motivo)
    {
        $sql = "INSERT INTO solicitudes (idtienda,idusuario,puesto,motivo,cant_vacantes,salario_neto,tiempo_contrato,comentario,fecha_hora,estado,disponibilidad)
		VALUES ('$idtienda','$usuario','$puesto','$motivo','$cant_vacantes','$salario_neto','$tiempo_contrato','','$fecha_hora','pendiente','0')";
        return ejecutarConsulta($sql);
    }

    public function editar($idsolicitud, $idtienda, $puesto, $cant_vacantes, $salario_neto, $tiempo_contrato, $fecha_hora, $motivo)
    {
        $sql = "UPDATE solicitudes SET idtienda='$idtienda',puesto='$puesto',cant_vacantes='$cant_vacantes',salario_neto='$salario_neto',tiempo_contrato='$tiempo_contrato',fecha_hora='$fecha_hora',motivo='$motivo',comentario='',estado='pendiente' WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }

    public function editarRRHH($idsolicitud, $idtienda, $puesto, $cant_vacantes, $salario_neto, $tiempo_contrato, $fecha_hora, $motivo)
    {
        $sql = "UPDATE solicitudes SET idtienda='$idtienda',puesto='$puesto',cant_vacantes='$cant_vacantes',salario_neto='$salario_neto',tiempo_contrato='$tiempo_contrato',fecha_hora='$fecha_hora',motivo='$motivo' WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }

    public function eliminar($idsolicitud)
    {
        $sql = "DELETE FROM solicitudes WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }

    public function aceptar($idsolicitud)
    {
        $sql = "UPDATE solicitudes SET estado='aceptado' WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }

    public function rechazar($idsolicitud, $comentario)
    {
        $sql = "UPDATE solicitudes SET estado='rechazado', comentario='$comentario' WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }

    public function verComentario($idsolicitud)
    {
        $sql = "SELECT comentario FROM solicitudes where idsolicitud='$idsolicitud'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function selectTiendas()
    {
        $sql = "SELECT * FROM tiendas";
        return ejecutarConsulta($sql);
    }

    public function selectTiendasPorUsuario($usuario)
    {
        $sql = "SELECT t.idtienda, t.nombre FROM tiendas t INNER JOIN usuarios u ON t.idusuario = u.idusuario WHERE t.idusuario = '$usuario' AND t.estado ='activado'";
        return ejecutarConsulta($sql);
    }
}
