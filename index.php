<?php
include_once "modelo/Conexion_doc.php";
$conn = Conexion();
?>
<!DOCTYPE html>
<!--
OurCRUD
OscarGonzalez1987/OurCRUD is licensed under the

GNU General Public License v3.0
Permissions of this strong copyleft license are conditioned 
on making available complete source code of licensed works 
and modifications, which include larger works using a licensed 
work, under the same license. Copyright and license notices 
must be preserved. Contributors provide an express grant of 
patent rights.

    Created on : 6/01/2020, 02:59:20 PM
    Author     : oscar gonzalez
    Email      : oigonzalez83@misena.edu.co

-->
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="librerias/css/boton_whatsapp.css" rel="stylesheet" type="text/css"/>

        <script src="librerias/js/jquery-3.4.1min.js" type="text/javascript"></script>
        <script src="librerias/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="librerias/js/interactividad.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
            <a class="navbar-brand" href="https://github.com/OscarGonzalez1987/practica_inicial/blob/master/index.html">
                GitHub
            </a>
            <form style="margin-left:20px" action="laboratorio/crear_proyecto.php">
                <select class="selector text-info" name="base">
                    <option value="">BBDD...</option>
                    <option value=""></option>
                    <?php
                    $sql = "SHOW DATABASES";
                    $result = mysqli_query($conn, $sql);
                    while ($database = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $database['Database']; ?>"><?php echo $database['Database']; ?></option>
                        <?php
                    }
                    ?>
                </select>      
                <input class="btn btn-sm btn-primary" type="submit" value="enviar"><br/>
            </form> 
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">


                    </li>  
                </ul>
            </div>  
        </nav>
        <br/>
        <br/>
        <br/>
        <br/>
        <div class="container">
            <div class="col-sm-4" style="float:left">
                <center>
                    <img style="height:250px;" src="imagenes/our_crud.png" alt=""/><br/>
                    <b>Versión 2.1</b>
                </center>
                <div style="float: left">
                    <a href="laboratorio/crear_proyecto.php"></a>
                    <div style="font-size: 14px;
                         line-height: 1.5;
                         color: #24292e;
                         box-sizing: border-box; float:right;"><hr/>
                        <p class="text-small text-gray mb-0 lh-condensed-ultra">
                            OscarGonzalez1987/OurCRUD is licensed under the
                        </p>
                        <center>
                            <h3 class="mt-0 mb-2 h4">GNU General Public</br> License v3.0</h3><br/>
                        </center>
                    </div>                
                </div> 
            </div>

            <div class="col-sm-4" style="float:left">
                <p><b>OurCRUD</b> es un automatizador de procesos para proyectos
                    de desarrollo web bajo el patrón de diseño <b>Modelo-Vista-Controlador</b>
                    utilizando las tecnologías PHP, MySQL, AJAX, JQUERY, HTML, CSS,
                    BOOTSTRAP.</p>
                <p><b>OurCRUD</b> utiliza jQuery para la Vista de cada una de las
                    tablas, AJAX para el desarrollo del Controlador, y el PHP
                    para el Modelo; configurado todo de manera automática.</p>
                <p>Tan solo tiene que seleccionar la base de datos, en el menu 
                    desplegable de la parte superior izquierda y presionar el 
                    botón "enviar".</p>
                <p><b>OurCRUD</b> crea en la carpeta "proyectos" en
                    el paquete CRUD con su respectivo nombre, sus capas, 
                    conexiones y funcionalidades listas para usar, puesto que
                    lo redireccioná a la vista de su primera tabla.</p>




            </div>
            <div class="col-sm-4" style="float:left;">
                
                <p><b>OurCRUD</b> en su versión Master 2.0, no genera manejo de 
                    sesiones, ni medidas de seguridad; solo centra su atención 
                    en la complejidad de administración de bases de datos.<br/><br/>
                Usted como desarrollador debe asumir la responsabilidad de 
                    atender las limitaciones del software y ajustarlo a los requerimientos
                    de cada proyecto.</p>
                <b>Software desarrollado por:</b><br/> Óscar Iván González Peña,
                    Aprendiz SENA.<br/><br/>
                    <b>Formación:</b> Tecnólogía en Análisis y Desarrollo de Sistemas
                    de Información.<br/><br/>
                    <b>Instructor:</b> César Alfonso Bolado Silva.<br/>

                <br/><br/>

            </div>
            <div id="boton_telefono" style="float:right;">          
                <table class="table table-borderless" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td id="boton_icono">
                                <img src="imagenes/whatsapp.png" alt=""/>
                            </td>

                            <td id="boton_texto">
                                <a id="boton_icono"
                                   href="https://api.whatsapp.com/send?phone=573228858439&text=Hola%20Oscar,%20he%20visto%20tu%20perfil%20de%20Git%20Hub.">
                                    Whatsapp
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="height:300px; float:left;">
                <div class="row" style="height:100px"></div>

                <div style="min-height:100px;">
                    <div style="min-width:100px; height:100px; float:left;">
                        <img  style="width:150px;" src="imagenes/logo_php.png" alt=""/>
                    </div>
                    <div style="min-width:100px; height:100px; float:left;">
                        <img style="width:150px;" src="imagenes/logo_mysql.png" alt=""/>
                    </div>

                </div>
                <div class="row" style="height:100px"></div>    
            </div>

            <div style="height:300px; float:left;">
                <div class="row" style="height:100px"></div>
                <div style="min-height:100px;">
                    <div style="min-width:100px; height:100px; float:left;">
                        <img style="width:150px;" src="imagenes/logo_ajax.png" alt=""/>
                    </div>                    
                    <div style="min-width:100px; height:100px; float:left;">
                        <img style="width:150px;" src="imagenes/logo_Jquery.png" alt=""/>
                    </div>

                </div>
                <div class="row" style="height:200px"></div>    
            </div>
            <div style="height:300px; float:left;">
                <div class="row" style="height:100px"></div>
                <div style="min-height:100px;">

                    <div style="min-width:100px; height:100px; float:left;">
                        <img style="width:150px;" src="imagenes/logo_html.png" alt=""/>
                    </div>
                    <div style="min-width:100px; height:100px; float:left;">
                        <img style="width:150px;" src="imagenes/logo_css.png" alt=""/>
                    </div>
                    <div style="min-width:100px; height:100px; float:left;">
                        <img style="padding-top:200px;  width:150px;" src="imagenes/logo_bootstrap.png" alt=""/>

                    </div> 
                </div><br/><br/><br/><br/><br/><br/>


            </div>




            <div class="row" style="height:420px"></div><br/>
            <div class="col-sm-4" style="float:left;">

                <hr/>
                <b>Agradecimientos</b><br/>
                <p>Agradezco al SENA y al Estado Colombiano la existencia del programa de monitorias, que durante 5 meses me permitió dedicarme exclusivamente a estudiar y desarrollar este Software.</p><br/><br/><br/>

            </div>
            <div class="col-sm-4" style="float:right;">

                <hr/>
                <b>Dedicatorias:</b><br/>
                <p>Dedico el desarrollo de este software a la excelente enseñanza de mi instructor líder, el ingeniero César Bolado y en especial a mi madre, Martha Peña, que me ha tenido que aguantar con mis labores nocturnas como programador durante todo este tiempo.</p><br/><br/>
            </div>
            
            <div class="col-md-6" 
                 style="font-size: 14px;
                 line-height: 1.5;
                 color: #24292e;
                 box-sizing: border-box; float:right;"><br/><hr/>
                <p class="text-small text-gray mb-0 lh-condensed-ultra">
                    OscarGonzalez1987/OurCRUD is licensed under the
                </p>
                <h3 class="mt-0 mb-2 h4">GNU General Public License v3.0</h3>
                <p class="mb-0 text-gray text-small pr-2">
                    Permissions of this strong copyleft license are conditioned on making available complete source code of licensed works and modifications, which include larger works using a licensed work, under the same license. Copyright and license notices must be preserved. Contributors provide an express grant of patent rights.</p>
            </div>
            <div class="col-md-4" 
                 style="font-size: 14px;
                 line-height: 1.5;
                 color: #24292e;
                 box-sizing: border-box; float:right; text-align:right"><br/><hr/>
                <p class="text-small text-gray mb-0 lh-condensed-ultra" style="text-align:left">
                    Autor:
                </p>
                <h3 class="mt-0 mb-2 h4">Óscar González</h3>
                oigonzalez83@misena.edu.co<br/>
                Cúcuta - Colombia<br/>2020<br/><br/><br/>
            </div>
        </div>
        <div class="row" style="height:300px"></div>
    </body>
</html>

