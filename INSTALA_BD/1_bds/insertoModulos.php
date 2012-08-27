<?php

include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

//echo "<a href='crea.php'>Volver al Listado de Tablas</a><hr>";

include_once("conecta.php"); // Conectamos con MYSQL y usamos la Base de datos

$db=conecta();


// Comprobamos la conexion con MYSQL 
if($db){
//echo "CONEXIÓN CORRECTA CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!<br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CONECTAR CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!</font><br><hr>";
}

// Comprobamos la conexion con la BASE DE DATOS 
if(mysql_select_db("$nombre_bd",$db)){
//echo "CONECTADO CON EXITO A LA BASE DE DATOS <b>$nombre_bd</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO ESTABLECER CONEXIÓN CON LA BASE DE DATOS <b>$nombre_bd</b></font><br><hr>";
}


/*
// INICIO: Borramos las Tablas Opciones y Permisos
$tabla=$variableadmin_prefijo_tablas."opciones";
include("ejecutoborrotabla.php");

$tabla=$variableadmin_prefijo_tablas."permisos";
include("ejecutoborrotabla.php");
// FIN: Borramos las Tablas Opciones y Permisos


// INICIO: Creamos las Tablas Opciones y Permisos
include("004_bd_crea_tabla_opciones.php");
include("005_bd_crea_tabla_permisos.php");
// FIN: Creamos las Tablas Opciones y Permisos
*/

include("insertoAplicaciones.php"); 
include("insertoTiposFuncionalidad.php"); 



$nombre_tabla=$variableadmin_prefijo_tablas."core_modulos";
$nombre_tabla_permisos=$variableadmin_prefijo_tablas."core_permisos";

$sqldelete="delete from $nombre_tabla";
$resdelete=mysql_query($sqldelete,$db);
//echo $sqldelete,"<br>";

$sqldelete="delete from $nombre_tabla_permisos where IDPerfil='1'";
$resdelete=mysql_query($sqldelete,$db);
//echo $sqldelete,"<br>";

$ruta = 'array_Modulos.php'; include("$ruta");
$ruta = 'array_Funcionalidades_Default.php'; include("$ruta");

$variablesubmodulo_nombre_campo_id="IDModulo";
$variablesubmodulo_nombre_campo_md5="PrimaryKeyMD5";
$esdatopredeterminado_problema="1";
$publicar_problema="1";
$datosPredeterminados="insertoModulos_datosPredeterminados"; //sin ".php"

foreach ($Campo1 as $value) { // INICIO: foreach #1
	$Campo1_explode = explode("|", $value);


	foreach ($Campo1_explode as $indice_explode => $value_explode) { // INICIO: foreach #2
		$value_explode=trim($value_explode);
//$ruta = 'insertoModulos_ejecuto.php'; include("$ruta");
		if($indice_explode==0){
			//echo "indice_explode: ",$indice_explode,"<br>"; 		
			$rutaInsert = 'insertamosPrecargaDeVariosDatos.php'; include("$rutaInsert");
			$rutaPermisos = 'insertoModulos_permisos.php'; include("$rutaPermisos");
		}
	}  // FIN: foreach #2


} // FIN: foreach #1


	unset($Campo1); 
	unset($value); 
	unset($Campo1_explode); 
	unset($value_explode); 

/* Cerramos la CONEXION */
mysql_close($db);
?>