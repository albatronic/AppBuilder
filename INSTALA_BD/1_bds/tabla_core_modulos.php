<?php
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");
$ruta = '003_campos_comunes.php'; include("$ruta");

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$nombre_tabla=$variableadmin_prefijo_tablas."core_modulos";

/*
// INSERTAMOS EL USUARIO SUPERADMINISTRADOR ADMIN (ID=1)
$nick1="admin";
$password1="1";

// INSERTAMOS EL USUARIO ADMINISTRADOR QUE SE LE ENTREGA AL CLIENTE ADMIN (ID=2)
$nick2="adm";
$password2="1";
*/

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
IDModulo bigint(11) NOT NULL auto_increment,
CodigoApp varchar(255) COMMENT 'db,coreAplicaciones,CodigoApp',
NombreModulo varchar(255),
Nivel int(4),
PerteneceA varchar(255),
Titulo varchar(100),
Descripcion varchar(100),
Funcionalidades varchar(255),".

$sqlComunes.
$clavesComunes.


"PRIMARY KEY (IDModulo),
KEY CodigoApp (CodigoApp),
KEY PerteneceA (PerteneceA),
UNIQUE KEY NombreModulo (NombreModulo)
) ENGINE=MyISAM";




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



/*
$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoraahora.php'; include("$ruta");
if($function_trato_comillas!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/trato_comillas_v2.php'; include("$ruta");}
if($function_eliminoAcentoPrimerCaracter!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/eliminoAcentoPrimerCaracter.php'; include("$ruta");}


// Campo: Codigo
$Campo1 = array("IN","UP","DE","LI","AU",);
// Campo: Titulo
$Campo2 = array("Insert","Update","Delete","List","Field Audit",);
// Campo: Descripcion
$Campo2 = array("Crear","Actualizar","Borrar","Listado","Auditoría de Campo",);


$variablesubmodulo_nombre_campo_id="IDTipoFuncionalidad";
$variablesubmodulo_nombre_campo_md5="PrimaryKeyMD5";
$esdatopredeterminado_problema="1";
$publicar_problema="1";
$datosPredeterminados="tabla_tiposfuncionalidad_datosPredeterminados";

foreach ($Campo1 as $indice => $value) {
	$ruta = 'insertamosPrecargaDeVariosDatos.php'; include("$ruta");
}
*/


mysql_close($db); //Cerramos la CONEXION 
?>
