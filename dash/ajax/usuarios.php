<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); // Validamos si existe o no la sesión.
}

if ((empty($_SESSION['idusuario']) || $_SESSION['rol'] !== 'admin')) {
    echo json_encode(['error' => 'No está autorizado para realizar esta acción.']);
    exit();
}

require_once "../models/Usuarios.php";

$usuarios = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$usuario = isset($_POST["usuario"]) ? limpiarCadena($_POST["usuario"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$fecha_nac = isset($_POST["fecha_nac"]) ? limpiarCadena($_POST["fecha_nac"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$rol = isset($_POST["rol"]) ? limpiarCadena($_POST["rol"]) : "";

switch ($_GET["op"]) {
}

ob_end_flush();
