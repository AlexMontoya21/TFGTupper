<?php

$response = $_POST['json'];
$datos = json_decode($response, true);
//$datos = array('id' => 2);
require_once("constantes.php");
require_once("funciones_vista.php");
require_once("SQL.php");
$funcion = "";
$colWhere = array();
$colSelect = array();
$colFrom = array();
$ejecutar = array();
$colValue = array();
$tipos = "";
$conexion = "";
$mensaje = "";
$consulta = null;
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
        $valores_campos = array('id_r' => $datos['id']);
        $campos = array('id_mensaje');
        $d = load('TUPPERWARING.MENSAJES');
        $notificaciones=count($d);
        $valores_campos = array('id' => $datos['id']);
        $campos = array('nombre','apellidos');
        $d = load('TUPPERWARING.USUARIOS');
echo "{ \"notificaciones\": " .json_encode($notificaciones).", \"usuario\": \"" .$d[0][0]." ".$d[0][1]."\"}";