<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Evaluacion
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $sql = "SELECT e.idevaluacion, e.idusuario, u.nombres as usuario, u.rol as rol, e.titulo, DATE_FORMAT(e.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora FROM evaluaciones e INNER JOIN usuarios u ON e.idusuario = u.idusuario ORDER BY e.idevaluacion DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPorUsuario($usuario)
    {
        $sql = "SELECT e.idevaluacion, e.idusuario, u.nombres as usuario, u.rol as rol, e.titulo, DATE_FORMAT(e.fecha_hora, '%d-%m-%Y %H:%i:%s') as fecha_hora FROM evaluaciones e INNER JOIN usuarios u ON e.idusuario = u.idusuario WHERE e.idusuario = '$usuario' ORDER BY e.idevaluacion DESC";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idevaluacion)
    {
        $sql = "SELECT e.idevaluacion, e.idusuario, u.nombres as usuario, e.titulo, e.preguntas, e.fecha_hora FROM evaluaciones e INNER JOIN usuarios u ON e.idusuario = u.idusuario WHERE e.idevaluacion = '$idevaluacion'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function agregar($usuario, $titulo, $preguntas, $fecha_hora)
    {
        $sql = "INSERT INTO evaluaciones (idusuario,titulo,preguntas,fecha_hora)
		VALUES ('$usuario','$titulo','$preguntas','$fecha_hora')";
        return ejecutarConsulta($sql);
    }

    public function editar($idevaluacion, $titulo, $preguntas, $fecha_hora)
    {
        $sql = "UPDATE evaluaciones SET titulo='$titulo',preguntas='$preguntas',fecha_hora='$fecha_hora' WHERE idevaluacion='$idevaluacion'";
        return ejecutarConsulta($sql);
    }

    public function eliminar($idevaluacion)
    {
        $sql = "DELETE FROM evaluaciones WHERE idevaluacion='$idevaluacion'";
        return ejecutarConsulta($sql);
    }
}
