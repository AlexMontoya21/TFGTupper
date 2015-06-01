<?php

require_once("constantes.php");
require_once("funciones_vista.php");
require_once("SQL.php");
session_start();
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
$nombre = (isset($_POST['nombre_tupper'])) ? $_POST['nombre_tupper'] : "";
$tipo = $_POST['tipo_tupper'];
$vegano = (isset($_POST['vegano_tupper'])) ? 1 : 0;
$vegetariano = (isset($_POST['vegetariano_tupper'])) ? 1 : 0;
$sin_gluten = (isset($_POST['sin_gluten_tupper'])) ? 1 : 0;
$descripcion = (isset($_POST['descripcion_tupper']) && $_POST['descripcion_tupper'] != "") ? $_POST['descripcion_tupper'] : "No hay descripcion";
$descripcion = preg_replace("/style=[A-Za-z0-9'#.:\-,_ ;\"]*/", "", $descripcion);
$descripcion = preg_replace("/<img[A-Za-z0-9'#=%.:!\/\-,_ ;\"]*/", " ", $descripcion);
$foto='sin_foto.jpg';

if (isset($_FILES["imagen_tupper"]) and ($_FILES["imagen_tupper"]["error"] == UPLOAD_ERR_OK)) {
        if (!move_uploaded_file($_FILES["imagen_tupper"]["tmp_name"], "img/foto_tuppers/" . basename($_FILES["imagen_tupper"]["name"]))) {
            $mensaje.= "<p class='error2'>Lo sentimos, hubo un problema al subir esa foto" . $_FILES["imagen_tupper"]["error"] . "</p>";
        } else {
            $foto = $_FILES["imagen_tupper"]["name"];
        }
    }
if ($nombre != "" && isset($_SESSION["id"])) {
    $valores_campos = array('nombre' => $nombre, 'id_usuario' => $_SESSION["id"], 'tipo' => $tipo, 'foto' => $foto, 'vegano' => $vegano, 'vegetariano' => $vegetariano, 'sin_gluten' => $sin_gluten, "descripcion" => $descripcion, "solicitado" => 0);
    $resultado = guardar($valores_campos, 'TUPPERWARING.TUPPER');
}
header('Location: index.php?hazteTupper');
