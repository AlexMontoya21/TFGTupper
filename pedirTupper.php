<?php

$response = $_POST['json'];
$datos = json_decode($response,true);
require_once("constantes.php");
require_once("contador.php");
require_once("contadorVista.php");
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
$valores_campos = array('id_solicitante' => $datos['usuario']);
$campos = array('id_tupper' => $datos['tupper_id']);
$ele=modificar('TUPPERWARING.TUPPER');
echo $ele;
