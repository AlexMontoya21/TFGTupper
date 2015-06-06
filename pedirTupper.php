<?php

$response = $_POST['json'];
$datos = json_decode($response, true);
//$datos = array('usuario' => 1, 'tupper_id' => 25);
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
date_default_timezone_set('Europe/Madrid');
$ele = 0;
$valores_campos = array('id_tupper' => $datos['tupper_id']);
$campos = array('id_solicitante');
$disponible = load('TUPPERWARING.TUPPER');
$valores_campos = array('id_tupper' => $datos['tupper_id']);
$campos = array('nombre', 'id_usuario');
$datos_tupper = load('TUPPERWARING.TUPPER');
if ($disponible[0][0] == NULL && $datos['usuario'] != $datos_tupper[0][1]) {
    $valores_campos = array('id_solicitante' => $datos['usuario']);
    $campos = array('id_tupper' => $datos['tupper_id']);
    $ele = modificar('TUPPERWARING.TUPPER');
    if ($ele = 1) {
        $valores_campos = array('id' => $datos['usuario']);
        $campos = array('nombre', 'apellidos');
        $nombre_usuario = load('TUPPERWARING.USUARIOS');
        $fecha = date("Y-m-d");
        $hora = date("H") . ":" . date("i");
        $mensaje ="<a href='javascript:void(0)' onclick='info(\"id_usuario\", ".$datos['usuario'].")'>".$nombre_usuario[0][0] . " " . $nombre_usuario[0][1] . "</a> ha pedido tu tupper de <a href='javascript:void(0)'  onclick='info(\"id_tupper\", ".$datos['tupper_id'].")'>".$datos_tupper[0][0]."</a>";
        $valores_campos = array('id_e' => $datos['usuario'], 'id_r' => $datos_tupper[0][1], 'id_tupper' => $datos['tupper_id'], 'fecha' => $fecha, 'hora' => $hora, 'mensaje' => $mensaje);
        guardar($valores_campos, 'TUPPERWARING.MENSAJES');
    }
}


