<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

class Dispositivo
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $sql = "SELECT d.iddispositivo, d.idusuario, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, d.titulo, DATE_FORMAT(d.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, d.estado FROM dispositivos d INNER JOIN usuarios u ON d.idusuario = u.idusuario ORDER BY d.iddispositivo DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPorUsuario($usuario)
    {
        $sql = "SELECT d.iddispositivo, d.idusuario, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, d.titulo, DATE_FORMAT(d.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, d.estado FROM dispositivos d INNER JOIN usuarios u ON d.idusuario = u.idusuario WHERE d.idusuario = '$usuario' ORDER BY d.iddispositivo DESC";
        return ejecutarConsulta($sql);
    }

    public function listarDispositivosDashboard()
    {
        $sql = "SELECT d.iddispositivo, d.idusuario, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, d.titulo, DATE_FORMAT(d.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, d.estado FROM dispositivos d INNER JOIN usuarios u ON d.idusuario = u.idusuario ORDER BY d.iddispositivo DESC LIMIT 5";
        return ejecutarConsulta($sql);
    }

    public function listarDispositivosDashboardPorUsuario($usuario)
    {
        $sql = "SELECT d.iddispositivo, d.idusuario, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, d.titulo, DATE_FORMAT(d.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, d.estado FROM dispositivos d INNER JOIN usuarios u ON d.idusuario = u.idusuario WHERE d.idusuario = '$usuario' ORDER BY d.iddispositivo DESC LIMIT 5";
        return ejecutarConsulta($sql);
    }

    public function mostrar($iddispositivo)
    {
        $sql = "SELECT d.iddispositivo, d.idusuario, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, d.titulo, d.fecha_hora, d.estado FROM dispositivos d INNER JOIN usuarios u ON d.idusuario = u.idusuario WHERE d.iddispositivo = '$iddispositivo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function agregar($usuario, $titulo)
    {
        $sql = "INSERT INTO dispositivos (idusuario,titulo,fecha_hora,estado)
		VALUES ('$usuario','$titulo','activado')";
        return ejecutarConsulta($sql);
    }

    public function editar($iddispositivo, $titulo)
    {
        $sql = "UPDATE dispositivos SET titulo='$titulo' WHERE iddispositivo='$iddispositivo'";
        return ejecutarConsulta($sql);
    }

    public function activar($iddispositivo)
    {
        $sql = "UPDATE dispositivos SET estado='activado' WHERE iddispositivo='$iddispositivo'";
        return ejecutarConsulta($sql);
    }

    public function desactivar($iddispositivo)
    {
        $sql = "UPDATE dispositivos SET estado='desactivado' WHERE iddispositivo='$iddispositivo'";
        return ejecutarConsulta($sql);
    }
}
