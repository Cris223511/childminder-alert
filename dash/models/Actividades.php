<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

class Actividad
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $sql = "SELECT a.idactividad, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, a.titulo, a.descripcion, a.imagen, 
                CONCAT(
                    DAY(a.fecha_hora), ' de ',
                    CASE 
                        WHEN MONTH(a.fecha_hora) = 1 THEN 'enero'
                        WHEN MONTH(a.fecha_hora) = 2 THEN 'febrero'
                        WHEN MONTH(a.fecha_hora) = 3 THEN 'marzo'
                        WHEN MONTH(a.fecha_hora) = 4 THEN 'abril'
                        WHEN MONTH(a.fecha_hora) = 5 THEN 'mayo'
                        WHEN MONTH(a.fecha_hora) = 6 THEN 'junio'
                        WHEN MONTH(a.fecha_hora) = 7 THEN 'julio'
                        WHEN MONTH(a.fecha_hora) = 8 THEN 'agosto'
                        WHEN MONTH(a.fecha_hora) = 9 THEN 'septiembre'
                        WHEN MONTH(a.fecha_hora) = 10 THEN 'octubre'
                        WHEN MONTH(a.fecha_hora) = 11 THEN 'noviembre'
                        WHEN MONTH(a.fecha_hora) = 12 THEN 'diciembre'
                    END,
                    ' del ',
                    YEAR(a.fecha_hora),
                    ', a las ',
                    CASE
                        WHEN HOUR(a.fecha_hora) < 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' am')
                        WHEN HOUR(a.fecha_hora) = 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' pm')
                        ELSE CONCAT(HOUR(a.fecha_hora) - 12, ':', LPAD(MINUTE(a.fecha_hora), 2, '0'), ' pm')
                    END
                ) AS fecha_hora, a.estado
            FROM actividades a
            INNER JOIN usuarios u ON a.idusuario = u.idusuario
            ORDER BY a.idactividad DESC";
        return ejecutarConsulta($sql);
    }

    public function listarPorUsuario($usuario)
    {
        $sql = "SELECT a.idactividad, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, a.titulo, a.descripcion, a.imagen,
                CONCAT(
                    DAY(a.fecha_hora), ' de ',
                    CASE 
                        WHEN MONTH(a.fecha_hora) = 1 THEN 'enero'
                        WHEN MONTH(a.fecha_hora) = 2 THEN 'febrero'
                        WHEN MONTH(a.fecha_hora) = 3 THEN 'marzo'
                        WHEN MONTH(a.fecha_hora) = 4 THEN 'abril'
                        WHEN MONTH(a.fecha_hora) = 5 THEN 'mayo'
                        WHEN MONTH(a.fecha_hora) = 6 THEN 'junio'
                        WHEN MONTH(a.fecha_hora) = 7 THEN 'julio'
                        WHEN MONTH(a.fecha_hora) = 8 THEN 'agosto'
                        WHEN MONTH(a.fecha_hora) = 9 THEN 'septiembre'
                        WHEN MONTH(a.fecha_hora) = 10 THEN 'octubre'
                        WHEN MONTH(a.fecha_hora) = 11 THEN 'noviembre'
                        WHEN MONTH(a.fecha_hora) = 12 THEN 'diciembre'
                    END,
                    ' del ',
                    YEAR(a.fecha_hora),
                    ', a las ',
                    CASE
                        WHEN HOUR(a.fecha_hora) < 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' am')
                        WHEN HOUR(a.fecha_hora) = 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' pm')
                        ELSE CONCAT(HOUR(a.fecha_hora) - 12, ':', LPAD(MINUTE(a.fecha_hora), 2, '0'), ' pm')
                    END
                ) AS fecha_hora, a.estado
            FROM actividades a
            INNER JOIN usuarios u ON a.idusuario = u.idusuario
            WHERE a.idusuario = '$usuario'
            ORDER BY a.idactividad DESC";
        return ejecutarConsulta($sql);
    }

    public function listarActividadesDashboard()
    {
        $sql = "SELECT a.idactividad, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, a.titulo, a.imagen, 
                CONCAT(
                    DAY(a.fecha_hora), ' de ',
                    CASE 
                        WHEN MONTH(a.fecha_hora) = 1 THEN 'enero'
                        WHEN MONTH(a.fecha_hora) = 2 THEN 'febrero'
                        WHEN MONTH(a.fecha_hora) = 3 THEN 'marzo'
                        WHEN MONTH(a.fecha_hora) = 4 THEN 'abril'
                        WHEN MONTH(a.fecha_hora) = 5 THEN 'mayo'
                        WHEN MONTH(a.fecha_hora) = 6 THEN 'junio'
                        WHEN MONTH(a.fecha_hora) = 7 THEN 'julio'
                        WHEN MONTH(a.fecha_hora) = 8 THEN 'agosto'
                        WHEN MONTH(a.fecha_hora) = 9 THEN 'septiembre'
                        WHEN MONTH(a.fecha_hora) = 10 THEN 'octubre'
                        WHEN MONTH(a.fecha_hora) = 11 THEN 'noviembre'
                        WHEN MONTH(a.fecha_hora) = 12 THEN 'diciembre'
                    END,
                    ' del ',
                    YEAR(a.fecha_hora),
                    ', a las ',
                    CASE
                        WHEN HOUR(a.fecha_hora) < 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' am')
                        WHEN HOUR(a.fecha_hora) = 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' pm')
                        ELSE CONCAT(HOUR(a.fecha_hora) - 12, ':', LPAD(MINUTE(a.fecha_hora), 2, '0'), ' pm')
                    END
                ) AS fecha_hora, a.estado
            FROM actividades a 
            INNER JOIN usuarios u ON a.idusuario = u.idusuario
            ORDER BY a.idactividad DESC
            LIMIT 3";
        return ejecutarConsulta($sql);
    }

    public function listarActividadesDashboardPorUsuario($usuario)
    {
        $sql = "SELECT a.idactividad, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, a.titulo, a.imagen,
                CONCAT(
                    DAY(a.fecha_hora), ' de ',
                    CASE 
                        WHEN MONTH(a.fecha_hora) = 1 THEN 'enero'
                        WHEN MONTH(a.fecha_hora) = 2 THEN 'febrero'
                        WHEN MONTH(a.fecha_hora) = 3 THEN 'marzo'
                        WHEN MONTH(a.fecha_hora) = 4 THEN 'abril'
                        WHEN MONTH(a.fecha_hora) = 5 THEN 'mayo'
                        WHEN MONTH(a.fecha_hora) = 6 THEN 'junio'
                        WHEN MONTH(a.fecha_hora) = 7 THEN 'julio'
                        WHEN MONTH(a.fecha_hora) = 8 THEN 'agosto'
                        WHEN MONTH(a.fecha_hora) = 9 THEN 'septiembre'
                        WHEN MONTH(a.fecha_hora) = 10 THEN 'octubre'
                        WHEN MONTH(a.fecha_hora) = 11 THEN 'noviembre'
                        WHEN MONTH(a.fecha_hora) = 12 THEN 'diciembre'
                    END,
                    ' del ',
                    YEAR(a.fecha_hora),
                    ', a las ',
                    CASE
                        WHEN HOUR(a.fecha_hora) < 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' am')
                        WHEN HOUR(a.fecha_hora) = 12 THEN CONCAT(HOUR(a.fecha_hora), ':', MINUTE(a.fecha_hora), ' pm')
                        ELSE CONCAT(HOUR(a.fecha_hora) - 12, ':', LPAD(MINUTE(a.fecha_hora), 2, '0'), ' pm')
                    END
                ) AS fecha_hora, a.estado
            FROM actividades a 
            INNER JOIN usuarios u ON a.idusuario = u.idusuario
            WHERE a.idusuario = '$usuario'
            ORDER BY a.idactividad DESC
            LIMIT 3";
        return ejecutarConsulta($sql);
    }

    public function agregar($idusuario, $titulo, $descripcion, $imagen, $fecha_hora)
    {
        $sql = "INSERT INTO actividades (idusuario,titulo,descripcion,imagen,fecha_hora,estado)
    VALUES ('$idusuario','$titulo','$descripcion','$imagen','$fecha_hora','pendiente')";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idactividad)
    {
        $sql = "SELECT a.idactividad, CONCAT(u.nombres, ' ', u.apellidos) AS usuario, a.titulo, a.descripcion, a.imagen, a.fecha_hora, a.estado FROM actividades a INNER JOIN usuarios u ON a.idusuario = u.idusuario WHERE a.idactividad = '$idactividad'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function editar($idactividad, $titulo, $descripcion, $imagen, $fecha_hora)
    {
        $sql = "UPDATE actividades SET titulo='$titulo',descripcion='$descripcion',imagen='$imagen',fecha_hora='$fecha_hora' WHERE idactividad='$idactividad'";
        return ejecutarConsulta($sql);
    }

    public function eliminar($idactividad)
    {
        $sql = "DELETE FROM actividades WHERE idactividad='$idactividad'";
        return ejecutarConsulta($sql);
    }

    public function finalizar($idactividad)
    {
        $sql = "UPDATE actividades SET estado='finalizado' WHERE idactividad='$idactividad'";
        return ejecutarConsulta($sql);
    }

    public function activar($idactividad)
    {
        $sql = "UPDATE actividades SET estado='pendiente' WHERE idactividad='$idactividad'";
        return ejecutarConsulta($sql);
    }
}
