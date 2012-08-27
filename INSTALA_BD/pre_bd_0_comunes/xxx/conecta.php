<?php

$rutaConexion = $variableadmin_prefijo_bd.'0_comunes/parametros_conexion_database.php'; include_once("$rutaConexion");


// Cargamos las Variables que definen los parámetros de la Base de Datos
$nombre_bd=$variable_nombre_bd; 

function conecta()
{
global $nombre_bd;
global $variable_user_bd;
global $variable_password_bd;
global $variable_host_bd;

$db=mysql_connect($variable_host_bd,$variable_user_bd,$variable_password_bd);
mysql_select_db($nombre_bd,$db);
//mysql_query ("SET NAMES 'utf8'");
return $db;
}
?>


