<?php

function ejecutarUser($sql, $valores_campos, $tabla) {

    global $funcion;
    global $conexion;
    global $tipos;
    global $consulta;
    if ($conexion = conexion()) {
        $consulta = mysqli_stmt_init($conexion);
        mysqli_stmt_prepare($consulta, $sql);
//la función mysqli_stmt_bind_param() necesita referencias cuando se utiliza con call_user_func_array()
        if ($tipos) {

            $ejecucion = array(&$consulta, &$tipos);

            foreach ($valores_campos as $key => $valor) {
                $ejecucion[] = &$valores_campos[$key];
            }
            @call_user_func_array("mysqli_stmt_bind_param", $ejecucion);
        }

        return ejecutarConsultaUser($consulta, $tabla);

        cerrarConexion();
    }
}




function ejecutarConsultaUser($consulta, $tabla) {
    global $conexion;
    global $funcion;
    global $mensaje;
    global $colSelect;
    $campos = array();
    if ($funcion == 'insert')
        $operacion = 'insertar';
    elseif ($funcion == 'select')
        $operacion = 'seleccionar';
    elseif ($funcion == 'update')
        $operacion = 'modificar';
    if (!@mysqli_stmt_execute($consulta)) {

        $mensaje.= "<h2>Imposible $operacion los datos en $tabla. Error al $operacion los datos.</h2>";
        $numerror = mysqli_connect_errno();
        $descrerror = mysqli_connect_error();
        if ($numerror == 1062) {
            $mensaje.= "<b>No ha podido añadirse el registro. Ya existe el registro</b>";
        } else {
            $mensaje.= "<b>Se ha producido un error nº $numerror que corresponde a: $descrerror </b><br>";
        }
        return false;
    } else {

        if ($funcion == 'select') {
            $dato = array();
            $campos = array($consulta);




            $columnas = $colSelect;


            foreach ($columnas as $key => $valor) {
                $campos["$valor"] = &$columnas[$key];
            }

            call_user_func_array("mysqli_stmt_bind_result", $campos);
            while (mysqli_stmt_fetch($consulta)) {
                foreach ($colSelect as $key => $valor) {
                    $dato[] = $campos["$valor"];
                }
            }

            cerrarConsulta();
            return $dato;
        } elseif ($funcion == 'insert') {
            $mensaje = "<h3>Datos almacenados en tabla $tabla satisfactoriamente.</h3>\n";
            return true;
        }
    }
    cerrarConsulta();
}


function guardarUser($tabla, $valores_campos) {
    addTableUser($tabla);
    setFuncionUser("insert");
    foreach ($valores_campos as $campo => $valor) {
        addSelectUser($campo);
        addValueUser("?");
        addTipoUser($valor);
    }
    $sql_insertar = generarUser();


    ejecutarUser($sql_insertar, $valores_campos, $tabla);
}

function loadUser($campos, $valores_campos, $tabla) {
    addTableUser($tabla);
    setFuncionUser("select");

    foreach ($campos as $camp) {
        $campos = $camp;
        
    }

    foreach ($valores_campos as $campo => $valor) {
        addSelectUser($campos);
        addWhereUser("$campo = ?");
        addTipoUser($valor);
    }
    $sql_select = generarUser();

    return ejecutarUser($sql_select, $valores_campos, $tabla);
}

function existeUser($valor, $campo,$campos) {
    $duplicado = '';
    $valores_campos["$campo"] = $valor;
    $resultado = loadUser($campos,$valores_campos, TABLA2);
   
    if ($resultado)
        $duplicado = 1;
    return $duplicado;
}

function addTipoUser($campo) {
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

function addTableUser($table) {
    global $colFrom;
    $colFrom[] = $table;
}

function addWhereUser($where) {
    global $colWhere;
    $colWhere[] = $where;
}

function setFuncionUser($func) {
    global $funcion;
    $funcion = $func;
}

function addSelectUser($columna) {
    global $colSelect;
    $colSelect[] = $columna;
}

function addValueUser($valor) {
    global $colValue;
    $colValue[] = $valor;
}

function generarUser() {
    global $colFrom;
    global $colWhere;
    global $funcion;
    global $colSelect;
    global $colValue;
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
    }
    /* esta funcion podría generar la siguiente sentencia: $sql_insertar="INSERT INTO " .TABLA. "(nombre,sexo,edad,sistema,aficiones,futbol) VALUES(?,?,?,?,?,?)";
     */
    return $sql;
}
