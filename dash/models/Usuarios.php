<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

class Usuario
{
    public function __construct()
    {
    }

    public function actualizarEstadoUsuario($idusuario, $estado)
    {
        $sql = "UPDATE usuarios SET estado = '$estado' WHERE idusuario = $idusuario";
        return ejecutarConsulta($sql);
    }
}
