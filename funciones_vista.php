<?php

//PARA GENERAR LOS TUPPERS DE ZONA DE USUARIO (MIS TUPPERS Y TUPPERS ADQUIRIDOS)/////////////////////////
function tupper($id, $usuario) {
    global $valores_campos, $campos;
    $valores_campos = array($id => $usuario);
    $campos = array('id_tupper', 'foto', 'nombre', 'descripcion', 'tipo', 'vegano', 'vegetariano', 'sin_gluten', 'id_solicitante', 'solicitado', 'id_usuario');
    $resultado = load('TUPPERWARING.TUPPER');
    $resultado = ordenar(array_reverse($resultado));
    $tuppers = array();
    foreach ($resultado as $key => $tupper) {
        if ($tupper[9] == 1) {
            $estado = '<span style="color: #019101;">Aceptado <span class="glyphicon glyphicon-ok"></span></span>';
        } else if ($tupper[8] != null) {
            $estado = '<span style="color: #DFB42C">Pedido <span class="glyphicon glyphicon-time"></span></span>';
        } else {
            $estado = 'Disponible';
        }
        if ($id == 'id_solicitante') {
            $valores_campos = array('id' => $tupper[10]);
            $campos = array('nombre', 'apellidos');
            $usuario = load('TUPPERWARING.USUARIOS');
            $de_usuario = "<span class='de_usuario'> <a href='javascript:void(0)' onclick='info(\"id_usuario\", " . $tupper[10] . ")'>de " . $usuario[0][0] . " " . $usuario[0][1] . "</a></span>";
        } else {
            if ($tupper[8] != null || $tupper[9] == 1) {
                $valores_campos = array('id' => $tupper[8]);
                $campos = array('nombre', 'apellidos');
                $usuario = load('TUPPERWARING.USUARIOS');
                $nombre_usuario = '<a href="javascript:void(0)" onclick="info(\'id_usuario\', ' . $tupper[8] . ')">' . $usuario[0][0] . ' ' . $usuario[0][1] . '</a>';
            }
            if ($tupper[9] == 1) {
                $estado = '<span style="color: #019101;">Aceptado para ' . $nombre_usuario . ' <span class="glyphicon glyphicon-ok"></span></span>';
            } else if ($tupper[8] != null) {
                $estado = '<span style="color: #DFB42C">Pedido por ' . $nombre_usuario . ' <span class="glyphicon glyphicon-time"></span></span>';
            }
            $de_usuario = "";
        }
        $tuppers[$key] = "";
        $tuppers[$key].='<div class="t">';
        $tuppers[$key].='<div class="contenido">';
        $tuppers[$key].='<div class="foto" style="background-image:url(\'img/foto_tuppers/' . $tupper[1] . '\')">';
        $tuppers[$key].='</div>';
        $tuppers[$key].="<h3>$tupper[2] $de_usuario<span class='estado'>&nbsp;&nbsp;|&nbsp;&nbsp;$estado</span></h3>";
        $tuppers[$key].='<div class="gestion">';
        if ($tupper[5] == 1 or $tupper[6] == 1 or $tupper[7] == 1) {

            if ($tupper[5] == 1) {
                $tuppers[$key].='<div class="vegano"><span class="glyphicon glyphicon-leaf"></span> vegano</div>';
            }
            if ($tupper[6] == 1) {
                $tuppers[$key].=' <div class="vegetariano"><span class="glyphicon glyphicon-leaf"></span> vegetariano</div>';
            }
            if ($tupper[7] == 1) {
                $tuppers[$key].=' <div class="sin_gluten"><span class="glyphicon glyphicon-glyphicon glyphicon-grain"></span>sin gluten</div>';
            }
        }

        $tuppers[$key].='</div>';
        $tuppers[$key].='<input type="hidden" value="'.$tupper[4].'" id="tipo">';
        $tuppers[$key].='<input type="hidden" value="'.$tupper[0].'" id="id_tupper">';
        $tuppers[$key].='<div class="descripcion">';
        $tuppers[$key].="<div>$tupper[3]</div>";
        $tuppers[$key].='</div>';
        $tuppers[$key].='<div class="ver"> <span>ver mas</span>';
        $tuppers[$key].='</div>';
        $tuppers[$key].='</div>';

        $tuppers[$key].='<div class="botones">';
        if ($id == 'id_usuario') {
            $tuppers[$key].='<input type="button" class="notifi naranja" value="eliminar" onclick="gestion(this,' . $tupper[0] . ',0)">';
            $tuppers[$key].='<input type="button" class="notifi ed_tupper" value="editar">';
        } else if ($tupper[9] != 1) {
            $tuppers[$key].='<input type="button" class="notifi" value="cancelar peticion" onclick="gestion(this,' . $tupper[0] . ',0)"><br>';
        }
        $tuppers[$key].='</div>';
        $tuppers[$key].='</div>';
    }
    return $tuppers;
}

//PARA GENERAR LAS NOTIFICACIONES DEL USUARIO//////////////////////////////////////////////////
function notificaciones($usuario) {
    global $valores_campos, $campos;
    $valores_campos = array('id_r' => $usuario);
    $campos = array('mensaje', 'hora', 'id_tupper', 'id_mensaje', 'id_e', 'fecha');
    $notificaciones_array=array();
    $notificaciones_array = load('TUPPERWARING.MENSAJES');
    $notificaciones_array=array_reverse($notificaciones_array);
    $notificaciones = array();

    foreach ($notificaciones_array as $key => $n_a) {
        $fecha = formateo_fecha($n_a[5]);
        $notificaciones[$key] = "<div class='notificacion'>$n_a[0] <br><span class='n_fecha'>$fecha a las $n_a[1]</span>";
        if ($n_a[2] != null) {
            $notificaciones[$key].="<input type='button' value='aceptar' class='notifi' onclick='gestion(this,$n_a[2], $n_a[3])'>";
            $notificaciones[$key].="<input type='button' value='cancelar' class='notifi naranja' onclick='gestion(this,$n_a[2],$n_a[3])'></div>";
        } else {
            $notificaciones[$key].="<input type='button' value='ok' class='notifi' onclick='gestion(this,0, $n_a[3])'></div>";
        }
    }
    return $notificaciones;
}

//PARA GENERAR LAS SECCIONES DE NOTIFICACIONES, MIS TUPPERS Y TUPPERS ADQUIRIDOS/////////////////////////
function zona_usuario() {
    global $valores_campos, $campos, $usuario;
    //generar trozo de datos de usuario
    $valores_campos = array('id' => $usuario);
    $campos = array('nombre', 'apellidos', 'email', 'foto', 'poblacion', 'edad');
    $datos_usuario = load('TUPPERWARING.USUARIOS');

//generar notificaciones y contador

    $notificaciones_array = notificaciones($usuario);
    
    $notificaciones = "";
    $c_n = 0;
    foreach ($notificaciones_array as $n) {
        $c_n++;
        $notificaciones.=$n;
    }
    if ($c_n == 0) {
        $notificaciones = "<p>¡No tienes Notificaciones! de momento...</p>";
    }
//generar mis tuppers y contador
    $mis_tuppers_array = tupper('id_usuario', $usuario);
    
    $mis_tuppers = "";
    $c_mt = 0;
    foreach ($mis_tuppers_array as $mt_a) {
        $mis_tuppers.=$mt_a;
        $c_mt++;
    }
    if ($c_mt == 0) {
        $mis_tuppers = "<p>¡No tienes Tuppers! de momento...</p>";
    }
//generar tuppers adquiridos y contador
    $tuppers_adquiridos_array = tupper('id_solicitante', $usuario);
    
    $tuppers_adquiridos = "";
    $c_ta = 0;
    foreach ($tuppers_adquiridos_array as $ta_a) {
        $tuppers_adquiridos.=$ta_a;
        $c_ta++;
    }
    if ($c_ta == 0) {
        $tuppers_adquiridos = "<p>¡No has pedido Tuppers! de momento...</p>";
    }

//relleno de la plantilla
    $contenido = "plantillas/zona_usuario.html";
    $datos = array(
        "nombre" => $datos_usuario[0][0],
        "apellidos" => $datos_usuario[0][1],
        "email" => $datos_usuario[0][2],
        "foto" => $datos_usuario[0][3],
        "poblacion" => $datos_usuario[0][4],
        "edad" => $datos_usuario[0][5],
        "notificaciones" => $notificaciones,
        "mis_tuppers" => $mis_tuppers,
        "tuppers_adquiridos" => $tuppers_adquiridos,
        "c_n" => $c_n,
        "c_mt" => $c_mt,
        "c_ta" => $c_ta,
    );
    $html = respuesta($datos, $contenido);
    return $html;
}

//PARA GENERAR LOS TUPPERS EN LA SECCION DE COGER TUPPERS/////////////////////////
function generar_tupper() {
    global $campos, $valores_campos;
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

    $campos = array('id_tupper', 'nombre', 'foto', 'descripcion', 'tipo', 'vegano', 'vegetariano', 'sin_gluten', 'id_solicitante', 'id_usuario', 'solicitado');
    $sql = load('TUPPERWARING.TUPPER');
    $sql = array_reverse($sql);
    $t = "<div class='titulo'><h1>$plato</h1></div>";
    $t.="<div class='selects'>  <span class='vegano'><span class='glyphicon glyphicon-leaf'></span> Vegano</span> <input type='checkbox' id='checkbox-8-2' name='vegano'/><label for='checkbox-8-2'></label> <span class='vegetariano'><span class='glyphicon glyphicon-leaf'></span> Vegetariano</span> <input type='checkbox' id='checkbox-8-3' name='vegetariano'/><label for='checkbox-8-3'></label> <span class='sin_gluten'><span class='glyphicon glyphicon-glyphicon glyphicon-grain'></span> Sin Gluten</span> <input type='checkbox' id='checkbox-8-4' name='vegano'/><label for='checkbox-8-4'></label></div>";
    $t.="<div class='resultado'>";
    foreach ($sql as $tuppers) {
        if ($tuppers[10] == null) {
            $order = array();
            $valores_campos = array('id' => $tuppers[9]);
            $campos = array('nombre', 'apellidos');
            $usuario = load('TUPPERWARING.USUARIOS');
            $vegano = ($tuppers[5] == 1) ? ' vegano ' : '';
            $vegetariano = ($tuppers[6] == 1) ? ' vegetariano ' : '';
            $sin_gluten = ($tuppers[7] == 1) ? ' sin_gluten ' : '';
            $vegano2 = ($tuppers[5] == 1) ? '<p class="vegano"><span class="glyphicon glyphicon-leaf"></span> Vegano</p>' : '';
            $vegetariano2 = ($tuppers[6] == 1) ? '<p class="vegetariano"><span class="glyphicon glyphicon-leaf"></span> Vegetariano</p>' : '';
            $sin_gluten2 = ($tuppers[7] == 1) ? '<p class="sin_gluten"><span class="glyphicon glyphicon-glyphicon glyphicon-grain"></span> Sin Gluten</p>' : '';
            $pedido = ($tuppers[8] == null) ? "" : " disabled='disabled' ";
            $pedido_value = ($tuppers[8] == null) ? "Pedir Tupper" : "Pedido";
            $t.= '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">';
            $t.= '<div class="tupper';
            $t.= "$vegano$vegetariano$sin_gluten";
            $t.= '">';
            $t.='<div class="foto">';
            $t.="<img src='img/foto_tuppers/";
            $t.=$tuppers[2];
            $t.="'>";
            $t.='</div><div class="contenido">';
            $t.="<h2>$tuppers[1]</h2><span class='usuario'>de " . $usuario[0][0] . " " . $usuario[0][1] . "</span>";
            $t.='<div class="puntuacion"></div>';
            $t.='<div class="descripcion">';
            $t.=$tuppers[3];
            $t.='</div>';
            $t.='</div>';
            $t.=$vegano2 . " " . $vegetariano2 . " " . $sin_gluten2;
            $t.= '<input type="button" class="pedir" value="' . $pedido_value . '"' . $pedido . 'onclick="peticion(this)">';
            $t.="<input type='hidden' id='$tuppers[9]' value='$tuppers[0]' class='datos_tupper'>";
            $t.='</div>';
            $t.='</div>';
        }
    }
    $t.='</div>';
    $contenido = $t;
    return $contenido;
}

function formateo_fecha($f) {
    $dia = (int) substr($f, 8);
    $mes = (int) substr($f, 5, 7);
    $anyo = (int) substr($f, 0, 4);
    $meses = array('', 'enero', 'feberero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    if ($f == date("Y-m-d")) {
        $fecha = 'Hoy';
    } else if (($dia) == ((int) date("d") - 1)) {
        $fecha = 'Ayer';
    } else if ($anyo == (int) date("Y")) {
        $fecha = "el $dia de $meses[$mes]";
    } else {
        $fecha = "el $dia de " . $meses[$mes] . " del $anyo";
    }
    return $fecha;
}

function ordenar($array) {
    $orden = array(1, 2, 3);
    $cont = 0;
    $ordenado = array();
    foreach ($orden as $key => $o) {
        foreach ($array as $linea_datos) {
            $condiciones = array($linea_datos[9] == 1, ($linea_datos[8] != null && $linea_datos[9] == 0), ($linea_datos[8] == null && $linea_datos[9] == 0));
            if ($condiciones[$key]) {
                $ordenado[$cont] = $linea_datos;
                $cont++;
            }
        }
    }
    return $ordenado;
}

function respuesta($resultados, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($resultados as $key1 => $valor1)
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $html = str_replace($cadena, $valor2, $html);
            }
        } else {
            $cadena = '{' . $key1 . '}';
            $html = str_replace($cadena, $valor1, $html);
        }
    return $html;
}

function respuesta2($resultados, $plantilla) {
    $html = $plantilla;
    foreach ($resultados as $key1 => $valor1)
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $html = str_replace($cadena, $valor2, $html);
            }
        } else {
            $cadena = '{' . $key1 . '}';
            $html = str_replace($cadena, $valor1, $html);
        }
    return $html;
}

function validateField($nombreCampo, $campospendientes, $camposerroneos) {
    if (in_array($nombreCampo, $campospendientes)) {
        return ' class="error1"';
    } elseif (in_array($nombreCampo, $camposerroneos)) {
        return ' class="error2"';
    }
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}
