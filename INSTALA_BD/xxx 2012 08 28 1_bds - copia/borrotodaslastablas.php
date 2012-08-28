<?php

include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

//echo "<a href='crea.php'>Volver al Listado Principal</a><hr>";

/* SCRIPT PARA BORRAR TODAS LAS TABLAS*/

include("conecta.php"); /*Conectamos con MYSQL y usamos la Base de datos creada con    
                                     anterioridad */
$db=conecta();

$tabla=$variableadmin_prefijo_tablas."core_perfiles";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_usuarios";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_tiposusuarios";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_aplicaciones";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_tiposfuncionalidad";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_modulos";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_permisos";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_roles";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_urlamigables";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."core_imagenes";
include("ejecutoborrotabla.php");



/*
$tabla=$variableadmin_prefijo_tablas."registromodificaciones";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."contadorvisitas";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."opciones";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."permisos";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."perfilesdeusuarios";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."tiposusuarios";
include("ejecutoborrotabla.php");


$tabla=$variableadmin_prefijo_tablas."versiones";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."visitas";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."t_terceros";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."t_paises";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."t_provincias";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."t_tiposdevias";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."t_vias";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."t_localidades";
include("ejecutoborrotabla.php");
*/

/* Cerramos la CONEXION */
mysql_close($db);
?>
