<?php
//fuente: https://datoweb.com/post/2791/como-copiar-directorios-o-carpetas-completas-con-php

//Comprobamos si ya existe la copia
if(!is_dir('carpeta_copia')){
//Asignamos la carpeta que queremos copiar
$source = "librerias";
//El destino donde se guardara la copia
$target = "proyecto/librerias";
full_copy($source, $target);
}

//Crear nuevos directorios completos
function full_copy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }
 
        $d->close();
    }else {
        copy( $source, $target );
    }
}