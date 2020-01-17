# OurCRUD 
OurCRUD es un automatizador de procesos para proyectos de desarrollo web, bajo el patrón de diseño Modelo-Vista-Controlador utilizando las tecnologías PHP, MySQL, AJAX, JQUERY, HTML, CSS y BOOTSTRAP.<br/><br/>
# OurCRUD 2.1
En esta versión se mejoró la presentación de los formularios de insertar y modificar registros para que el programa reconozca cuando el campo es de tipo "text" y habilite la etiqueta apropiada bajo el siguiente estandar:<br/><br/>

Mostrará un "texarea" en lugar de un simple cuadro de texto, bajo la siguiente configuración por defecto:<br/></br>
<textarea id="id_campo" rows="4" cols="50" class="form-control input-sm" required=""></textarea></br></br>
<pre>
# Informe de cambios.

# linea 45 del archivo laboratorio/crea_clase.php
    } elseif ($fila['DATA_TYPE'] == "text") {
        $tipo_dato = "text";

# linea 144 del archivo laboratorio/crea_clase.php
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

# linea 187 del archivo laboratorio/crea_clase.php
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


# 
# Mostrará un "texarea" en lugar de un simple cuadro de texto, bajo la siguiente configuración por defecto:
# <textarea id="id_campo" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
</pre>
<hr/>


OscarGonzalez1987/OurCRUD is licensed under the
# GNU Lesser General Public License v3.0
Permissions of this copyleft license are conditioned on making available complete source code of licensed works and modifications under the same license or the GNU GPLv3. Copyright and license notices must be preserved. Contributors provide an express grant of patent rights. However, a larger work using the licensed work through interfaces provided by the licensed work may be distributed under different terms and without source code for the larger work.
