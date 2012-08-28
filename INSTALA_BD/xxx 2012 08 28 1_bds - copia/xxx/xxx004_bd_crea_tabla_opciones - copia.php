<?php
include("../1_comunes/variables_comunes_todos_modulos.php"); 

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$nombre_tabla=$variableadmin_prefijo_tablas."opciones";
// **********************************************************************




//echo "<a href='crea.php'>Volver al Listado de Tablas</a><hr>";
/* SCRIPT PARA CREAR TABLAS DENTRO DE UNA BASE DE DATOS YA EXISTENTE*/

include_once("conecta.php"); $db=conecta(); // CONECTAMOS CON LA BASE DE DATOS



/* Comprobamos la conexion con MYSQL */
if($db){
echo "CONEXIÓN CORRECTA CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!<br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CONECTAR CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!</font><br><hr>";
}

/* Comprobamos la conexion con la BASE DE DATOS */
if(mysql_select_db("$nombre_bd",$db)){
echo "CONECTADO CON EXITO A LA BASE DE DATOS <b>$nombre_bd</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO ESTABLECER CONEXIÓN CON LA BASE DE DATOS <b>$nombre_bd</b></font><br><hr>";
}


/* **** ¡OJO ! ******* */  /* Creamos la Tabla */
$sql="create table $nombre_tabla (
id_opcion int not null primary key auto_increment,
num_opcion int,
id_nivel int,
pertenece_a int,
txtmostrar varchar(50),
descripcion varchar(200),
enlace varchar(200),
posicion varchar(50),
mostrar varchar(5),
es_opcion_super varchar(5),
ordenenelmenu int,
mostrarenellistadodeopciones varchar(5)
)";

/* Comprobamos que la Tabla se ha creado correctamente */
if (mysql_query($sql,$db)){
echo "CREADA CON EXITO LA TABLA <b>$nombre_tabla</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CREAR LA TABLA <b>$nombre_tabla</b></font><br><hr>";
}


/* Calculamos el Número de Campos de la Tabla y obtenemos un listado de los mismos y sus Atributos */

$sql="select * from $nombre_tabla";
$res=mysql_query($sql,$db);
$num_campos=mysql_num_fields($res);
echo "LA TABLA <b>$nombre_tabla</b> TIENE <b>$num_campos</b> CAMPOS<br><br>";

echo "<table border='1'>
<tr bgcolor='#999999'><td>Nombre</td><td>Tipo</td><td>Tamaño</td><td>Opciones</td></tr>";
for ($i=0; $i<$num_campos; $i++){
$nombre=mysql_field_name($res,$i);
$tipo=mysql_field_type($res,$i);
$tam=mysql_field_len($res,$i);
$flags=mysql_field_flags($res,$i);
echo "<tr><td>$nombre</td><td>$tipo</td><td>$tam</td><td>$flags</td></tr>";
}

echo "</table>";

/* Cerramos la CONEXION */
mysql_close($db);
?>
