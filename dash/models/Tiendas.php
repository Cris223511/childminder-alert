<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Tienda
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $sql = "SELECT t.idtienda, t.idusuario, u.nombres as usuario, t.nombre, t.direccion, t.telefono, DATE_FORMAT(t.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, t.estado FROM tiendas t INNER JOIN usuarios u ON t.idusuario = u.idusuario ORDER BY t.idtienda DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPorUsuario($usuario)
    {
        $sql = "SELECT t.idtienda, t.idusuario, u.nombres as usuario, t.nombre, t.direccion, t.telefono, DATE_FORMAT(t.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora, t.estado FROM tiendas t INNER JOIN usuarios u ON t.idusuario = u.idusuario WHERE t.idusuario = '$usuario' ORDER BY t.idtienda DESC";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idtienda)
    {
        $sql = "SELECT t.idtienda, t.idusuario, u.nombres as usuario, t.nombre, t.direccion, t.telefono, t.fecha_hora, t.estado FROM tiendas t INNER JOIN usuarios u ON t.idusuario = u.idusuario WHERE t.idtienda = '$idtienda'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function agregar($usuario, $nombre, $direccion, $telefono, $fecha_hora)
    {
        $sql = "INSERT INTO tiendas (idusuario,nombre,direccion,telefono,fecha_hora,estado)
		VALUES ('$usuario','$nombre','$direccion','$telefono','$fecha_hora','activado')";
        return ejecutarConsulta($sql);
    }

    public function editar($idtienda, $nombre, $direccion, $telefono, $fecha_hora)
    {
        $sql = "UPDATE tiendas SET nombre='$nombre',direccion='$direccion',telefono='$telefono',fecha_hora='$fecha_hora' WHERE idtienda='$idtienda'";
        return ejecutarConsulta($sql);
    }

    public function activar($idtienda)
    {
        $sql = "UPDATE tiendas SET estado='activado' WHERE idtienda='$idtienda'";
        return ejecutarConsulta($sql);
    }

    public function desactivar($idtienda)
    {
        $sql = "UPDATE tiendas SET estado='desactivado' WHERE idtienda='$idtienda'";
        return ejecutarConsulta($sql);
    }
}
