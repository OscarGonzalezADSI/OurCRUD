<?php

function conexion(){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $conn = mysqli_connect($host, $user, $password);
    return $conn;
}


function crear_vista($base, $tabla){

$conn = conexion();

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

archivo_vista($tabla, pag_web($tabla, $datos, $llave)); 

}




function archivo_vista($tabla, $contenido) {
    $archivo = fopen("proyecto/vista/componentes/vista_$tabla.php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
    // https://www.php.net/manual/es/function.rename.php
}

function pag_web($tabla, $datos, $llave){
    $registro = registro($datos);
$btnMod = "                <button class=\"btn btn-warning glyphicon glyphicon-pencil\"\n"
        . "                               data-toggle=\"modal\"\n"
        . "                               data-target=\"#modalEdicion\"\n"
        . "                               onclick=\"agregaform('<?php echo \$datos; ?>')\">\n"
        . "                </button></td>\n";
$btnEli = "                <button class=\"btn btn-danger glyphicon glyphicon-remove\"\n"
        . "                           onclick=\"preguntarSiNo('<?php echo \$fila['" . $llave . "']; ?>')\">\n"
        . "                </button>\n";
    $abre_conexion = abre_conexion();
    $head = head();
    $body = body($datos, $registro, $btnMod, $btnEli, $tabla);
    $cierra_conexion = cierra_conexion();
    $pag_web = $abre_conexion
            . "<!DOCTYPE html>\n"
            . "<html>\n"
            . $head . $body
            . "</html>\n"
            . $cierra_conexion; 
    return $pag_web;
}

function registro($datos) {
$x = 1;
$registro = "";
while ($x <= count($datos)) {
$registro = $registro . "            <td><?php echo \$fila['" . $datos[$x] . "']; ?></td>\n";
$x++;
} 
return $registro;
} 

function abre_conexion() {
    $abre_conexion = "<?php\n"
            . "include_once '../../modelo/conexion.php';\n"
            . "\$conn = conexion();\n"
            . "?>\n";
    return $abre_conexion;
}

function head() {
    $head = "<head>\n"
            . "    <meta charset=\"UTF-8\">\n"
            . "    <title>arreglos</title>\n"
            . "</head>\n";
    return $head;
}

function body($datos, $registro, $btnMod, $btnEli, $tabla){
    
    $table = table($tabla, $datos, $registro, $btnMod, $btnEli);
    $body = "<div class=\"row\"><br><br><br><br>\n"
            . "    <div>\n"
            . "<center>\n"
            . "<h2>".$tabla."</h2>\n"
            . "</center>\n"
            . "<button class=\"btn btn-primary navbar-left\"\n"
            . "               data-toggle=\"modal\"\n"
            . "               data-target=\"#modalNuevo\">\n"
            . "    Agregar ".$tabla."\n"
            . "    <span class=\"glyphicon glyphicon-plus\"></span>\n"
            . "</button></div>\n"
            . $table
            . "</div>\n"
            . "</body>\n";
    return $body;
}

function table($tabla, $datos, $registro, $btnMod, $btnEli){
    
    $thead = thead($datos);
    $tbody = tbody($tabla, $datos, $registro, $btnMod, $btnEli);
    $table = "    <table class=\"table table-hover table-condensed table-bordered table-responsive\">\n"
            . $thead
            . $tbody
            ."    </table>\n";
    return $table;
}

function thead($datos) {
    $crea_thead = crea_thead($datos);
    $thead = "    <thead>\n"
            . "        <tr>\n"
            . $crea_thead
            . "        </tr>\n"
            . "   </thead>\n";
    return $thead;
}

function crea_thead($datos) {
    $x = 1;
    $crea_thead = "";
    while ($x <= count($datos)) {
        $crea_thead = $crea_thead . "            <th>" . $datos[$x] . "</th>\n";
        $x++;
    }
    return $crea_thead;
} 


function tbody($tabla, $datos, $registro, $btnMod, $btnEli){
    $tomar = tomar($datos);
    $listar = "    \$sql = 'SELECT * FROM $tabla';\n";
    $tbody = "    <tbody>\n"
            . "    <?php\n"
            . $listar
            . "    \$result = mysqli_query(\$conn, \$sql);\n"
            . "    WHILE(\$fila = mysqli_fetch_assoc(\$result)){\n"
            . $tomar
            . "    ?>\n"
            . "        <tr>\n" . $registro
            . "            <td>\n" . $btnMod
            . "            <td>\n" . $btnEli
            . "            </td>\n"
            . "        </tr>\n"
            . "    <?php\n"
            . "    }\n"
            . "    ?>\n"
            . "    </tbody>\n";
    return $tbody;
}

function tomar($datos) {
$x = 1;
$tomar = "        \$datos = \$fila['" . $datos[$x] . "'] . \"||\" .\n";
$x++;
while ($x < count($datos)) {       
$tomar = $tomar . "                  \$fila['" . $datos[$x] . "'] . \"||\" .\n";
$x++;
}       
$tomar = $tomar . "                  \$fila['" . $datos[$x] . "'];\n";
    return $tomar;
} 

function cierra_conexion() {
    $cierra_conexion = "<?php\n"
            . "mysqli_close(\$conn);\n"
            . "?>\n";
    return $cierra_conexion;
}
?>
