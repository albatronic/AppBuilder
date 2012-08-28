<?php
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$nombre_tabla=$variableadmin_prefijo_tablas."t_terceros";
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
id_tercero int not null primary key auto_increment,
num_tercero_md5 varchar(100) null,
apellido1 varchar(250) null,
apellido2 varchar(250) null,
nombre varchar(250) null,
nombre_completo varchar(250) null,
tipo varchar(10) null,
nif_cif varchar(25) null,
telf_fijo varchar(250) null,
telf_movil varchar(250) null,
fax varchar(250) null,
email varchar(250) null,
web varchar(250) null,
numero_ss varchar(100) null,
fech_nacimiento datetime null,
fech_primera_alta datetime null,
sexo varchar(5) null,
num_nacionalidad_md5 varchar(250) null,
num_representante_legal_md5 varchar(250) null,
domicilio_social varchar(250) null,
num_localidad_social int null,
num_provincia_social int null,
num_pais_social int null,
codigopostal_social varchar(10) null,
num_direccion_social_md5 varchar(250) null,
direccion_social_completa varchar(250) null,
domicilio_comunicaciones varchar(250) null,
num_localidad_comunicaciones int null,
num_provincia_comunicaciones int null,
num_pais_comunicaciones int null,
codigopostal_comunicaciones varchar(10) null,
num_direccion_comunicaciones_md5 varchar(250) null,
direccion_comunica_completa varchar(250) null,
domicilio_empadrona varchar(250) null,
num_localidad_empadrona int null,
num_provincia_empadrona int null,
num_pais_empadrona int null,
codigopostal_empadrona varchar(10) null,
num_direccion_empadrona_md5 varchar(250) null,
direccion_empadrona_completa varchar(250) null,
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
usuarioqueelimina int,
rojo binary,
azul binary,
amarillo binary
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

/* Cerramos la CONEXION */
mysql_close($db);
?>
