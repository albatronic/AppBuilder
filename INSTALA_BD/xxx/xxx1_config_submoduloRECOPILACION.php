<?php

//Número de Opción de la raiz del SUBMódulo. En el caso del Menú Principal de entrada al Módulo, la opción coincide con la raiz del MÓDULO
$variablesubmodulo_opcion_raiz_submodulo=0; 

// CARPETA DONDE ESTÁN LOS SCRIPTS DE ESTE MÓDULO _______________________________________________________________
$variablesubmodulo_carpeta_submodulo="t_terceros"; 

// VARIABLES DE ENTORNO ____________________________________________________________________________________________
// ¡¡¡OJO!!! El Fichero que contiene las Variables de Entorno de este Módulo (en la ruta "data/variables/") tendrá el nombre que le demos a la carpeta que contiene los Scripts del Módulo

// TABLA QUE SOPORTA ESTE MÓDULO EN LA BASE DE DATOS _______________________________________________________________
// ¡¡¡OJO!!! El nombre de la tabla (sin el prefijo en caso de que tuviera) es igual que el nombre de la carpeta donde se encuentran los Scripts del Módulo
$variablesubmodulo_tabla_submodulo=$variableadmin_prefijo_tablas.$variablesubmodulo_carpeta_submodulo; 


//Si asignamos mediante la siguiente variable permiso global a este nivel, entonces no consultaremos a la base de datos si el usuario en cuestión tiene permiso de acceso a este Módulo, ya que todos los usuarios tendrán permisos de acceso
$variablesubmodulo_permiso_global_este_nivel="SI"; 

//BARRA DE HERRAMIENTAS _______________________________________________________________
//Definimos si en este módulo se mostrará la Barra de Menús/Herramientas
$variablesubmodulo_mostrar_barra_herramientas="SI"; 

//CUADRO DIALOGO "NUEVO REGISTRO" _______________________________________________________________
//Definimos el Mensaje del Cuadro de Diálogo que aparece cuando se pulsa el botón "Nuevo"
$variablesubmodulo_mensaje_dialogo_nuevo="Se dispone a crear un<br />Nuevo Tercero"; 

//PERMISOS _______________________________________________________________
//Definimos los valores de los Pérmisos Básicos
$variablesubmodulo_id_opcion_permiso_insert=9;
$variablesubmodulo_id_opcion_permiso_update=13;
$variablesubmodulo_id_opcion_permiso_delete=14;
$variablesubmodulo_id_opcion_permiso_list=15;
//$variablesubmodulo_script_permisos_particulares="";


//CAMPOS BASICOS DE LA TABLA QUE SOPORTA EL MODULO _______________________________________________________________
$variablesubmodulo_nombre_campo_id="id_vi_inventarioviviendas"; // Nombre del campo "id"
$variablesubmodulo_nombre_campo_num="num_vi_inventarioviviendas"; // Nombre del campo "num"
$variablesubmodulo_nombre_campo_md5="num_vi_inventarioviviendas_md5"; // Nombre del campo "md5"
$variablesubmodulo_nombre_campo_foco="nombre"; // Nombre del campo sobre el que se situar&aacute; el foco del formulario


?>
