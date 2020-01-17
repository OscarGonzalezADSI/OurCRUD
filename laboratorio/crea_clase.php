<?php

function crea_clase($base, $tabla) {
    $conn = conexion_clase();
    $sql = "Select COLUMN_NAME, COLUMN_KEY, DATA_TYPE
               FROM information_schema.columns
               WHERE TABLE_SCHEMA='$base'
               AND TABLE_NAME='$tabla'";
    $consulta = mysqli_query($conn, $sql);
    $x = 1;
    $y = 1;
    $modi[$x] = "";
    $tomad = "";
    while ($fila = mysqli_fetch_assoc($consulta)) {
        if ($fila['COLUMN_KEY'] == "PRI") {
            $llave = $fila['COLUMN_NAME'];
            $llave_tipo_dato = tipo_campo($fila);
        } else {
            $modi[$y] = $fila['COLUMN_NAME'];
            $modi_tipo_dato[$y] = tipo_campo($fila);
            $y++;
        }
        $campo[$x] = $fila['COLUMN_NAME'];
        $tipo_dato[$x] = tipo_campo($fila);
                
        if ($x < 2) {
            $tomad = $tomad . $campo[$x] . "";
        } else {
            $tomad = $tomad . ", " . $campo[$x] . "";
        }
        $x++;
    }
    archivo_clase($tabla, pag_web_clase($tabla, $campo, $tipo_dato, $llave, $llave_tipo_dato, $modi, $modi_tipo_dato, $tomad));
}

function tipo_campo($fila) {
    if ($fila['DATA_TYPE'] == "datetime") {
        $tipo_dato = "datetime-local";
    }elseif ($fila['DATA_TYPE'] == "date") {
        $tipo_dato = "date";
    }elseif ($fila['DATA_TYPE'] == "time") {
        $tipo_dato = "time";
    } elseif ($fila['DATA_TYPE'] == "varchar") {
        $tipo_dato = "text";
    } elseif ($fila['DATA_TYPE'] == "text") {
        $tipo_dato = "text";
    } elseif ($fila['DATA_TYPE'] == "int") {
        $tipo_dato = "number";
    } elseif ($fila['DATA_TYPE'] == "double") {
        $tipo_dato = "number";
    }
    return $tipo_dato;
}

function conexion_clase() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}

function archivo_clase($tabla, $contenido) {
    $archivo = fopen("proyecto/vista/$tabla.php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
}

function pag_web_clase($tabla, $campo, $tipo_dato, $llave, $llave_tipo_dato, $modi, $modi_tipo_dato, $tomad){
    $head = head_clase($tabla);
    $body = body_clase($tabla, $campo, $tipo_dato, $llave, $llave_tipo_dato, $modi, $modi_tipo_dato, $tomad);
    $pag_web = "<!DOCTYPE html>\n"
            . "<html>\n"
            . $head
            . $body
            . "</html>\n";

    return $pag_web;
}

function head_clase($tabla) {
    $head = "    "
            . "<head>\n\t"
            . "<meta charset=\"UTF-8\">\n\t"
            . "<title>Clientes</title>\n\t"
            . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">\n\t"
            . "<?php\n\t"
            . "include('librerias.php');\n\t"
            . "?>\n\t"
            . "<script src=\"../controlador/funciones_" . $tabla . ".js\"></script>\n    "
            . "</head>\n    ";
    return $head;
}

function body_clase($tabla, $campo, $tipo_dato, $llave, $llave_tipo_dato, $modi, $modi_tipo_dato, $tomad){
    $modal_insertar = modal_insertar($campo, $tipo_dato);
    $modal_edicion = modal_edicion($llave, $llave_tipo_dato, $modi, $modi_tipo_dato);
    $script = script($campo, $tabla, $tomad);
    $body = "<body id=\"body\">\n\t"
            . "<?php\n\t"
            . "include 'header.php';\n\t"
            . "?>\n\t"
            . "<div class=\"container\">\n\t    "
            . "<div id=\"tabla\"></div>\n\t"
            . "</div>\n"
            . $modal_insertar
            . $modal_edicion
            . $script
            . "<?php\n\t"
            . "include './footer.php';\n\t"
            . "?>\n    "
            . "</body>\n";
    return $body;
}

function modal_insertar($campo, $tipo_dato) {
    $cuerpo_modal_insertar = cuerpo_modal_insertar($campo, $tipo_dato);
    $modal_insertar = "\t<!-- MODAL PARA INSERTAR REGISTROS -->\n\t"
            . "<div class=\"modal fade\" id=\"modalNuevo\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">\n\t    "
            . "<div class=\"modal-dialog modal-sm\" role=\"document\">\n\t\t"
            . "<div class=\"modal-content\">\n\t\t    "
            . "<div class=\"modal-header\">\n\t\t\t"
            . "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n\t\t\t    "
            . "<span aria-hidden=\"true\">&times;</span>\n\t\t\t"
            . "</button>\n\t\t\t"
            . "<h4 class=\"modal-title\" id=\"myModalLabel\">Agregar cliente</h4>\n\t\t    "
            . "</div>\n\t\t    " . $cuerpo_modal_insertar
            . "<div class=\"modal-footer\">\n\t\t\t"
            . "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\" id=\"guardarnuevo\">\n\t\t\t    "
            . "Agregar\n\t\t\t"
            . "</button>\n\t\t    "
            . "</div>\n\t\t"
            . "</div>\n\t    "
            . "</div>\n\t"
            . "</div>\n";
    return $modal_insertar;
}

function cuerpo_modal_insertar($campo, $tipo_dato) {
    $cuerpo_modal_insertar = "<div class=\"modal-body\">\n\t\t\t";
    $x = 1;
    while ($x <= count($campo)) {
        if($tipo_dato[$x] == "text"){
                    $cuerpo_modal_insertar = $cuerpo_modal_insertar . "<label>" . $campo[$x]
                . "</label>\n\t\t\t<textarea id=\"". $campo[$x] ."\" rows=\"4\" cols=\"50\""
                . "class=\"form-control input-sm\" required=\"\"></textarea>\n\t\t\t";
        }else{
                    $cuerpo_modal_insertar = $cuerpo_modal_insertar . "<label>" . $campo[$x]
                . "</label>\n\t\t\t<input type=\"" . $tipo_dato[$x] . "\" id=\""
                . $campo[$x] . "\" class=\"form-control input-sm\" required=\"\">\n\t\t\t";
        }
        $x++;
    }
    $cuerpo_modal_insertar = $cuerpo_modal_insertar . "</div>\n\t\t    ";

    return $cuerpo_modal_insertar;
}

function modal_edicion($llave, $llave_tipo_dato, $modi, $modi_tipo_dato){
    $cuerpo_modal_edicion = cuerpo_modal_edicion($llave, $llave_tipo_dato, $modi, $modi_tipo_dato);
    $modal_edicion = "\t<!-- MODAL PARA EDICION DE DATOS-->\n\t"
            . "<div class=\"modal fade\" id=\"modalEdicion\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">\n\t    "
            . "<div class=\"modal-dialog modal-sm\" role=\"document\">\n\t\t"
            . "<div class=\"modal-content\">\n\t\t    "
            . "<div class=\"modal-header\">\n\t\t\t"
            . "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n\t\t\t    <span aria-hidden=\"true\">&times;</span>\n\t\t\t</button>\n\t\t\t"
            . "<h4 class=\"modal-title\" id=\"myModalLabel\">Actualizar datos</h4>\n\t\t    "
            . "</div>\n\t\t    "
            . "<div class=\"modal-body\">\n\t\t\t" . $cuerpo_modal_edicion
            . "</div>\n\t\t    "
            . "<div class=\"modal-footer\">\n\t\t\t"
            . "<button type=\"button\" class=\"btn btn-warning\" data-dismiss=\"modal\" id=\"actualizadatos\">\n\t\t\t    "
            . "Actualizar\n\t\t\t"
            . "</button>\n\t\t    "
            . "</div>\n\t\t"
            . "</div>\n\t    "
            . "</div>\n\t"
            . "</div>";
    return $modal_edicion;
}

function cuerpo_modal_edicion($llave, $llave_tipo_dato, $modi, $modi_tipo_dato){
    $cuerpo_modal_edicion = "<input type=\"".$llave_tipo_dato."\" hidden=\"\" id=\"" . $llave . "u\">\n\t\t\t";
    $x = 1;
    while ($x <= count($modi)) {
        if($modi_tipo_dato[$x] == "text"){
            $cuerpo_modal_edicion = $cuerpo_modal_edicion . "<label>" . $modi[$x] . "</label>\n\t\t\t<textarea id=\"". $modi[$x] ."u\" rows=\"4\" cols=\"50\" class=\"form-control input-sm\" required=\"\"></textarea>\n\t\t\t";
        }else{
            $cuerpo_modal_edicion = $cuerpo_modal_edicion . "<label>" . $modi[$x] . "</label>\n\t\t\t<input type=\"" . $modi_tipo_dato[$x] . "\" id=\"" . $modi[$x] . "u\" class=\"form-control input-sm\" required=\"\">\n\t\t\t";
        }
        $x++;
    }
    return $cuerpo_modal_edicion;
}

function script($campo, $tabla, $tomad) {
    $script_guardar = script_guardar($campo);
    $script = "\n\t"
            . "<script type=\"text/javascript\">\n\t    "
            . "$(document).ready(function () {\n\t\t"
            . "$('#tabla').load('componentes/vista_" . $tabla . ".php');\n\t    "
            . "});\n\t"
            . "</script>\n\t"
            . "<script type=\"text/javascript\">\n\t    "
            . "$(document).ready(function () {\n\t\t"
            . "$('#guardarnuevo').click(function () {\n\t\t    "
            . $script_guardar
            . "agregardatos($tomad);\n\t\t"
            . "});\n\t\t"
            . "$('#actualizadatos').click(function () {\n\t\t    "
            . "modificarCliente();\n\t\t"
            . "});\n\t    "
            . "});\n\t"
            . "</script>\n\t";
    return $script;
}

function script_guardar($campo) {
    $script_guardar = "";
    $x = 1;
    while ($x <= count($campo)) {
        $script_guardar = $script_guardar . $campo[$x] . " = $('#" . $campo[$x] . "').val();\n\t\t    ";
        $x++;
    }
    return $script_guardar;
}
?>
