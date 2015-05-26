<?php

function procesForm() {
    $campospendientes = array();
    $camposerroneos = array();
    global $campos;
    global $valores_campos;
    if (isset($_POST['codigo']) and ! preg_match("/^[RL][0-9]{5}$/", $_POST['codigo'])) {
        $camposerroneos[] = 'codigo';
    }
    if (isset($_POST['codigo']) and empty($_POST['codigo'])) {
        $campospendientes[] = 'codigo';
    }
    if ($campospendientes or $camposerroneos) {
        displayForm($camposerroneos, $campospendientes);
    } else {
        $campo = 'codigo';
        $valor = $_POST["codigo"];
        $valores_campos[$campo] = $valor;
        if (isset($_POST['precio'])) {
            $campos[] = 'precio';
        }
        if (isset($_POST['cantidad'])) {
            $campos[] = 'cantidad';
        }
        $producto = obtenerProducto(TABLA); //contadorvista.php
        if ($producto)
            visualizarDatos($producto); //contadorvista.php
    }
}

