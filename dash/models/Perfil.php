<?php
//Incluímos inicialmente la conexión a la base de datos
require "../server/conexion.php";

class Perfil
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Función para listar los datos del perfil
    public function listarPerfilUsuario($idusuario)
    {
        $sql = "SELECT * FROM usuarios WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Función para editar los datos del perfil
    public function editar($idusuario, $nombres, $apellidos, $usuario, $email, $imagen, $fecha_nac, $tipo_documento, $num_documento, $telefono, $direccion, $descripcion)
    {
        $sql = "UPDATE usuarios SET nombres='$nombres',apellidos='$apellidos',usuario='$usuario',email='$email',imagen='$imagen',fecha_nac='$fecha_nac',tipo_documento='$tipo_documento',num_documento='$num_documento',telefono='$telefono',direccion='$direccion',descripcion='$descripcion' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }
}
