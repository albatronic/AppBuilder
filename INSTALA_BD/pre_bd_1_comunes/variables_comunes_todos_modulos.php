<?php

//Nombre del Script que hace de contenedor global.
//$variableadmin_script_contenedor="plataforma"; 

//Prefijo que pondremos al nombre de la B.D. Esto es �til si vamos a instalar la aplicaci�n en un sitio donde ya existiera una Base de Datos con el mismo nombre que la nuestra.
$variableadmin_prefijo_bd="";

//Prefijo que pondremos al nombre de las TABLAS. Esto es �til en el caso en que instalemos la aplicaci�n en una B.D. que ya existe, es decir, puede ser que existan tablas cuyo nombre coincida con alguna de las tablas de nuestra aplicaci�n.
$variableadmin_prefijo_tablas="";


// Nombre que le doy a la B.D. 
$variableadmin_nombre_bd=$variableadmin_prefijo_bd."cpanel";  //plataforma //qna711

// Nombre del Usuario de la B.D. 
$variableadmin_usuario_bd="cpanel";  //plataformauser //qna711

// Password de la B.D. 
$variableadmin_password_bd="cpanel"; //plataformapassword //Film2012

// Host de la B.D. 
$variableadmin_host_bd="localhost"; //localhost //llda963.servidoresdns.net  



//Módulo que se cargar� después de loguearnos
//$variableadmin_nombre_modulo_home=$variableadmin_prefijo_bd."gs_h"; 


$variableadmin_semillamd5="verano";
$variableadmin_fechaactivacion="2000-01-01 00:00:00";
$variableadmin_fechadesactivacion="2020-01-01 00:00:00";

// Nos dice el numero de modificaciones de cada objeto que almacenaremos en la base de datos, el resto se almacenar� en archivos de texto
//$variableadmin_maxregistrosmodif="50"; 


// Campos Tipo FECHA que son predeterminados en las Tablas y que no aparecen en los formularios.
//$variableadmin_campos_fecha_no_formularios = array("fechapublicacion", "fechaultimamodificacion", "fechaeliminar");


// Definimos Variables necesarias para controlar los ERRORES EN LOS FORMULARIOS
//$errorFormulario=0;
//$arrayDeErroresFormulario = array();

?>
