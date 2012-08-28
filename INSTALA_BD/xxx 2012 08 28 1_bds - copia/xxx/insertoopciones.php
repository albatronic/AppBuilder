<?php

include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

//echo "<a href='crea.php'>Volver al Listado de Tablas</a><hr>";

include_once("conecta.php"); // Conectamos con MYSQL y usamos la Base de datos

$db=conecta();


// Comprobamos la conexion con MYSQL 
if($db){
echo "CONEXIÓN CORRECTA CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!<br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CONECTAR CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!</font><br><hr>";
}

// Comprobamos la conexion con la BASE DE DATOS 
if(mysql_select_db("$nombre_bd",$db)){
echo "CONECTADO CON EXITO A LA BASE DE DATOS <b>$nombre_bd</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO ESTABLECER CONEXIÓN CON LA BASE DE DATOS <b>$nombre_bd</b></font><br><hr>";
}



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



include_once("conecta.php"); // Conectamos con MYSQL y usamos la Base de datos creada con    
                                
$db=conecta();

//global $nombre_tabla;
$nombre_tabla=$variableadmin_prefijo_tablas."opciones"; // Definimos el Nombre de la Tabla que estamos creando

/*
global $id_opcion;
global $num_opcion;
global $nivel;
global $pertenece_a;
global $opcion;
global $descripcion;
global $mostrar;
global $es_opcion_super;
global $orden;
*/

// A ESTAS VARIABLES LE DAREMOS VALORES CUANDO TENGAN UN VALOR DISTINTO DEL QUE AQUI SE INDICA
$mostraropcion="SI"; $es_opcion_super="NO"; $descripcion=""; $imagen_icono=""; $carpeta=""; $s1="";
// ___________________________________________________________________________________________

// LOGIN 
$id_opcion=1; $nivel=1; $pertenece_a=0; $opcion="Login"; $mostraropcion="NO"; $carpeta="gs_l";
include("ejecutoinserttabla.php"); 

// AYUDA A DOMICILIO 
$id_opcion=2; $nivel=1; $pertenece_a=0; $opcion="Ayuda a Domicilio"; $carpeta="gs_ad"; 
include("ejecutoinserttabla.php"); 

	// AYUDA A DOMICILIO : USUARIOS/AS
	$id_opcion=3; $nivel=2; $pertenece_a=2; $opcion="Usuarios"; $carpeta="ad_usuarios";    
	include("ejecutoinserttabla.php"); 

// TERCEROS 
$id_opcion=4; $nivel=1; $pertenece_a=0; $opcion="Terceros"; $carpeta="gs_t";   
include("ejecutoinserttabla.php"); 

	// TERCEROS : LOCALIDADES 
	$id_opcion=5; $nivel=2; $pertenece_a=4; $opcion="Localidades"; $carpeta="t_localidades";   
	include("ejecutoinserttabla.php"); 
	
	// TERCEROS : PROVINCIAS 
	$id_opcion=6; $nivel=2; $pertenece_a=4; $opcion="Provincias"; $carpeta="t_provincias";   
	include("ejecutoinserttabla.php"); 
	
	// TERCEROS : PAISES 
	$id_opcion=7; $nivel=2; $pertenece_a=4; $opcion="Paises"; $carpeta="t_paises";   
	include("ejecutoinserttabla.php"); 

	// TERCEROS : TERCEROS 
	$id_opcion=8; $nivel=2; $pertenece_a=4; $opcion="Terceros"; $carpeta="t_terceros";   
	include("ejecutoinserttabla.php"); 

		// TERCEROS : TERCEROS : NUEVO
		$id_opcion=9; $nivel=3; $pertenece_a=8; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg"; 
		include("ejecutoinserttabla.php"); 


	// AYUDA A DOMICILIO : AUXILIARES
	$id_opcion=10; $nivel=2; $pertenece_a=2; $opcion="Auxiliares"; $carpeta="ad_auxiliares";
	include("ejecutoinserttabla.php"); 

		// AYUDA A DOMICILIO : AUXILIARES : NUEVO
		$id_opcion=11; $nivel=3; $pertenece_a=10; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 

		// AYUDA A DOMICILIO : USUARIOS/AS : NUEVO
		$id_opcion=12; $nivel=3; $pertenece_a=3; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 


		// TERCEROS : TERCEROS : MODIFICAR
		$id_opcion=13; $nivel=3; $pertenece_a=8; $opcion="Modificar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : TERCEROS : ELIMINAR
		$id_opcion=14; $nivel=3; $pertenece_a=8; $opcion="Eliminar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : TERCEROS : LISTADO
		$id_opcion=15; $nivel=3; $pertenece_a=8; $opcion="Listado"; $imagen_icono="ico_listado.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : TERCEROS : AUDITORIA DE CAMPO
		$id_opcion=16; $nivel=3; $pertenece_a=8; $opcion="Auditor&iacute;a de Campo";  $mostraropcion="NO"; 
		include("ejecutoinserttabla.php"); 


		// TERCEROS : PAISES : NUEVO
		$id_opcion=17; $nivel=3; $pertenece_a=7; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PAISES : MODIFICAR
		$id_opcion=18; $nivel=3; $pertenece_a=7; $opcion="Modificar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PAISES : ELIMINAR
		$id_opcion=19; $nivel=3; $pertenece_a=7; $opcion="Eliminar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PAISES : LISTADO
		$id_opcion=20; $nivel=3; $pertenece_a=7; $opcion="Listado"; $imagen_icono="ico_listado.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PAISES : AUDITORIA DE CAMPO
		$id_opcion=21; $nivel=3; $pertenece_a=7; $opcion="Auditor&iacute;a de Campo";  $mostraropcion="NO"; 
		include("ejecutoinserttabla.php"); 

	// TERCEROS : TIPOS DE VÍAS 
	$id_opcion=22; $nivel=2; $pertenece_a=4; $opcion="Tipos de V&iacute;as"; $carpeta="t_tiposdevias";   
	include("ejecutoinserttabla.php"); 

		// TERCEROS : TIPOS DE VÍAS : NUEVO
		$id_opcion=23; $nivel=3; $pertenece_a=22; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : TIPOS DE VÍAS : MODIFICAR
		$id_opcion=24; $nivel=3; $pertenece_a=22; $opcion="Modificar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : TIPOS DE VÍAS : ELIMINAR
		$id_opcion=25; $nivel=3; $pertenece_a=22; $opcion="Eliminar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : TIPOS DE VÍAS : LISTADO
		$id_opcion=26; $nivel=3; $pertenece_a=22; $opcion="Listado"; $imagen_icono="ico_listado.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : TIPOS DE VÍAS : AUDITORIA DE CAMPO
		$id_opcion=27; $nivel=3; $pertenece_a=22; $opcion="Auditor&iacute;a de Campo";  $mostraropcion="NO"; 
		include("ejecutoinserttabla.php"); 












	// TERCEROS : VÍAS 
	$id_opcion=28; $nivel=2; $pertenece_a=4; $opcion="V&iacute;as"; $carpeta="t_vias";   
	include("ejecutoinserttabla.php"); 

		// TERCEROS : VÍAS : NUEVO
		$id_opcion=29; $nivel=3; $pertenece_a=28; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : VÍAS : MODIFICAR
		$id_opcion=30; $nivel=3; $pertenece_a=28; $opcion="Modificar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : VÍAS : ELIMINAR
		$id_opcion=31; $nivel=3; $pertenece_a=28; $opcion="Eliminar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : VÍAS : LISTADO
		$id_opcion=32; $nivel=3; $pertenece_a=28; $opcion="Listado"; $imagen_icono="ico_listado.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : VÍAS : AUDITORIA DE CAMPO
		$id_opcion=33; $nivel=3; $pertenece_a=28; $opcion="Auditor&iacute;a de Campo";  $mostraropcion="NO"; 
		include("ejecutoinserttabla.php"); 



	// TERCEROS : DIRECCIONES 
	$id_opcion=34; $nivel=2; $pertenece_a=4; $opcion="Direcciones"; $carpeta="t_direcciones";   
	include("ejecutoinserttabla.php"); 

		// TERCEROS : DIRECCIONES : NUEVO
		$id_opcion=35; $nivel=3; $pertenece_a=34; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : DIRECCIONES : MODIFICAR
		$id_opcion=36; $nivel=3; $pertenece_a=34; $opcion="Modificar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : DIRECCIONES : ELIMINAR
		$id_opcion=37; $nivel=3; $pertenece_a=34; $opcion="Eliminar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : DIRECCIONES : LISTADO
		$id_opcion=38; $nivel=3; $pertenece_a=34; $opcion="Listado"; $imagen_icono="ico_listado.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : DIRECCIONES : AUDITORIA DE CAMPO
		$id_opcion=39; $nivel=3; $pertenece_a=34; $opcion="Auditor&iacute;a de Campo";  $mostraropcion="NO"; 
		include("ejecutoinserttabla.php"); 


		// TERCEROS : LOCALIDADES : NUEVO
		$id_opcion=40; $nivel=3; $pertenece_a=5; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : LOCALIDADES : MODIFICAR
		$id_opcion=41; $nivel=3; $pertenece_a=5; $opcion="Modificar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : LOCALIDADES : ELIMINAR
		$id_opcion=42; $nivel=3; $pertenece_a=5; $opcion="Eliminar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : LOCALIDADES : LISTADO
		$id_opcion=43; $nivel=3; $pertenece_a=5; $opcion="Listado"; $imagen_icono="ico_listado.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : LOCALIDADES : AUDITORIA DE CAMPO
		$id_opcion=44; $nivel=3; $pertenece_a=5; $opcion="Auditor&iacute;a de Campo";  $mostraropcion="NO"; 
		include("ejecutoinserttabla.php"); 



		// TERCEROS : PROVINCIAS : NUEVO
		$id_opcion=45; $nivel=3; $pertenece_a=6; $opcion="Nuevo"; $imagen_icono="ico_nuevo.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PROVINCIAS : MODIFICAR
		$id_opcion=46; $nivel=3; $pertenece_a=6; $opcion="Modificar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PROVINCIAS : ELIMINAR
		$id_opcion=47; $nivel=3; $pertenece_a=6; $opcion="Eliminar";  $mostraropcion="NO";
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PROVINCIAS : LISTADO
		$id_opcion=48; $nivel=3; $pertenece_a=6; $opcion="Listado"; $imagen_icono="ico_listado.jpg";  
		include("ejecutoinserttabla.php"); 

		// TERCEROS : PROVINCIAS : AUDITORIA DE CAMPO
		$id_opcion=49; $nivel=3; $pertenece_a=6; $opcion="Auditor&iacute;a de Campo";  $mostraropcion="NO"; 
		include("ejecutoinserttabla.php"); 



/* Cerramos la CONEXION */
mysql_close($db);
?>