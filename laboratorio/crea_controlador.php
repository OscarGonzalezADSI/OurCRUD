<?php


function crea_controlador($base, $tabla){
    
$conn = conexion_controlador();
$sql="Select COLUMN_NAME, COLUMN_KEY
               FROM information_schema.columns
               WHERE TABLE_SCHEMA='$base'
               AND TABLE_NAME='$tabla'";
$consulta = mysqli_query($conn, $sql);
$x = 1;
while($fila = mysqli_fetch_assoc($consulta)){
    if($fila['COLUMN_KEY']=="PRI"){
        $llave = $fila['COLUMN_NAME'];
    }
    $datos[$x] = $fila['COLUMN_NAME'];
    $x++;
}
crear_controlador($tabla, $datos, $llave);    

}


function conexion_controlador(){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}

function crear_controlador($tabla, $datos, $llave){
$parametro_agregardatos = parametro_agregardatos($datos);
$cadena = cadena($datos);
$agrega = agrega($datos);
$toma = toma($datos);
$controlador = controlador($tabla, $parametro_agregardatos, $cadena, $agrega, $toma, $llave);
crear_archivo("funciones_$tabla", $controlador);
}





function parametro_agregardatos($datos){
    $x = 1;
    $parametro_agregardatos = "";
    while ($x < count($datos)) {
        $parametro_agregardatos = $parametro_agregardatos . "" . $datos[$x] . ", ";
        $x++;
    }
    $parametro_agregardatos = $parametro_agregardatos . "" . $datos[$x];
    return $parametro_agregardatos;
}


function cadena($datos){
    $x = 1;
    $cadena = " \"" . $datos[$x] . "=\" + " . $datos[$x] . " +\n";
    $x++;
    while ($x < count($datos)) {
        $cadena = $cadena . "    \"&" . $datos[$x] . "=\" + " . $datos[$x] . " +\n";
        $x++;
    }
    $cadena = $cadena . "    \"&" . $datos[$x] . "=\" + " . $datos[$x] . ";\n\n";
    return $cadena;
}


function agrega($datos){
    $x = 1;
    $n = 0;
    $agrega = "";
    while ($x <= count($datos)) {
        $agrega = $agrega . "    $('#" . $datos[$x] . "u').val(d[$n]);\n";
        $x++;
        $n++;
    }
    return $agrega;
}


function toma($datos){
    $x = 1;
    $n = 0;
    $toma = "";
    while ($x <= count($datos)) {
        $toma = $toma . "    $datos[$x] = $('#" . $datos[$x] . "u').val();\n";
        $x++;
        $n++;
    }
    return $toma;
}


function agregardatos($parametro_agregardatos, $cadena){
    $contenido = "function agregardatos($parametro_agregardatos){\n"
            . "    cadena =".$cadena
            . "    accion = \"insertar\";\n"
            . "    mensaje_si = \"Cliente agregado con exito\";\n"
            . "    mensaje_no= \"Error de registro\";\n"
            . "    a_ajax(cadena, accion, mensaje_si, mensaje_no);\n"
            . "}\n";
    return $contenido;
}

function agregaform($agrega){
    $contenido = "function agregaform(datos) {\n"
            . "    d = datos.split('||');\n"
            . $agrega
            . "}\n\n";
    return $contenido;
}

function modificar($cadena, $toma){
    $contenido = "function modificarCliente(){\n"
            . $toma
            . "    cadena =".$cadena
            . "    accion = \"modificar\";\n"
            . "    mensaje_si = \"Cliente modificado con exito\";\n"
            . "    mensaje_no= \"Error de registro\";\n"
            . "    a_ajax(cadena, accion, mensaje_si, mensaje_no);\n"
            . "}\n\n";
    return $contenido;
}

function preguntarSiNo($llave){
    $contenido = "function preguntarSiNo(".$llave.") {\n"
            . "    var opcion = confirm(\"¿Esta seguro de eliminar el registro?\");\n"
            . "    if (opcion == true) {\n"
            . "        alert(\"El registro será eliminado.\");\n"
            . "        eliminarDatos(".$llave.");\n"
            . "    } else {\n"
            . "        alert(\"El proceso de eliminación del registro ha sido cancelado.\");\n"
            . "    }\n"
            . "}\n\n";
    return $contenido;
}

function eliminarDatos($llave){
    $contenido = "function eliminarDatos(".$llave.") {\n"
            . "    cadena = \"".$llave."=\" + ".$llave.";\n\n"
            . "    accion = \"borrar\";\n"
            . "    mensaje_si = \"Cliente borrado con exito\";\n"
            . "    mensaje_no= \"Error de registro\";\n"
            . "    a_ajax(cadena, accion, mensaje_si, mensaje_no);\n"
            . "}\n\n";
    return $contenido;
}

function a_ajax($tabla){
    $contenido = "function a_ajax(cadena, accion, mensaje_si, mensaje_no){\n"
            . "    \$.ajax({\n"
            . "        type: \"POST\",\n"
            . "        url: \"../modelo/".$tabla."_modelo.php?accion=\"+accion,\n"
            . "        data: cadena,\n"
            . "        success: function (r){\n"
            . "            if (r == 1) {\n"
            . "            \$('#tabla').load('../vista/componentes/vista_$tabla.php');\n"
            . "                alert(mensaje_si);\n"
            . "            } else {\n"
            . "                alert(mensaje_no);\n"
            . "            }\n"
            . "        }\n"
            . "    });\n"
            . "}\n";
    return $contenido;
}

function controlador($tabla, $parametro_agregardatos, $cadena, $agrega, $toma, $llave){
    $agregardatos = agregardatos($parametro_agregardatos, $cadena);
    $agregaform = agregaform($agrega);
    $modificar = modificar($cadena, $toma);
    $preguntarSiNo = preguntarSiNo($llave);
    $eliminarDatos = eliminarDatos($llave);
    $a_ajax = a_ajax($tabla);
    return $controlador = $agregardatos.$agregaform.$modificar.$preguntarSiNo.$eliminarDatos.$a_ajax;
}

function crear_archivo($tabla, $contenido){
    $archivo = fopen("proyecto/controlador/$tabla.js", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
    // https://www.php.net/manual/es/function.rename.php
}
?>
