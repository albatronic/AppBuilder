<?php
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$nombre_tabla=$variableadmin_prefijo_tablas."usuarios";

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
IDUsuario bigint(11) NOT NULL auto_increment,
IDPerfil bigint(11) NOT NULL COMMENT 'db,Perfiles,IDPerfil',
IDRol bigint(11) NOT NULL COMMENT 'db,Roles,IDRol',
IDEmpresa bigint(11) NOT NULL COMMENT 'db,Empresas,IDEmpresa',
Login varchar(50) NOT NULL,
Password varchar(100) NOT NULL,
Email varchar(100),
TelefonoMovil varchar(25),
Nombre varchar(100) NOT NULL,
Apellidos varchar(100),
CambioPassword tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
Ips varchar(255),
NLogin int(4),
UltimoLogin datetime NOT NULL,

Observaciones text,
PrimaryKeyMD5 varchar(100),
EsPredeterminado tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
Revisado tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
Publicar tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
VigenteDesde datetime NOT NULL,
VigenteHasta datetime NOT NULL,
CreatedBy int(4) NOT NULL,
CreatedAt datetime NOT NULL,
ModifiedBy int(4) NOT NULL,
ModifiedAt datetime NOT NULL,
Deleted tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
DeletedBy int(4) NOT NULL,
DeletedAt datetime NOT NULL,

PRIMARY KEY (IDUsuario),
UNIQUE KEY PrimaryKeyMD5 (PrimaryKeyMD5),
KEY IDPerfil (IDPerfil),
KEY ApellidosNombre (Apellidos,Nombre)
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



/* $sql="select * from semillas where id_semilla='1';";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res,MYSQL_NUM))
{
$semilla=$reg[2];
} */

/*
$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoy.php'; include("$ruta");
$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/horaahora.php'; include("$ruta");

$datetime_ahora=$fechahoybd." ".$horaahorabd;

//include ("../../data/variables/variables_admin.php"); 

$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");
*/


$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoraahora.php'; include("$ruta");
if($function_trato_comillas!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/trato_comillas_v2.php'; include("$ruta");}
if($function_eliminoAcentoPrimerCaracter!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/eliminoAcentoPrimerCaracter.php'; include("$ruta");}

//$ruta_almacenamiento_problema = $cnfg_prefijo_carpetas.'data/'.$tabla.'/';

$precargaDeDatos = array("admin","adm");


$variablesubmodulo_nombre_campo_id="IDUsuario";
$variablesubmodulo_nombre_campo_md5="PrimaryKeyMD5";
$campoProblema="Login";
$esdatopredeterminado_problema="SI";

foreach ($precargaDeDatos as $indice => $value) {

	echo "DATO: ",$value,"<br/>";
	$dato=$value;
	//$dato=strtoupper($dato);
	$ruta = 'eliminoAcentoPrimerCaracter.php'; include("$ruta");
	$ruta = 'tratamientoDeCadenas.php'; include("$ruta");
	$ruta = 'insertamosPrecargaDeDatos.php'; include("$ruta");

}


//___________________________________

/*
$nick=$nick1;
$num_dato="1";
$password=$password1.$variableadmin_semillamd5;
$passwordmd5=md5($password);
$quiensoymd5=md5($nick.$passwordmd5);
$perfildeusuario="1";
$sql="insert into $nombre_tabla (id_usuario,num_tipousuario,nick,password,quiensoy,listadecorreo,listadesms,email,telefonomovil,nombre,apellidos,empresa,num_empresa,fotografia,esdatopredeterminado,fechapublicacion,usuariopublicacion,fechaultimamodificacion,usuarioultimamodificacion,num_perfildeusuario,revisado,cuentahabilitada,fechaactivar,fechadesactivar,hacambiadosusdatos,eliminado,fechaeliminar,usuarioqueelimina) values(null, 1, '$nick', '$passwordmd5', '$quiensoymd5', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '$datetime_ahora', 1, '$datetime_ahora', 1, '$perfildeusuario', 'SI', 'SI', '$datetime_ahora', '$variableadmin_fechadesactivacion', 'NO', 'NO', null, null)";
$res=mysql_query($sql,$db);



//___________________________________
if($res){
echo 'EL USUARIO <b>'.$nick.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR EL USUARIO <b>'.$nick.'</b> </font><br>';
}

//___________________________________

$nick=$nick2;
$num_dato="2";
$password=$password2.$variableadmin_semillamd5;
$passwordmd5=md5($password);
$quiensoymd5=md5($nick.$passwordmd5);
$perfildeusuario="2";
$sql="insert into $nombre_tabla (id_usuario,num_tipousuario,nick,password,quiensoy,listadecorreo,listadesms,email,telefonomovil,nombre,apellidos,empresa,num_empresa,fotografia,esdatopredeterminado,fechapublicacion,usuariopublicacion,fechaultimamodificacion,usuarioultimamodificacion,num_perfildeusuario,revisado,cuentahabilitada,fechaactivar,fechadesactivar,hacambiadosusdatos,eliminado,fechaeliminar,usuarioqueelimina) values(null, 1, '$nick', '$passwordmd5', '$quiensoymd5', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '$datetime_ahora', 1, '$datetime_ahora', 1, '$perfildeusuario', 'SI', 'SI', '$datetime_ahora', '$variableadmin_fechadesactivacion', 'NO', 'NO', null, null)";
$res=mysql_query($sql,$db);

//___________________________________
if($res){
echo 'EL USUARIO <b>'.$nick.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR EL USUARIO <b>'.$nick.'</b> </font><br>';
}

echo "<hr>";
*/


mysql_close($db); //Cerramos la CONEXION 
?>
