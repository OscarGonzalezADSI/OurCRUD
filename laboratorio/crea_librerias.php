<?php

function librerias() {
    $head = "<link rel=\"stylesheet\" type=\"text/css\" href=\"../librerias/bootstrap/css/bootstrap.css\">\n\n"
            . "<script src=\"../librerias/bootstrap/js/jquery-3.3.1.min.js\"></script>\n"
            . "<script src=\"../librerias/bootstrap/js/bootstrap.js\"></script>\n";
    return $head;
}


function archivo_librerias($tabla, $contenido) {
    $archivo = fopen("proyecto/vista/$tabla.php", "w+b");
    if ($archivo == false) {
        echo "Error al crear el archivo";
    } else {
        fwrite($archivo, $contenido);
        fflush($archivo);
    }
    fclose($archivo);
}

archivo_librerias("librerias", librerias());
?>

