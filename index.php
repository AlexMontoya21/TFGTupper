<?php

require_once("constantes.php");
require_once("contador.php");
require_once("contadorVista.php");
require_once("SQL.php");
require_once("sql_user.php");
include ("FormularioServidor.php");

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

if (!isset($_SESSION["username"])){
if (isset($_GET["hazteTupper"]) || isset($_GET["iniciaSesion"])  ) {
    if (isset($_POST["Enviar"])) {
        veriForm();
    } else
        DisplayFormulario(array(), array(),$duplicado,$logeo,$contraseña);
}else {

    if (isset($_GET["recetas"])) {
        $contenido = file_get_contents("plantillas/recetas.html");
        $titulo = "Inicio";

        $datos = array(
            "contenido" => $contenido,
            "titulo" => $titulo
        );
    if (!isset($_SESSION["username"])){
    $plantilla = "plantillas/plantilla.html";}
    else 
        $plantilla = "plantillas/plantilla.php";
    
        $html = respuesta($datos, $plantilla);
        print ($html);
    }else {
    
    if (isset($_GET["plato"])) {
        switch ($_GET['plato']) {
            case 'carne':
                $plato = 'carne';
                break;
            case 'arroz':
                $plato = 'arroz';
                break;
            case 'verduras':
                $plato = 'verduras';
                break;
            case 'entrantes':
                $plato = 'entrantes';
                break;
            case 'pucheros':
                $plato = 'pucheros';
                break;
            case 'postres':
                $plato = 'postres';
                break;
            case 'pasta':
                $plato = 'pasta';
                break;
            case 'pescado':
                $plato = 'pescado';
                break;
            case 'todos':
                $plato = 'todos';
                break;
            default:
                $plato = '';
        }
        if (isset($plato) and $plato != 'todos') {
            $valores_campos = array('tipo' => $plato);
        } else {
            $valores_campos = array();
        }


////generar la consulta///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $contenido = '';
        $sql = load('TUPPERWARING.TUPPER');
        $t = "<div class='titulo'><h1>$plato</h1></div>";
        $t.="<div class='selects'> Vegano <input type='checkbox' id='checkbox-8-2' name='vegano'/><label for='checkbox-8-2'></label><br>Vegetariano <input type='checkbox' id='checkbox-8-3' name='vegetariano'/><label for='checkbox-8-3'></label></div>";
        $t.="<div class='resultado'>";
        foreach ($sql as $tuppers) {
            $order = array();
            $vegano = ($tuppers[5] == 1) ? 'vegano' : '';
            $vegetariano = ($tuppers[6] == 1) ? 'vegetariano' : '';
            $vegano2 = ($tuppers[5] == 1) ? '<p class="vegano"><span class="glyphicon glyphicon-leaf"></span> Vegano</p>' : '';
            $vegetariano2 = ($tuppers[6] == 1) ? '<p class="vegetariano"><span class="glyphicon glyphicon-leaf"></span> Vegetariano</p>' : '';
            $pedido = ($tuppers[7] == null) ? "" : " disabled='disabled' ";
            $pedido_value = ($tuppers[7] == null) ? "Pedir Tupper" : "El tupper ya ha sido pedido";
            $t.= '<div class="tupper';
            $t.= " $vegano $vegetariano";
            $t.= '">';
            $t.='<div class="foto">';
            $t.="<img src='";
            $t.=$tuppers[2];
            $t.="'>";
            $t.='</div><div class="contenido">';
            $t.="<h2>$tuppers[1]</h2><span class='usuario'>de</span>";
            $t.='<div class="puntuacion"></div>';
            $t.='<p>';
            $t.=$tuppers[3];
            $t.='</p>';
            $t.='</div>';
            $t.=$vegano2 . " " . $vegetariano2;
            $t.= '<input type="button" class="pedir"  id="' . $tuppers[0] . '" value="' . $pedido_value . '"' . $pedido . 'onclick="peticion(this)">';
            $t.='</div>';
        }
        $t.='</div>';
        $contenido = $t;
        $titulo = $plato;
    } else {
        $contenido = file_get_contents("plantillas/rueda.html");
        $titulo = "Inicio";
    }
    $datos = array(
        "contenido" => $contenido,
        "titulo" => $titulo
    );
    if (!isset($_SESSION["username"])){
    $plantilla = "plantillas/plantilla.html";}
    else 
        $plantilla = "plantillas/plantilla.php";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

    }
}
    
    

