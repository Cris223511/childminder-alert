<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Reporte
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function mostrarDatosReporte1()
    {
        $sql = "SELECT 'Cantidad total de postulantes' AS titulo, 'bg-gradient-primary shadow-primary' AS color, 'ni ni-planet' AS icon, COUNT(*) AS cantidad FROM postulantes
                UNION
                SELECT 'Cantidad total de puestos' AS titulo, 'bg-gradient-danger shadow-danger' AS color, 'ni ni-basket' AS icon, COUNT(*) AS cantidad FROM puestos
                UNION
                SELECT 'Cantidad total de tiendas' AS titulo, 'bg-gradient-warning shadow-warning' AS color, 'ni ni-cart' AS icon, COUNT(*) AS cantidad FROM tiendas
                UNION
                SELECT 'Cantidad total de trabajadores' AS titulo, 'bg-gradient-success shadow-success' AS color, 'ni ni-paper-diploma' AS icon, COUNT(*) AS cantidad FROM usuarios";

        return ejecutarConsulta($sql);
    }

    public function mostrarDatosReporte2()
    {
        $sql = "SELECT 'Postulantes aprobados' AS titulo, 'fas fa-plus' AS icon, COUNT(*) AS cantidad FROM postulados WHERE estado = 'aprobado'
                UNION
                SELECT 'Postulantes pendientes' AS titulo, 'fas fa-circle-info' AS icon, COUNT(*) AS cantidad FROM postulados WHERE estado NOT IN ('aprobado', 'rechazado')
                UNION
                SELECT 'Postulantes rechazados' AS titulo, 'fas fa-minus' AS icon, COUNT(*) AS cantidad FROM postulados WHERE estado = 'rechazado'";

        return ejecutarConsulta($sql);
    }

    public function mostrarDatosReporte3()
    {
        $sql = "SELECT p.idpostulante, p.nombres, p.apellidos, pt.titulo, pt.ubicacion, pt.empresa, CONCAT(DAY(pr.fecha_hora), ' de ', 
                    CASE MONTH(pr.fecha_hora)
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
                    END, ' del ', YEAR(pr.fecha_hora)) as fecha, pr.puntaje_total
                FROM postulados AS pr
                INNER JOIN postulantes AS p ON pr.idpostulante = p.idpostulante
                INNER JOIN puestos AS pt ON pr.idpuesto = pt.idpuesto
                ORDER BY pr.puntaje_total DESC
                LIMIT 3";

        return ejecutarConsulta($sql);
    }

    public function mostrarDatosReporte4()
    {
        $sql_postulados = "SELECT COUNT(*) AS cantidad_postulados, MONTH(fecha_hora) AS mes_postulado FROM postulados GROUP BY MONTH(fecha_hora)";
        $rspta_postulados = ejecutarConsulta($sql_postulados);
        $rows_postulados = $rspta_postulados->fetchAll(PDO::FETCH_ASSOC);

        $sql_postulantes = "SELECT COUNT(*) AS cantidad_postulantes, MONTH(fecha_registro) AS mes_registro FROM postulantes GROUP BY MONTH(fecha_registro)";
        $rspta_postulantes = ejecutarConsulta($sql_postulantes);
        $rows_postulantes = $rspta_postulantes->fetchAll(PDO::FETCH_ASSOC);

        return ['postulados' => $rows_postulados, 'postulantes' => $rows_postulantes];
    }
}
