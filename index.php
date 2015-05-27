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
session_start();


if (isset ($_POST["login"])){
    session_destroy();
}
    if (isset( $_SESSION["id"])){
$usuario = $_SESSION["id"];
$nombre=$_SESSION["username"];
}
else {
    $usuario="";
    $nombre="";
}


    if (isset($_GET["hazteTupper"]) || isset($_GET["iniciaSesion"])) {
        if ($usuario != "") {
            zona_usuario();
        } else {
            if (isset($_POST["Enviar"])) {
                veriForm();
            } else {
                DisplayFormulario(array(), array(), $duplicado, $logeo, $contrasena);
            }
        }
    } else {

        if (isset($_GET["recetas"])) {
            
                   pintar("plantillas/recetas.html",$usuario,$nombre);
            
        }else {
            if (isset($_GET["perfil"])){
                    
                    zona_usuario();
                }

             else { if (isset($_GET["plato"])) {
                $contenido = generar_tupper();
                $titulo = $_GET['plato'];
            
                    $datos = array(
                "contenido" => $contenido,
                "titulo" => $titulo,
                "usuario" => $nombre,
                 "id"=> $usuario );
                    
            if (!isset($_SESSION["username"])) {
                $plantilla = "plantillas/plantilla.html";
            } else
                $plantilla = "plantillas/plantilla.php";
            $html = respuesta($datos, $plantilla);
            print ($html);
                
            } else {
           
               pintar("plantillas/rueda.html",$usuario,$nombre);
               
            }
           
        } 
    }
    }
   
    
    
function pintar($plantilla,$id,$nombre){
    

                $contenido = file_get_contents($plantilla);
            $titulo = "Inicio";
                if (!isset($_SESSION["username"])) {
                $plantilla = "plantillas/plantilla.html";
            } else{
            $plantilla = "plantillas/plantilla.php";}
                     $datos = array(
                "contenido" => $contenido,
                "titulo" => $titulo,
                "usuario" => $nombre,
                 "id"=> $id );       
            $html = respuesta($datos, $plantilla);
            print ($html);
    
}
