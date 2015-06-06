<?php

require_once("funciones_vista.php");
//CODIGO DEL LADO SERVIDOR
//GLOBALES
$funcion = "";
$colWhere = array();
$colSelect = array();
$colFrom = array();
$ejecutar = array();
$colValue = array();
$tipos = "";
$conexion = "";
$mensajeInsertar = "";
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$enlace = "";
$duplicado = false;
$logeo = false;
$contrasena = false;

if (!isset($_SESSION["username"])) {
    if (isset($_POST["login-submit"])) {
        $res = verificar_login($_POST["usernamelog"], $_POST["passwordlog"]);

        if ($res) {   //(CONDICION PARA QUE NO DE ERROR el $res[0], SI $RES NO ESTA VACIO entonces:
            if ($res[0] === $_POST["passwordlog"]) { // SI COINCIDE CON LA PASSWORD
                CrearSesion(); // LOGEO (Creacion de sesion etc)                 
            } else {
                $contrasena = true;
                
                // displayFormulario(array(),array(),$duplicado,$logeo,$contrasena);
                // SI NO COINCIDE, CONTRASEÃ‘A NO VALIDA  
            }
        } else { // SI $RES ES VACIO.
            $logeo = true;
            /// displayFormulario(array(),array(),$duplicado,$logeo,$contrasena);
        }
    }
}

function veriForm() {
    $camposObligatorios = array("username", "dni", "telefono", "email", "password");
    $campospendientes = array();
    $camposerroneos = array();
    $duplicado = false;
    $logeo = false;
    $contrasena = false;
// VALIDACIONES DE LOS CAMPOSSS
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || !$_POST[$campoObligatorio]) {
            $campospendientes[] = $campoObligatorio;
        }
    }

    if (isset($_POST["username"]) && !preg_match("/^[0-9A-Za-z][0-9A-Za-z ]*$/", $_POST["username"])) {
        $camposerroneos[] = "username";
    }

    if ((isset($_POST["dni"]) && !preg_match("/^\d{8}[a-zA-Z]{1}$/", $_POST["dni"]))) {
        $camposerroneos[] = "dni";
    }
    if (isset($_POST["email"]) and $_POST["email"]) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
            $camposerroneos[] = "email";
        }
    }
    if (isset($_POST["telefono"]) and $_POST["telefono"]) {
        $_POST["telefono"] = filter_var($_POST["telefono"], FILTER_SANITIZE_NUMBER_INT);
    }

    $dni = $_POST["dni"];
    $nombre = $_POST["username"];

    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $password = $_POST["password"];


    if ($campospendientes || $camposerroneos || $duplicado == true || $logeo == true || $contrasena == true) {
       // displayFormulario($campospendientes, $camposerroneos,$duplicado,$logeo,$contrasena);// SI HAY CAMPOS PENDIENTES O ERRONEOS
    } else {

        // SINO COMPRUEBO SI YA EXISTE
        $campos = array("nombre");

        $res = existeUser($nombre, $campos[0], $campos);

        if ($res > 0) {
            $duplicado = true;  // SI EXISTE , MUESTRO EL FORMULARIO DICIENDO QUE EL USUARIO YA ESTA COGIDO
            displayFormulario($campospendientes, $camposerroneos, $duplicado, $logeo, $contrasena);
        } else { // SINO EXISTE INTRODUZCO EL USUARIO EN LA BASE DE DATOS
            cerrarConsulta();
            cerrarConexion();

            $valores_campos = array(
                "nombre" => $nombre,
                "email" => $email,
                "password" => $password,
            );

            guardarUser(TABLA2, $valores_campos); //GUARDO EN LA TABLA USUARIOS


            return gracias();
        }

//    }
    }
}

function displayFormulario($campospendientes, $camposerroneos, $duplicado, $logeo, $contrasena) {
    $error_pendiente = "";
    $error_fallo = "";
    $error_log = "";
    $error_contrasena = "";
    $activo_login='';
    $activo_register='';
    if ($campospendientes) {
        $error_pendiente = '<p class="error2">Hubo algunos problemas con el formulario que usted <br>
                            presentÃ³. Por favor, rellene los campos con (*), ya que son obligatorios</p>';
    }
    if ($camposerroneos) {
        $error_fallo = '<p class="error1">Los campos marcados no han sido rellenados correctamente, por favor rellenelos.</p>';
    }
    if ($duplicado == true) {
        $error_fallo = '<p class="show">El nombre de usuario ya esta cogido.</p>';
    }
    if ($logeo) {
        $error_log = '<p class="show">El usuario no existe.</p>';
    }
    if ($contrasena) {
        
        $error_contrasena = '<p class="show"> La contrasena es incorrecta </p>';
    }
    if($contrasena || $logeo){
//        $activo_login='class="active"';
//        $activo_register='';
    }
    else if($campospendientes || $camposerroneos || $duplicado == true){
//        $activo_login='';
//        $activo_register='class="active"';
    }


    $datos = array(
        "error_pendiente" => $error_pendiente,
        "error_fallo" => $error_fallo,
        "error_log" => $error_log,
        "error_contrasena" => $error_contrasena,
        "validarNombre" => validateField("username", $campospendientes, $camposerroneos),
        "validarEmail" => validateField("email", $campospendientes, $camposerroneos),
        "validarTelefono" => validateField("telefono", $campospendientes, $camposerroneos),
        "validarDni" => validateField("dni", $campospendientes, $camposerroneos),
        "activo_login"=>$activo_login,
        "activo_register"=>$activo_register
        
    );

    $plantilla = "plantillas/usuarios.html";
    $html = respuesta($datos, $plantilla);
    return $html;
}

function gracias() {//FUNCION PARA ABRIR EL HTML GRACIAS
    $nombre = $_POST["username"];

    $datos = array(
        "nombre" => $nombre);
    $plantilla = "plantillas/Gracias.html";
    $html = respuesta($datos, $plantilla);
    return $html;
}

// OPCION EN FUNCIONAMIENTO PARA LOGUEARSE (FORMA DE PACO) //
function verificar_login($user, $password) {
    $campos = array("nombre", "password");
    $valores_campos = array(
        "nombre" => $user,
    );
    $logeo = false;
    $contrasena = false;
    $duplicado = false;
    // CONTROLADOR LOGIN.
    $res = loadUser($campos, $valores_campos, TABLA2); // CONSULTA QUE HACE SELECT password from tabla where nombre=$user;

    return $res;

    //var_dump(loadUserUser($campos,$valores_campos,TABLA2));    
}

// SEGUNDA OPCION DE FUNCION PARA LOGEARSE //
function logeo() {
    $cadena = "SELECT * from tupperwaring where nombre='$user' AND password='$password'";
    $res = mysql_query($cadena);
    $count = 0;
    while ($row = mysql_fetch_object($rec)) {
        $count++;
        $result = $row;
    }
    if ($count == 1) {
        return 1;
    } else
        return 0;
}

// CREACCION DE SESION CUANDO EL USUARIO ESTA LOGUEADO.
function CrearSesion() {

    session_start();
    $_SESSION["username"] = $_POST["usernamelog"];

    $campos = array("nombre", "id");
    $valores_campos = array(
        "nombre" => $_SESSION["username"],
    );
    $logeo = false;
    $contrasena = false;
    $duplicado = false;
    // CONTROLADOR LOGIN.
    $id = loadUser($campos, $valores_campos, TABLA2); // CONSULTA QUE HACE SELECT password from tabla where nombre=$user;
    $_SESSION["id"] = $id[0];
    header('Location: index.php?hazteTupper');
}
