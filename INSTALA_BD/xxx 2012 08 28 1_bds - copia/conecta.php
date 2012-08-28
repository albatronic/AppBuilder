<?php
// Cargamos las Variables que definen los parámetros de la Base de Datos

include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");
$ruta = '../'.$cnfg_prefijo_carpetas.'0_comunes/parametros_conexion_database.php'; include("$ruta");


$nombre_bd=$variable_nombre_bd; 

function conecta()
{
global $nombre_bd;
global $variable_user_bd;
global $variable_password_bd;
global $variable_host_bd;

$db=mysql_connect($variable_host_bd,$variable_user_bd,$variable_password_bd);
mysql_select_db($nombre_bd,$db);
return $db;
}
?>


