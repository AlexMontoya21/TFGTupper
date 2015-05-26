<?php

require_once("constantes.php");
require_once("contador.php");
require_once("contadorVista.php");
require_once("SQL.php");
require_once("sql_user.php");
include ("FormularioServidor.php");
require_once("funciones_vista.php");
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
$campos = array('id_tupper', 'nombre', 'foto', 'descripcion', 'tipo', 'vegano', 'vegetariano', 'id_solicitante', 'id_usuario', 'solicitado');
$valores_campos;
$mensajeAbrirConexion = "";
$usuario = "1";
if (!isset($_SESSION["username"])) {
    if (isset($_GET["hazteTupper"]) || isset($_GET["iniciaSesion"])) {
        if ($usuario != "") {
            zona_usuario();
        } else {
            if (isset($_POST["Enviar"])) {
                veriForm();
            } else {
                DisplayFormulario(array(), array(), $duplicado, $logeo, $contraseña);
            }
        }
    } else {

        if (isset($_GET["recetas"])) {
            $contenido = file_get_contents("plantillas/recetas.html");
            $titulo = "Inicio";

            $datos = array(
                "contenido" => $contenido,
                "titulo" => $titulo
            );
            if (!isset($_SESSION["username"])) {
                $plantilla = "plantillas/plantilla.html";
            } else
                $plantilla = "plantillas/plantilla.php";

            $html = respuesta($datos, $plantilla);
            print ($html);
        }else {

            if (isset($_GET["plato"])) {
                $contenido = generar_tupper();
                $titulo = $_GET['plato'];
            } else {
                $contenido = file_get_contents("plantillas/rueda.html");
                $titulo = "Inicio";
            }
            $datos = array(
                "contenido" => $contenido,
                "titulo" => $titulo
            );
            if (!isset($_SESSION["username"])) {
                $plantilla = "plantillas/plantilla.html";
            } else
                $plantilla = "plantillas/plantilla.php";
            $html = respuesta($datos, $plantilla);
            print ($html);
        }
    }
}
    
    

