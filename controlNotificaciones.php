<?php

$response = $_POST['json'];
$datos = json_decode($response, true);
//$datos = array('opcion'=>'aceptar','id_tupper' => 25, 'id_mensaje' => 1);
require_once("constantes.php");
require_once("funciones_vista.php");
require_once("SQL.php");
date_default_timezone_set('Europe/Madrid');
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
switch ($datos['opcion']) {
    case 'aceptar':
        $valores_campos = array('solicitado' => 1);
        $campos = array('id_tupper' => $datos['id_tupper']);
        $exito = modificar('TUPPERWARING.TUPPER');
        $valores_campos = array('id_tupper' => $datos['id_tupper']);
        $campos = array('id_usuario', 'nombre', 'id_solicitante');
        $idu_tupper = load('TUPPERWARING.TUPPER');
        $valores_campos = array('id' => $idu_tupper[0][0]);
        $campos = array('nombre', 'apellidos');
        $nombre_usuario = load('TUPPERWARING.USUARIOS');
        $mensaje = "<a href='javascript:void(0)' onclick='info(\"id_usuario\", ". $idu_tupper[0][0].")'>". $nombre_usuario[0][0] . " " . $nombre_usuario[0][1] . "</a> ha aceptado tu peticion del tupper de <a href='javascript:void(0)'  onclick='info(\"id_tupper\", ".$datos['id_tupper'].")'>".$idu_tupper[0][1]."</a>";
        $fecha = date("Y-m-d");
        $hora = date("H") . ":" . date("i");
        $valores_campos = array('id_e' => $idu_tupper[0][0], 'id_r' => $idu_tupper[0][2], 'fecha' => $fecha, 'hora' => $hora, 'mensaje' => $mensaje);
        $exito = guardar($valores_campos, 'TUPPERWARING.MENSAJES');
        $exito = 1;
        break;
    case 'cancelar':
        $valores_campos = array('id_solicitante' => null);
        $campos = array('id_tupper' => $datos['id_tupper']);
        $exito = modificar('TUPPERWARING.TUPPER');
        break;
    case 'ok':
        $exito = 1;
        break;
    case 'eliminar':
        $valores_campos = array('id_tupper' => $datos['id_tupper']);
        eliminar('TUPPERWARING.TUPPER');
        $exito = 0;
        break;
     case 'cancelar peticion':
        $valores_campos = array('id_solicitante' => null);
        $campos = array('id_tupper' => $datos['id_tupper']);
        $exito=modificar('TUPPERWARING.TUPPER');
        $valores_campos = array('id_tupper' => $datos['id_tupper']);
        eliminar('TUPPERWARING.MENSAJES');
        $exito = 0;
        break;
    
}

if ($exito != 0) {
    $valores_campos = array('id_mensaje' => $datos['id_mensaje']);
    eliminar('TUPPERWARING.MENSAJES');
}


