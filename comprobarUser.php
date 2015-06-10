<?php
session_start();
$response = $_POST['json'];
$datos = json_decode($response, true);
require_once("constantes.php");
require_once("funciones_vista.php");
require_once("sql_user.php");
require_once("sql.php");
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


//CAMPOS CAMBIO//
//    $cont=0;
//    $camposcambio= array("username","dni","telefono","email","password");
//     $camposcambiar=array();
//     foreach ($camposcambio as $key ){
//        if (($_POST[$key])!== ""){
//            $cont++;
//            $camposcambiar["$key"]=$_POST[$key];
//        }
//        
//        
//        }
//        var_dump($camposcambiar);
//   
//        if (isset($camposcambiar["username"])){
//        comprueboExiste($camposcambiar);
//        }
//        
//        
//        
//
//function comprueboExiste($valoresCampos){
    //
$nombre = $datos['usuario'];
//$nombre='Lorena';
$id_sesion=$_SESSION['id'];
  //  $id_sesion=1;
$resultado="true";
    $campos = array("nombre");

        $res = existeUser2($nombre, $campos[0], $campos);
        if ($res){// SI EXISTE EL NOMBRE REALIZO UNA CONSULTA, PARA COMPROBAR QUE NO ES EL NOMBRE PROPIO
                   
            $campos = array("nombre", "id");
            $valores_campos = array(
               "nombre" => $nombre, );

            $id = loadUser($campos, $valores_campos, TABLA2); // CONSULTA QUE HACE SELECT id from tabla where nombre=$nombre;                
            if($id[0] !== $id_sesion){// SI EL ID SACADO DE LA CONSULTA NO COINCIDE CON EL DE LA SESION,
                   $resultado="false";                      // ES QUE NO ES EL SUYO PROPIO POR LO TANTO, NOMBRE ELEJIDO
                
        }

} // SI NO ES EL MISMO ID, PROCEDO A HACER EL UPDATE
echo $resultado;