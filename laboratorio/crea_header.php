<?php

function crea_header($base) {
$conn = conexion_menu($base);
$sql = "Show tables from $base";
$consulta = mysqli_query($conn, $sql);
$x = 1;
$enlace = "";
while ($fila = mysqli_fetch_assoc($consulta)) {
	$tabla = "Tables_in_".$base;
	$enlace = $enlace."<li><a href=\"".$fila[$tabla].".php\">".$fila[$tabla]."</a></li>\n";
    $x++;
}
archivo_header("header", menu($enlace));
}

function conexion_menu($base){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = $base;
    $conn = mysqli_connect($host, $user, $password, $database);
    return $conn;
}

function archivo_header($tabla, $contenido) {
    $archivo = fopen("proyecto/vista/$tabla.php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
}

function menu($enlace) {
    $head = "<nav class=\"navbar navbar-inverse navbar-fixed-top\">\n"
            . "    <div class=\"container-fluid\">\n"
            . "        <div class=\"navbar-header\">\n"
            . "            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\">\n"
            . "                <span class=\"icon-bar\"></span>\n"
            . "                <span class=\"icon-bar\"></span>\n"
            . "                <span class=\"icon-bar\"></span>\n"
            . "            </button>\n"
            . "            <a class=\"navbar-brand\" href=\"#\"></a>\n"
            . "        </div>\n"
            . "        <div class=\"collapse navbar-collapse\" id=\"myNavbar\">\n"
            . "            <ul class=\"nav navbar-nav\">\n"
            . $enlace
            . "            </ul>\n"
            . "            <ul class=\"nav navbar-nav navbar-right\">\n"
            . "                <li><?php echo \"<a href='../modelo/salir.php'><span class='glyphicon glyphicon-log-in'></span> Cerrar sesión </a>\" ?></li>\n"
            . "            </ul>\n"
            . "        </div>\n"
            . "    </div>\n"
            . "</nav>";
    return $head;
}
?>

