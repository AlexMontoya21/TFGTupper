<?php

require_once("constantes.php");
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
session_start();
$boton='<a href="index.php?iniciaSesion"> <input type="button" class="btn-default" id="login" value="Inicia sesion" style="line-height: 200%;""> </a>'; 
$haztetupper_perfil='#haztetupper';
$titulo = "Inicio";
$plantilla = "plantillas/plantilla.html";
if (isset($_SESSION["id"])) {
    $haztetupper_perfil=$_SESSION["username"];
    $boton='<a href="index.php?cierraSesion"> <input type="button" class="btn-default" id="login" value="Cierra sesion" style="line-height: 200%;""> </a>'; 

    if (isset($_GET["cierraSesion"])) {
        session_destroy();
         header('Location: index.php');
    }
    $usuario = $_SESSION["id"];
    $nombre = $_SESSION["username"];
} else {
    $usuario = "";
    $nombre = "";
}
//CONTROLADOR////////////////////////////////////////////////////////////////////
switch (true) {
    case (isset($_GET["hazteTupper"])):
    case (isset($_GET["iniciaSesion"])):
        if (isset($_SESSION["id"])) {
            $contenido = zona_usuario();
        } else {
            if (isset($_POST["Enviar"])) {
                $contenido=veriForm();
            } else {
                
                $contenido=DisplayFormulario(array(), array(), $duplicado, $logeo, $contrasena);
            }
        }
        break;
    case (isset($_GET["recetas"])):
        $plantilla2 = "plantillas/recetas.html";
        $contenido = file_get_contents($plantilla2);
        break;
    case (isset($_GET["perfil"])):
        $contenido = zona_usuario();
        break;
    case (isset($_GET["plato"])):
        $contenido = generar_tupper();
        $titulo = $_GET['plato'];
        break;
    default:
        $plantilla2 = "plantillas/rueda.html";
        $contenido = file_get_contents($plantilla2);
        break;
}
////////////////////////////////////////////////////////////////////////////////

$datos = array(
    "contenido" => $contenido,
    "boton"=>$boton,
    "haztetupper_perfil"=>$haztetupper_perfil,
    "titulo" => $titulo,
    "usuario" => $nombre,
    "id" => $usuario);
$html = respuesta($datos, $plantilla);
print ($html);

