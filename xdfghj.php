<?php

$id = 5;
require_once("constantes.php");
require_once("contador.php");
require_once("contadorVista.php");
require_once("SQL.php");
$campos = array('solicitado', 'id_usario');
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
$valores_campos = array();
$mensajeAbrirConexion = "";
$sql = load('TUPPERWARING.TUPPER');
$valores_campos = array('solicitado' => 1);
$campos = array('id_tupper' => $id);
$ele=modificar('TUPPERWARING.TUPPER');



