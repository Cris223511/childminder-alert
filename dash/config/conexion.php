<?php
require_once "global.php";

try {
    $conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USERNAME, DB_PASSWORD);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Falló la conexión a la base de datos: " . $e->getMessage();
    exit();
}

if (!function_exists('ejecutarConsulta')) {
    function ejecutarConsulta($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }

    function ejecutarConsultaSimpleFila($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function ejecutarConsulta_retornarID($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->lastInsertId();
    }

    function limpiarCadena($str)
    {
        global $conexion;
        $str = trim($str);
        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        return $str;
    }
}
