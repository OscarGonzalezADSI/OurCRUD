<?php

function crea_modelo($base, $tabla) {
$conn = connection();
crud($conn, $base, $tabla);
}

function connection() {
    $host = "localhost";
    $user = "root";
    $password = "";
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}

function connection_base($base) {
    $conexion = "<?php\n"
            . "function conexion(){\n"
            . "    \$host = 'localhost';\n"
            . "    \$user = 'root';\n"
            . "    \$password = '';\n"
            . "    \$database = '$base';\n"
            . "    \$conn = mysqli_connect(\$host, \$user, \$password, \$database);\n"
            . "    return \$conn;\n"
            . "}\n"
            . "?>\n";
    echo $conexion;
    return $conexion;
}

function consulta_columna($conn, $basedatos, $tabla) {

    $sql = "Select COLUMN_NAME, COLUMN_KEY
               FROM information_schema.columns
               WHERE TABLE_SCHEMA='$basedatos'
               AND TABLE_NAME='$tabla'";

    $result = mysqli_query($conn, $sql);
    return $result;
}

function nombre_campo($conn, $basedatos, $tabla) {
    $entrada = consulta_columna($conn, $basedatos, $tabla);
    $x = 0;
    while ($fila = mysqli_fetch_assoc($entrada)) {
        if ($fila['COLUMN_KEY'] == "PRI") {
            $llave = $fila['COLUMN_NAME'];
        } else {
            
        }
        $campo[$x] = $fila['COLUMN_NAME'];
        $x++;
    }
    return $salida = Array(1 => $x, 2 => $campo, 3 => $llave);
}

function campo($conn, $basedatos, $tabla) {
    $entrada = nombre_campo($conn, $basedatos, $tabla);

    $x = 0;
    $info = "          ";
    while ($x < $entrada[1]) {
        $info = $info . $entrada[2][$x];
        $x++;
        if ($x != $entrada[1]) {
            $info = $info . ", ";
            $x--;
        } else {
            
        }
        $x++;
    }
    return $info;
}

function tomado($conn, $basedatos, $tabla) {
    $entrada = nombre_campo($conn, $basedatos, $tabla);
    
    $nro_registros = $entrada[1];
    $campo = $entrada[2];
    $campo_llave = $entrada[3];
    
    $x = 0;
    $info = "          ";
    
    while ($x < $nro_registros) {
        if ($campo[$x] != $campo_llave) {
            $info = $info . $campo[$x] . " = '$" . $campo[$x] . "'";
            $x++;
            if ($x < $nro_registros) {
                $info = $info . ", \n          ";
                $x--;
            } else {
            }            
        } else {         
        }
        $x++;
    }
    return $salida = Array(1 => $info, 2 => $campo_llave);
}

function post_dato_llave($conn, $basedatos, $tabla) {
    $entrada = nombre_campo($conn, $basedatos, $tabla);

    $x = 0;
    $info = "";
    while ($x < $entrada[1]) {
        if ($entrada[2][$x] == $entrada[3]) {
            $info = $info . '    $' . $entrada[2][$x] . " = \$_POST['" . $entrada[2][$x] . "']";
        } else {
            
        }
        $x++;
    }
    return $salida = $info . ";\n\n";
}

function post_dato($conn, $basedatos, $tabla) {
    $entrada = nombre_campo($conn, $basedatos, $tabla);

    $x = 0;
    $info = "";
    while ($x < $entrada[1]) {
        $info = $info . '    $' . $entrada[2][$x] . " = \$_POST['" . $entrada[2][$x] . "']";
        if ($x != $entrada[1]) {
            $info = $info . ";\n";
        } else {
            
        }
        $x++;
    }
    return $salida = $info . "\n";
}

function dato($conn, $basedatos, $tabla) {
    $entrada = nombre_campo($conn, $basedatos, $tabla);

    $x = 0;
    $info = " '$";
    while ($x < $entrada[1]) {
        $info = $info . $entrada[2][$x];
        $x++;
        if ($x != $entrada[1]) {
            $info = $info . "', '$";
            $x--;
        } else {
            $info = $info . "'";
        }
        $x++;
    }
    return $info;
}

function archivo($tabla, $contenido) {
    $archivo = fopen("$tabla.php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
}

function consulta($accion, $sql) {
    $contenido = "if(\$accion == \"$accion\"){\n\n"
            . "$sql\n"
            . "    echo \$consulta = mysqli_query(\$conn, \$sql);\n}\n\n";
    return $contenido;
}

function insert($conn, $basedatos, $tabla) {
    $campo = campo($conn, $basedatos, $tabla);
    $dato = dato($conn, $basedatos, $tabla);

    $post_dato = post_dato($conn, $basedatos, $tabla);
    $insert = $post_dato . "    \$sql=\"INSERT INTO $tabla(\n"
            . "$campo\n"
            . "          )VALUE(\n         $dato)\";\n";
    $sql = $insert;
    $contenido = consulta("insertar", $sql);
    return $contenido;
}

function update($conn, $basedatos, $tabla) {
    $post_dato = post_dato($conn, $basedatos, $tabla);
    $insert = $post_dato . "    \$sql=\"UPDATE $tabla SET\n";
    $tomado = tomado($conn, $basedatos, $tabla);

    $consulta = $tomado[1] . "\n          WHERE " . $tomado[2] . " = '$" . $tomado[2] . "'\";\n";
    $sql = $insert . $consulta;
    $contenido = consulta("modificar", $sql);
    return $contenido;
}

function delete($conn, $basedatos, $tabla) {
    $tomado = tomado($conn, $basedatos, $tabla);
    $post_dato_llave = post_dato_llave($conn, $basedatos, $tabla);
    $insert = $post_dato_llave . "    \$sql = \"DELETE FROM $tabla";
    $insert = $insert . "\n            WHERE " . $tomado[2] . " = '$" . $tomado[2] . "'\";\n";
    $sql = $insert;
    $contenido = consulta("borrar", $sql);
    return $contenido;
}

function crud($conn, $basedatos, $tabla) {
    $insert = insert($conn, $basedatos, $tabla);
    $update = update($conn, $basedatos, $tabla);
    $delete = delete($conn, $basedatos, $tabla);
    $contenido = "<?php\n"
            . "include 'conexion.php';\n"
            . "\$conn = conexion();\n\n"
            . "\$accion = \$_GET['accion'];\n\n"
            . $insert . "else" . $update . "else" . $delete . "\n?>";
    archivo("proyecto/modelo/$tabla" . "_modelo", $contenido);
    $conexion = connection_base($basedatos);
    archivo("proyecto/modelo/conexion", $conexion);
    echo "<br><br>exito";
}






?>