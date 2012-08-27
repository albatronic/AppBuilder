<?php

//Número de Opción de la raiz del SUBMódulo. En el caso del Menú Principal de entrada al Módulo, la opción coincide con la raiz del MÓDULO
$variablesubmodulo_opcion_raiz_submodulo=28; 

// CARPETA DONDE ESTÁN LOS SCRIPTS DE ESTE MÓDULO _______________________________________________________________
$variablesubmodulo_carpeta_submodulo="t_vias"; 

// VARIABLES DE ENTORNO ____________________________________________________________________________________________
// ¡¡¡OJO!!! El Fichero que contiene las Variables de Entorno de este Módulo (en la ruta "data/variables/") tendrá el nombre que le demos a la carpeta que contiene los Scripts del Módulo

// TABLA QUE SOPORTA ESTE MÓDULO EN LA BASE DE DATOS _______________________________________________________________
// ¡¡¡OJO!!! El nombre de la tabla (sin el prefijo en caso de que tuviera) es igual que el nombre de la carpeta donde se encuentran los Scripts del Módulo
$variablesubmodulo_tabla_submodulo=$variableadmin_prefijo_tablas.$variablesubmodulo_carpeta_submodulo; 


//Si asignamos mediante la siguiente variable permiso global a este nivel, entonces no consultaremos a la base de datos si el usuario en cuestión tiene permiso de acceso a este Módulo, ya que todos los usuarios tendrán permisos de acceso
$variablesubmodulo_permiso_global_este_nivel="NO"; 

//BARRA DE HERRAMIENTAS _______________________________________________________________
//Definimos si en este módulo se mostrará la Barra de Menús/Herramientas
$variablesubmodulo_mostrar_barra_herramientas="SI"; 

//CUADRO DIALOGO "NUEVO REGISTRO" _______________________________________________________________
//Definimos el Mensaje del Cuadro de Diálogo que aparece cuando se pulsa el botón "Nuevo"
$variablesubmodulo_titulo_dialogo_nuevo="Nueva V&iacute;a"; 
$variablesubmodulo_mensaje_dialogo_nuevo="Se dispone a crear una<br />Nueva V&iacute;a"; 

//PERMISOS _______________________________________________________________
//Definimos los valores de los Pérmisos Básicos
$variablesubmodulo_id_opcion_permiso_insert=29;
$variablesubmodulo_id_opcion_permiso_update=30;
$variablesubmodulo_id_opcion_permiso_delete=31;
$variablesubmodulo_id_opcion_permiso_list=32;
$variablesubmodulo_id_opcion_permiso_auditoriacampo=33;
$variablesubmodulo_script_permisos_particulares="";


//CAMPOS BASICOS DE LA TABLA QUE SOPORTA EL MODULO _______________________________________________________________
$variablesubmodulo_nombre_campo_id="id_vias"; // Nombre del campo "id"
$variablesubmodulo_nombre_campo_md5="num_vias_md5"; // Nombre del campo "md5"
$variablesubmodulo_nombre_campo_foco="nombrevia"; // Nombre del campo sobre el que se situar&aacute; el foco del formulario

// NÚMERO MÁXIMO DE REGISTROS QUE PODRÁ TENER ESTA TABLA ____________________________________
$variablesubmodulo_maxobjetos=9879769789;

// SUBCARPETA EN "data" DONDE SE ALMACENARÁN LOS POSIBLES ARCHIVOS QUE SE GENEREN EN ESTE MÓDULO __________________________
$variablesubmodulo_rutaalmacenamiento=$variableadmin_prefijo_bd."data/".$variablesubmodulo_carpeta_submodulo."/";

// PROCESO INSERT _______________________________________________________________
$variablesubmodulo_valores_insert="1_valores_insert_particulares"; // Es el Script que tiene los valores de los campos NO PREDETERMINADOS que se insertarán inicialmente para este Módulo
$variablesubmodulo_proceso_despues_insert=""; // Contiene los procesos particulares de este módulo que se ejecutarán después de hacer el Insert 

// CAPTURAMOS DATOS DEL FORMULARIO _______________________________________________________________
$variablesubmodulo_elimino_acento_primer_caracter="SI"; // Si toma el valor SI, entonces eliminamos acentos en el primer carácter del campo. Esto se hace para que sea posible la ordenación alfabética

// PROCESO UPDATE _______________________________________________________________
$variablesubmodulo_update_campos_operados="1_update_campos_operados"; // Es el Script que trata el valor de algunos valores recibidos del formulario y los agrupa o hace determinadas operaciones para poder guardarlos en la B.D. mediante el proceso de UPDATE


// RESPECTO AL FORMULARIO _______________________________________________________________
$variablesubmodulo_input_hidden_particulares=""; // Son los campos INPUT type="hidden" particulares de este formulario/módulo

// CONTROL DE CAMPOS EN BLANCO _______________________________________________________________
// Se trata de un Array donde indicamos los campos que no se pueden quedar en blanco. La información va codificada en bloques de tres Valores. 1:NOMBRE DEL CAMPO DE LA TABLA QUE NO PUEDE QUEDAR EN BLANCO 2:CRITERIO PARA SABER SI ESTA EN BLANCO (longitud; valorcero) 3: TEXTO DE ERROR. 
$variablesubmodulo_control_campos_blanco_activar = "SI";
$variablesubmodulo_control_campos_blanco = array("id_localidad", "valorcero", "No puede dejar la Localidad en Blanco","id_provincia", "valorcero", "No puede dejar la Provincia en Blanco","nombrevia", "longitud", "No puede dejar el Nombre de la V&iacute;a en Blanco");


// CONTROL DE DATOS REPETIDOS _______________________________________________________________
$variablesubmodulo_control_datos_repetidos_activar = "SI";
$variablesubmodulo_control_datos_repetidos_script_particular = "1_controlCamposRepetidos"; // Si existe este Script, entonces el Control de Datos Repetidos, cargará la sentencia SQL desde este SCRIPT PARTICULAR que está en la carpeta del módulo
$variablesubmodulo_control_datos_repetidos = array("nombrevia", "", "Ya existe esta V&Iacute;A"); // Se trata de un Array donde indicamos los campos que no pueden tener valores repetidos en esta tabla. La información va codificada en bloques de tres Valores. 1:NOMBRE DEL CAMPO DE LA TABLA QUE NO PUEDE TENER VALORES REPETIDOS 2:VALOR QUE TOMARÁ EL CAMPO POR EL HECHO DE ESTAR REPETIDO (normalmente se dejará en blanco) 3:TEXTO DE ERROR. 



// TRANSFORMACIÓN EN MAYÚSCULAS _______________________________________________________________
$variablesubmodulo_mayusculas="SI"; // Si esta variable toma el valor SI, entonces los textos introducidos en los campos se transformarán en mayúsculas

// DEPENDENCIAS EN OTRAS TABLAS _______________________________________________________________
// Se trata de un Array donde indicamos las dependencias que hay en otras tablas. Esto es fundamental el el proceso de DELETE, ya que se comprobarán todas las dependencias descritas en este Array y si hay algún registro dependiente, entonces no se podrá realizar la eliminación. La información va codificada en bloques de tres Valores. 1:NOMBRE DE LA TABLA 2:NOMBRE DEL CAMPO 3:TEXTO QUE QUEREMOS QUE APAREZCA EN EL MENSAJE DE ERROR PARA ESE NOMBRE DE CAMPO.
//$nombre_tabla_t_terceros=$variableadmin_prefijo_tablas."t_terceros";
//$variablesubmodulo_control_dependencias = array($nombre_tabla_t_terceros, "num_representante_legal_md5", "Existen Terceros que tienen asignado este Tercero como Representante Legal");


// LISTADO _______________________________________________________________
$variablesubmodulo_listado_buscador="SI"; // Muestra el buscador en el Listado 
$variablesubmodulo_listado_abecedario="SI"; // Muestra el ABCEDARIO en el Listado 
$variablesubmodulo_listado_abecedario_campo_busqueda="nombrecompletovia"; // Indicamos sobre que campo hacemos la búsqueda cuando pulsamos un elemento del abecedario.

$variablesubmodulo_listado_campo_ordenacion="nombrecompletovia"; // Campo por el que haremos la ordenación Alfabética 
$variablesubmodulo_listado_orden="asc"; // Orden en el que se mostrarán inicialmente los resultados del listado (asc=ASCENDENTE; desc=DESCENDIENTE) 
$variablesubmodulo_listado_tamanio_paginacion=10; // Número de registros que se mostrarán en cada página del listado
$variablesubmodulo_listado_campo_condicion_1="nombrecompletovia"; // Campo en el que realizará la Búsqueda el Campo1 del Buscador del Listado y el ABECEDARIO 
$variablesubmodulo_listado_campo_condicion_2=""; // Campo en el que realizará la Búsqueda el Campo2 
$variablesubmodulo_listado_etiqueta_campo_condicion_1="Nombre V&iacute;a"; // Etiqueta del Campo1 del Buscador del Listado
$variablesubmodulo_listado_etiqueta_campo_condicion_2=""; // Etiqueta del Campo2 del Buscador del Listado

$variablesubmodulo_listado_plantilla="listado_1_columna.php"; // Indicamos la plantilla que se utilizará para mostrar el Listado
$variablesubmodulo_listado_estilo_columna_0=' style="width:50px; height:30px;"'; // Indicamos el estilo adicional de la columna CERO de la cabecera
$variablesubmodulo_listado_estilo_columna_1=''; // Indicamos el estilo adicional de la columna UNO de la cabecera
$variablesubmodulo_listado_etiqueta_columna_1="V&iacute;a"; // Indicamos el nombre que tendrá la cabecera de la Columna 1
$variablesubmodulo_listado_campo_columna_1="nombrecompletovia"; // Indicamos el campo que se mostrará en la Columna 1
$variablesubmodulo_listado_orden_asc_desc_columna_1="SI"; // Si esta variable toma el valor SI, entonces podremos ordenar ascendente y descendentemente el campo de la columna 1
$variablesubmodulo_listado_criterio_orden_columna_1="nombrecompletovia"; // Establecemos el campo que se utilizará de criterio para ordenar la columna1. Normalmente este valor coincide con $variablesubmodulo_listado_campo_columna_1


?>
