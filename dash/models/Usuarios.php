<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Usuario
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Función para verificar el acceso al sistema
    public function verificar($usuario, $clave)
    {
        $sql = "SELECT idusuario, nombres, usuario, rol FROM usuarios WHERE usuario='$usuario' AND clave='$clave'";
        return ejecutarConsulta($sql);
    }

    //Función para actualizar el estado del usuario
    public function actualizarEstadoUsuario($idusuario, $estado)
    {
        $sql = "UPDATE usuarios SET estado = '$estado' WHERE idusuario = $idusuario";
        return ejecutarConsulta($sql);
    }

    public function listar()
    {
        $sql = "SELECT * FROM usuarios";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idusuario)
    {
        $sql = "SELECT idusuario, nombres, apellidos, tipo_documento, num_documento, direccion, telefono, email, fecha_nac, descripcion, usuario, clave, imagen, rol FROM usuarios WHERE idusuario = $idusuario";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function agregar($nombres, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $descripcion, $usuario, $clave, $imagen)
    {
        $sql = "INSERT INTO usuarios (nombres,apellidos,tipo_documento,num_documento,direccion,telefono,email,fecha_nac,descripcion,rol,usuario,clave,imagen,estado)
		VALUES ('$nombres','$apellidos','$tipo_documento','$num_documento','$direccion','$telefono','$email','$fecha_nac','$descripcion','jefe_tienda','$usuario','$clave','$imagen','0')";
        return ejecutarConsulta($sql);
    }

    public function editar($idusuario, $nombres, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $descripcion, $usuario, $clave, $imagen)
    {
        $sql = "UPDATE usuarios SET nombres='$nombres',apellidos='$apellidos',usuario='$usuario',clave='$clave',email='$email',imagen='$imagen',fecha_nac='$fecha_nac',tipo_documento='$tipo_documento',num_documento='$num_documento',telefono='$telefono',direccion='$direccion',descripcion='$descripcion' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    public function editarRol($idusuario, $rol)
    {
        $sql = "UPDATE usuarios SET rol='$rol' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    public function eliminar($idusuario)
    {
        $sql = "DELETE FROM usuarios WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }
}
