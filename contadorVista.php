<?php

function visualizarDatos($producto) {
    $filas = "";
    foreach ($producto as $p) {
        $filas .= '<tr>';
        foreach ($p as $key => $valor) {
            $filas.="<td>$valor</td>";
        }
        $filas.='</tr>';
    }
    $datos = array(
        "fila" => $filas,
    );
    $plantilla = "plantillas/salida.html";
    $html = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "contenido" => $html
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function obtenerProducto($tabla) {
    global $mensaje, $enlace;
    $enlace = "<a href='index.php'>Volver al formulario de búsqueda de datos</a>";
    $resultado = load($tabla); //contador.php
    if (!$resultado) {
        $mensaje = "no se ha encontrado resultado";
        visualizarError(); //contadorvista.php
    } else {
        return $resultado;
    }
}

function visualizarError() {
    global $mensaje;
    global $mensajeAbrirConexion;
    global $mensajeCerrarConexion;
    $datos = array(
        "mensaje" => $mensaje,
        "mensajeAbrirConexion" => $mensajeAbrirConexion,
        "mensajeCerrarConexion" => $mensajeCerrarConexion,
    );
    $plantilla = "plantillas/error.html";
    $salida = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "contenido" => $salida
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayForm($camposPendientes, $camposErroneos) {
    $datos = array(
        "valorCodigo" => setValue('codigo'),
        "error" => validateField('codigo', $camposErroneos, $camposPendientes),
    );
    $plantilla = "plantillas/formulario.html";
    $salida = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "contenido" => $salida
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
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
