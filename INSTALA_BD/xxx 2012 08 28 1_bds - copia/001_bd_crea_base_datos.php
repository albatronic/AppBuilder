<?php


// Cargamos las Variables que definen los parámetros de la Base de Datos
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");
$ruta = '../'.$cnfg_prefijo_carpetas.'0_comunes/parametros_conexion_database.php'; include_once("$ruta");

$nombre_user=$variable_user_bd; // Definimos el Nombre del Usuario
$password=$variable_password_bd; // Definimos el Password
$nombre_bd=$variable_nombre_bd; // Definimos el Nombre de la Base de Datos
$localizacion=$variable_host_bd; // Definimos desde donde se conecta el Usuario (HOST)

//echo "<a href='crea.php'>Volver al Listado de Tablas</a><hr>";

/* SCRIPT PARA CREAR TABLAS DENTRO DE UNA BASE DE DATOS YA EXISTENTE*/

include_once("conecta_only.php"); // Conectamos con MYSQL y usamos la Base de datos creada con anterioridad
$db=conecta();



/* Comprobamos la conexion con MYSQL */
if($db){
echo "CONEXIÓN CORRECTA CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!<br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CONECTAR CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!</font><br><hr>";
}

/* Vamos a crear la Base de Datos */
echo "VAMOS A CREAR LA BASE DE DATOS <b>$nombre_bd</b><br><hr>";

$sql="create database $nombre_bd";
if(mysql_query($sql,$db)){
echo "CREADA CON EXITO LA BASE DE DATOS <b>$nombre_bd</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CREAR LA BASE DE DATOS <b>$nombre_bd</b></font><br><hr>";
}


/* Comprobamos la conexion con la BASE DE DATOS */
if(mysql_select_db("$nombre_bd",$db)){
echo "CONECTADO CON EXITO A LA BASE DE DATOS <b>$nombre_bd</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO ESTABLECER CONEXIÓN CON LA BASE DE DATOS <b>$nombre_bd</b></font><br><hr>";
}




/* Veamos el listado de Bases de Datos que hay creadas en el gestor MYSQL */


echo "VEAMOS EL LISTADO DE BASES DE DATOS QUE HAY CREADAS EN EL GESTOR MYSQL<br><br>";

$sql="show databases;";
$res=mysql_query($sql,$db);
echo "<table border='1'>
<tr bgcolor='#999999'><td>Nombre</td></tr>";
while ($reg=mysql_fetch_array($res,MYSQL_NUM))
{
echo "<tr>";
echo "<td>$reg[0]</td>";
echo "</tr>";
}
echo "</table>";



/* Cerramos la CONEXION */
mysql_close($db);
?>
