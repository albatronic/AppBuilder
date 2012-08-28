<?php
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$tabla="t_paises";
$nombre_tabla=$variableadmin_prefijo_tablas.$tabla;
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
id_pais int not null primary key auto_increment,
num_pais_md5 varchar(100) null,
pais varchar(250) null,
observaciones blob null,
publicar varchar(5) null,
imagen varchar(250),
imagen2 varchar(250),
ruta_almacenamiento varchar(250),
numerodevisitas int,
esdatopredeterminado varchar(5),
fechapublicacion datetime,
usuariopublicacion int,
fechaultimamodificacion datetime,
usuarioultimamodificacion int,
eliminado varchar(5),
fechaeliminar datetime,
usuarioqueelimina int
)";

//tipo varchar(5) null, tipo=PARTICULAR, tipo=EMPRESA


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


$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoraahora.php'; include("$ruta");
if($function_trato_comillas!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/trato_comillas_v2.php'; include("$ruta");}
if($function_eliminoAcentoPrimerCaracter!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/eliminoAcentoPrimerCaracter.php'; include("$ruta");}

$ruta_almacenamiento_problema = $cnfg_prefijo_carpetas.'data/'.$tabla.'/';

$precargaDeDatos = array("España");


$variablesubmodulo_nombre_campo_id="id_pais";
$variablesubmodulo_nombre_campo_md5="num_pais_md5";
$campoProblema="pais";
$esdatopredeterminado_problema="SI";

foreach ($precargaDeDatos as $indice => $value) {

	echo "DATO: ",$value,"<br/>";
	$dato=$value;
	$dato=strtoupper($dato);
	$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
	$ruta = 'tratamientoDeCadenas.php'; include("$ruta");
	$ruta = 'insertamosPrecargaDeDatos.php'; include("$ruta");

}


/*
$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoraahora.php'; include("$ruta");
$ruta_almacenamiento = $cnfg_prefijo_carpetas.'data/'.$tabla.'/';



// _______________ 
		    $dato="Espa&ntilde;a";
			$num_dato_md5=md5($dato.$variableadmin_semillamd5);
			$sqlinsert="insert into $nombre_tabla (id_pais,num_pais_md5,pais,observaciones,publicar,imagen,imagen2,ruta_almacenamiento,numerodevisitas,esdatopredeterminado,fechapublicacion,usuariopublicacion,fechaultimamodificacion,usuarioultimamodificacion,eliminado,fechaeliminar,usuarioqueelimina) values(null,'$num_dato_md5','$dato',null,'SI',null,null,'$ruta_almacenamiento',null,'SI','$datetime_ahora','1','$datetime_ahora','1','NO',null,null);";
			$resinsert=mysql_query($sqlinsert,$db);
// SE COMPRUEBA QUE TODO HA IDO BIEN AL INSERTAR LA PROVINCIA _________

if($res){
echo '<b>'.$dato.'</b><br>';
}else{
echo '<font color="#ff0000"><b>'.$dato.'</b> </font><br>';
}
*/


/* Cerramos la CONEXION */
mysql_close($db);
?>
