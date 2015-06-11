<?php

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
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$id_tupper = $_POST['id_tupper'];
$tipo = $_POST['tipo_tupper'];
$vegano = (isset($_POST['vegano_tupper'])) ? 1 : 0;
$vegetariano = (isset($_POST['vegetariano_tupper'])) ? 1 : 0;
$sin_gluten = (isset($_POST['sin_gluten_tupper'])) ? 1 : 0;
$descripcion = (isset($_POST['descripcion']) && $_POST['descripcion'] != "") ? $_POST['descripcion'] : "No hay descripcion";
$descripcion = preg_replace("/style=[A-Za-z0-9'#.:\-,_ ;\"]*/", "", $descripcion);
$descripcion = preg_replace("/<img[A-Za-z0-9'#=%.:!\/\-,_ ;\"]*/", " ", $descripcion);


//echo $nombre;
//echo $tipo;
//echo $vegano;
//echo $vegetariano;
//echo $sin_gluten;
//echo $descripcion;


//$nombre = 'ejemplo';
//$tipo = 'carne';
//$vegano = 1;
//$vegetariano = 0;
//$sin_gluten = 0;
//$descripcion = 'hola tambien';
//$foto = 'sin_foto.jpg';
//$campos=array('id_tupper'=>65);


$campos=array('id_tupper'=>$id_tupper);
$valores_campos = array('nombre' => $nombre, 'tipo' => $tipo, 'foto' => $foto, 'vegano' => $vegano, 'vegetariano' => $vegetariano, 'sin_gluten' => $sin_gluten, "descripcion" => $descripcion,);

if (isset($_FILES["foto"]) and ( $_FILES["foto"]["error"] == UPLOAD_ERR_OK)) {
    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], "img/foto_tuppers/" . basename($_FILES["foto"]["name"]))) {
        $mensaje.= "<p class='error2'>Lo sentimos, hubo un problema al subir esa foto" . $_FILES["foto"]["error"] . "</p>";
    } else {
        $valores_campos['foto'] = $_FILES["foto"]["name"];
    }
}
else{
    $valores_campos['foto'] = 'sin_foto.jpg';
}

$resultado = modificar('TUPPERWARING.TUPPER');
header("Location: index.php?tupperEditado");

