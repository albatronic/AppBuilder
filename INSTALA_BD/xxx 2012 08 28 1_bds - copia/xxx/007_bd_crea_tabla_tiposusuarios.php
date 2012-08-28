<?php
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$nombre_tabla=$variableadmin_prefijo_tablas."tiposusuarios";
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
id_tipousuario int not null primary key auto_increment,
tipousuario varchar(50),
esdatopredeterminado varchar(5),
orden int,
publicar varchar(5),
es_de_superadministrador varchar(5),
solo_visible_para_superadministrador varchar(5),
fechapublicacion datetime,
usuariopublicacion int,
fechaultimamodificacion datetime,
usuarioultimamodificacion int,
num_tipousuario_md5 varchar(100)
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

$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoy.php'; include("$ruta");
$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/horaahora.php'; include("$ruta");


$datetime_ahora=$fechahoybd." ".$horaahorabd;

//include ("../../data/variables/variables_admin.php"); 

$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

/* INSERTAMOS LOS TIPOS DE USUARIOS*/

$num_dato="1";
$dato="administrador";
$num_tipodeusuario_md5=md5($num_dato.$dato.$variableadmin_semillamd5);
$sql="insert into $nombre_tabla (id_tipousuario,tipousuario,esdatopredeterminado,orden,publicar,es_de_superadministrador,solo_visible_para_superadministrador,fechapublicacion,usuariopublicacion,fechaultimamodificacion,usuarioultimamodificacion,num_tipousuario_md5) values(null, '$dato', 'SI', '$num_dato', 'SI', 'SI', 'NO', '$datetime_ahora', 1, '$datetime_ahora', 1, '$num_tipodeusuario_md5')";
$res=mysql_query($sql,$db);




/* SE COMPRUEBA QUE TODO HA IDO BIEN AL INSERTAR EL REGISTRO */
if($res){
echo 'EL TIPO DE USUARIO <b>'.$dato.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR EL TIPO DE USUARIO <b>'.$dato.'</b> </font><br>';
}


$num_dato="2";
$dato="usuarioweb";
$num_tipodeusuario_md5=md5($num_dato.$dato.$variableadmin_semillamd5);
$sql="insert into $nombre_tabla (id_tipousuario,tipousuario,esdatopredeterminado,orden,publicar,es_de_superadministrador,solo_visible_para_superadministrador,fechapublicacion,usuariopublicacion,fechaultimamodificacion,usuarioultimamodificacion,num_tipousuario_md5) values(null, '$dato', 'SI', '$num_dato', 'SI', 'SI', 'NO', '$datetime_ahora', 1, '$datetime_ahora', 1, '$num_tipodeusuario_md5')";
$res=mysql_query($sql,$db);

/* SE COMPRUEBA QUE TODO HA IDO BIEN AL INSERTAR EL REGISTRO */
if($res){
echo 'EL TIPO DE USUARIO <b>'.$dato.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR EL TIPO DE USUARIO <b>'.$dato.'</b> </font><br>';
}

echo "<hr>";


/* Cerramos la CONEXION */
mysql_close($db);
?>
