<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

class Login
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function verificar($usuario, $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND clave='$clave'";
        return ejecutarConsulta($sql);
    }

    public function agregar($nombres, $apellidos, $tipo_documento, $num_documento, $fecha_nac, $telefono, $email, $usuario, $clave)
    {
        $sql = "INSERT INTO usuarios (nombres,apellidos,tipo_documento,num_documento,direccion,telefono,email,fecha_nac,descripcion,rol,usuario,clave,imagen,estado)
		VALUES ('$nombres','$apellidos','$tipo_documento','$num_documento','','$telefono','$email','$fecha_nac','','usuario','$usuario','$clave','default.jpg',1";
        return ejecutarConsulta($sql);
    }

    public function actualizarEstadoUsuario($idusuario, $estado)
    {
        $sql = "UPDATE usuarios SET estado = '$estado' WHERE idusuario = $idusuario";
        return ejecutarConsulta($sql);
    }
}
