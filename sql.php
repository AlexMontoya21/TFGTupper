<?php

function addTable($table) {
    global $colFrom;
    $colFrom[] = $table;
}

function addWhere($where) {
    global $colWhere;
    $colWhere[] = $where;
}

function setFuncion($func) {
    global $funcion;
    $funcion = $func;
}

function addSelect($columna) {
    global $colSelect;
    $colSelect[] = $columna;
}

function addValue($valor) {
    global $colValue;
    $colValue[] = $valor;
}

function generar() {
    global $colFrom;
    global $colWhere;
    global $funcion;
    global $colSelect;
    global $colValue;
    global $order;
    $select = implode(',', array_unique($colSelect));
    $from = implode(',', array_unique($colFrom));
    $where = implode(' AND ', array_unique($colWhere));
    $values = implode(',', $colValue);
    $funcion = $funcion;
    $sql = $funcion . ' ';
    if ($funcion == 'insert') {
        $sql.='INTO ' . $from . '(' . $select . ') values (' . $values . ')';
    } elseif ($funcion == 'update') {
        $sql.= $from . ' SET ' . $select;
        if (!empty($colWhere)) {
            $sql.=' WHERE ' . $where;
        }
    } else {
        $sql = $funcion . ' ' . $select . ' FROM ' . $from;
        if (!empty($colWhere)) {
            $sql.=' WHERE ' . $where;
        }
        if (!empty($order)) {
            $sql.=' ORDER BY ' . $order[0]." ".$order[1];
        }
    }
    return $sql;
}

function load($tabla) {
    global $campos, $valores_campos;
    addTable($tabla);
    setFuncion("select");

    foreach ($campos as $c) {
        addSelect("$c");
    }
    foreach ($valores_campos as $campo => $valor) {
        addWhere("$campo = ?");
        addTipo($valor);
    }
    $sql_select = generar();
    return ejecutar($sql_select, $tabla);
}

function modificar($tabla) {
    global $valores_campos, $campos;
    addTable($tabla);
    setFuncion("update");
    foreach ($valores_campos as $campo => $valor) {
        addSelect("$campo=?");
        addValue("?");
    }
    foreach ($campos as $c => $v) {
        addWhere("$c=$v");
        addTipo($v);
    }
    $sql_update = generar();
    return ejecutar($sql_update, $tabla);
}

function guardar($valores_campos, $tabla) {
    global $resultado;
    addTable($tabla);
    setFuncion("insert");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addValue("?");
        addTipo($valor);
    }
    $sql_insertar = generar();
    $resultado = ejecutar($sql_insertar, $valores_campos, $tabla);
    if (!$resultado) {
        header("Location: problema.html");
    }
}

function addTipo($campo) {
    global $tipos;
    switch (gettype($campo)) {
        case "integer":
            $tipos.="i";
            break;
        case "double":
            $tipos.="d";
            break;
        case "string":
            $tipos.="s";
            break;
    }
}

function ejecutar($sql, $tabla) {
    global $funcion;
    global $conexion;
    global $tipos;
    global $valores_campos;
    global $cerrarConsulta;
    global $consulta;
    if ($conexion = conexion()) {
        $consulta = mysqli_stmt_init($conexion);
        mysqli_stmt_prepare($consulta, $sql);
        if ($tipos) {
            $ejecucion = array(&$consulta, &$tipos);
            foreach ($valores_campos as $key => $valor) {
                $ejecucion[] = &$valores_campos[$key];
            }
            @call_user_func_array("mysqli_stmt_bind_param", $ejecucion);
        }
        return ejecutarConsulta($tabla);
        cerrarConexion();
    }
}

function conexion() {
    $conexion = @mysqli_connect(SERVIDOR, USUARIO, PASSWORD);
    return $conexion;
}

function cerrarConexion() {
    global $conexion;
    $operacion = true;
    if (!@mysqli_close($conexion)) {
        return false;
    } else {
        return true;
    }
}

function ejecutarConsulta($tabla) {
    global $consulta;
    global $funcion;
    global $colSelect;
    global $colWhere;
    global $valores_campos;
    @mysqli_stmt_execute($consulta);
    if ($funcion == 'select') {
        $producto = array();
        $cont = 0;
        $campos = array($consulta);
        $columnas = $colSelect;
        foreach ($columnas as $key => $valor) {
            $campos["$valor"] = &$columnas[$key];
        }
        call_user_func_array("mysqli_stmt_bind_result", $campos);
        while (mysqli_stmt_fetch($consulta)) {
            foreach ($colSelect as $key => $valor) {
                $producto[$cont][] = $campos["$valor"];
            }
            $cont++;
        }
        cerrarConsulta();
        return $producto;
    } elseif ($funcion == 'update' or $funcion == 'insert') {
        cerrarConsulta();
        return true;
    }
    cerrarConsulta();
    return false;
}

function cerrarConsulta() {
    global $colWhere, $colSelect, $colFrom, $ejecutar, $colValue, $tipos, $consulta, $valores_campos;
    $colWhere = array();
    $colSelect = array();
    $colFrom = array();
    $ejecutar = array();
    $colValue = array();
    $tipos = "";
    $valores_campos = array();
    @mysqli_stmt_close($consulta);
}

function existe($valor, $campo, $tabla) {
    global $valores_campos;
    $valores_campos["$campo"] = $valor;
    $resultado = load($tabla);
    if ($resultado) {
        $duplicado = false;
    } else {
        $duplicado = true;
    }
    return $duplicado;
}
