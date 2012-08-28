<?php

//echo "<a href='crea.php'>Volver al Listado de Tablas</a><hr>";

/* SCRIPT PARA CREAR UN USUARIO DE LA BASE DE DATOS*/
include("../cnfg.php"); 

include_once("conecta_root.php"); $db=conecta(); // Conectamos con MYSQL como ROOT


// Cargamos las Variables que definen los parámetros de la Base de Datos
//include("../1_comunes/variables_comunes_todos_modulos.php"); 
//include_once("../0_comunes/parametros_conexion_database.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");
$ruta = '../'.$cnfg_prefijo_carpetas.'0_comunes/parametros_conexion_database.php'; include_once("$ruta");


$nombre_user=$variable_user_bd; // Definimos el Nombre del Usuario
$password=$variable_password_bd; // Definimos el Password
$nombre_bd=$variable_nombre_bd; // Definimos el Nombre de la Base de Datos
$localizacion=$variable_host_bd; // Definimos desde donde se conecta el Usuario (HOST)

echo $nombre_user,"<br>";
echo $password,"<br>";
echo $nombre_bd,"<br>";
echo $localizacion,"<br>";


/* Comprobamos la conexion con MYSQL */
if($db){
echo "CONEXIÓN CORRECTA CON EL GESTOR DE BASE DE DATOS <b>MYSQL</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CONECTAR CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b></font><br><hr>";
}


echo "COMENZAMOS EL PROCESO DE CREACIÓN DEL USUARIO <b>$nombre_user</b><br><hr>";


/* Este es el Código de Creación del Usuario */
$sql="grant select,insert,update,delete,create,drop,alter
on $nombre_bd.*
to $nombre_user@$localizacion
identified by '$password';";

echo "<br>",$sql,"<br>";

/* Comprobamos que el Usuario se ha creado correctamente */
if (mysql_query($sql,$db)){
echo "CREADO CON EXITO EL USUARIO <b>$nombre_user</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CREAR EL USUARIO <b>$nombre_user</b></font><br><hr>";
}

/* Comprobamos la conexion con la BASE DE DATOS MYSQL */
if(mysql_select_db("mysql",$db)){
echo "CONECTADO CON EXITO A LA BASE DE DATOS <b>mysql</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO ESTABLECER CONEXIÓN CON LA BASE DE DATOS <b>mysql</b></font><br><hr>";
}

/* Vemos el Código que hay que insertar en el fichero conecta.inc */
echo "Veamos el Código Fuente que hay que insertar en el Fichero <b>conecta.inc</b><br><br>";

echo '<b>
function conecta()<br>
{<br>
$db=mysql_connect("'.$localizacion.'","'.$nombre_user.'","'.$password.'");<br>
mysql_select_db("'.$nombre_bd.'",$db);<br>
return $db;<br>
}<br>
</b><br><hr>';



/* Obtenemos un listado de los USUARIOS y sus Atributos */

echo "MOSTRAMOS EL CONTENIDO DE LA TABLA <b>user</b><br><br>";

$sql="select * from user";
$res=mysql_query($sql,$db);
echo "<table border='1'>";
echo "<tr bgcolor='#00ffff'>";
echo "<td>Host</td>";
echo "<td>User</td>";
echo "<td>password</td>";
echo "<td>Select_priv</td>";
echo "<td>Insert_priv</td>";
echo "<td>Update_priv</td>";
echo "<td>Delete_priv</td>";
echo "<td>Create_priv</td>";
echo "<td>Drop_priv</td>";
echo "<td>Reload_priv</td>";
echo "<td>Shutdown_priv</td>";
echo "<td>Process_priv</td>";
echo "<td>File_priv</td>";
echo "<td>Grant_priv</td>";
echo "<td>References_priv</td>";
echo "<td>Index_priv</td>";
echo "<td>Alter_priv</td>";
echo "</tr>";

while ($reg=mysql_fetch_array($res,MYSQL_NUM))
{
echo "<tr>";
echo "<td>$reg[0]</td>";
echo "<td>$reg[1]</td>";
echo "<td>$reg[2]</td>";
echo "<td>$reg[3]</td>";
echo "<td>$reg[4]</td>";
echo "<td>$reg[5]</td>";
echo "<td>$reg[6]</td>";
echo "<td>$reg[7]</td>";
echo "<td>$reg[8]</td>";
echo "<td>$reg[9]</td>";
echo "<td>$reg[10]</td>";
echo "<td>$reg[11]</td>";
echo "<td>$reg[12]</td>";
echo "<td>$reg[13]</td>";
echo "<td>$reg[14]</td>";
echo "<td>$reg[15]</td>";
echo "<td>$reg[16]</td>";
echo "</tr>";
}
echo "</table>";


mysql_close($db); //CERRAMOS LA BASE DE DATOS
?>
