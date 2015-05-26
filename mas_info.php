<?php

$response = $_POST['json'];
$datos = json_decode($response, true);
//$datos = array('tipo_id' => 'id_tupper', 'id' => 2);
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
switch ($datos['tipo_id']) {
    case 'id_usuario':
        $valores_campos = array('id' => $datos['id']);
        $campos = array('nombre', 'apellidos','foto','email');
        $d = load('TUPPERWARING.USUARIOS');
        $info="{\"nombre\":" . json_encode($d[0][0]). ",\"apellidos\":" . json_encode($d[0][1]).",\"foto\":" . json_encode($d[0][2]). ",\"email\":" . json_encode($d[0][3]) . "}}";
        break;
    case 'id_tupper':
        $valores_campos = array('id_tupper' => $datos['id']);
        $campos = array('nombre', 'descripcion', 'foto','tipo','vegano','vegetariano','sin_gluten');
        $d = load('TUPPERWARING.TUPPER');
        $info="{\"nombre\":" . json_encode($d[0][0]). ",\"descripcion\":" . json_encode($d[0][1]).",\"foto\":" . json_encode($d[0][2]). ",\"tipo\":" . json_encode($d[0][3]) .",\"vegano\":" . json_encode($d[0][4]).",\"vegetariano\":" . json_encode($d[0][5]).",\"sin_gluten\":" . json_encode($d[0][6]). "}}";
        break;
}
echo "{ \"tipo_id\": " .json_encode($datos['tipo_id']).",\"info\":".$info;