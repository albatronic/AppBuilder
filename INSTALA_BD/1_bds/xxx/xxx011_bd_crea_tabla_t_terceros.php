<?php
include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$nombre_tabla=$variableadmin_prefijo_tablas."t_terceros";

/* INSERTAMOS EL USUARIO SUPERADMINISTRADOR ADMIN (ID=1)*/

$nick1="admin";
$password1="antoniovega";

/* INSERTAMOS EL USUARIO ADMINISTRADOR QUE SE LE ENTREGA AL CLIENTE ADMIN (ID=2)*/
$nick2="adm";
$password2="1";


// **********************************************************************


//echo "<a href='crea.php'>Volver al Listado de Tablas</a><hr>";
/* SCRIPT PARA CREAR TABLAS DENTRO DE UNA BASE DE DATOS YA EXISTENTE*/

include_once("conecta.php"); $db=conecta(); // CONECTAMOS CON LA BASE DE DATOS


/* Comprobamos la conexion con MYSQL */
if($db){
echo "CONEXI�N CORRECTA CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!<br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CONECTAR CON EL GESTOR DE BASES DE DATOS <b>MYSQL</b> !!!</font><br><hr>";
}

/* Comprobamos la conexion con la BASE DE DATOS */
if(mysql_select_db("$nombre_bd",$db)){
echo "CONECTADO CON EXITO A LA BASE DE DATOS <b>$nombre_bd</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO ESTABLECER CONEXI�N CON LA BASE DE DATOS <b>$nombre_bd</b></font><br><hr>";
}



/* **** �OJO ! ******* */  /* Creamos la Tabla */
$sql="create table $nombre_tabla (
id_usuario int not null primary key auto_increment,
num_tipousuario int,
nick varchar(50),
password varchar(100),
quiensoy varchar(100),
listadecorreo varchar(5),
listadesms varchar(5),
email varchar(100),
telefonomovil varchar(25),
nombre varchar(100),
apellidos varchar(100),
empresa varchar(100),
num_empresa int,
fotografia varchar(100),
esdatopredeterminado varchar(5),
fechapublicacion datetime,
usuariopublicacion int,
fechaultimamodificacion datetime,
usuarioultimamodificacion int,
num_perfildeusuario int,
revisado varchar(5),
cuentahabilitada varchar(5),
fechaactivar datetime,
fechadesactivar datetime,
hacambiadosusdatos varchar(5),
eliminado varchar(5),
fechaeliminar datetime,
usuarioqueelimina int,
numerodevisitas int,
campoextra1 varchar(100),
hacambiadosupassword varchar(5)
)";


id_tercero int not null primary key auto_increment,
num_tercero_md5 varchar(100) null,
apellido1 varchar(250) null,
apellido2 varchar(250) null,
nombre varchar(250) null,
nombre_completo varchar(250) null,
nif_cif varchar(25) null,
es_nif_ varchar(5) null,
telf_fijo varchar(250) null,
telf_movil varchar(250) null,
fax varchar(250) null,
email varchar(250) null,
web varchar(250) null,
numero_ss varchar(100) null,
fech_nacimiento datetime null,
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
esdatopredeterminado varchar(5),
fechapublicacion datetime,
usuariopublicacion int,
fechaultimamodificacion datetime,
usuarioultimamodificacion int,
eliminado varchar(5),
fechaeliminar datetime,
usuarioqueelimina int


/* Comprobamos que la Tabla se ha creado correctamente */
if (mysql_query($sql,$db)){
echo "CREADA CON EXITO LA TABLA <b>$nombre_tabla</b><br><hr>";
}else{
echo "<font color='#ff0000'>NO SE HA PODIDO CREAR LA TABLA <b>$nombre_tabla</b></font><br><hr>";
}


/* Calculamos el N�mero de Campos de la Tabla y obtenemos un listado de los mismos y sus Atributos */

$sql="select * from $nombre_tabla";
$res=mysql_query($sql,$db);
$num_campos=mysql_num_fields($res);
echo "LA TABLA <b>$nombre_tabla</b> TIENE <b>$num_campos</b> CAMPOS<br><br>";

echo "<table border='1'>
<tr bgcolor='#999999'><td>Nombre</td><td>Tipo</td><td>Tama�o</td><td>Opciones</td></tr>";
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


$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoy.php'; include("$ruta");
$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/horaahora.php'; include("$ruta");


$datetime_ahora=$fechahoybd." ".$horaahorabd;

//include ("../../data/variables/variables_admin.php"); 

$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");


/* INSERTAMOS EL USUARIO SUPERADMINISTRADOR ADMIN (ID=1)*/


$nick=$nick1;
$num_dato="1";
$password=$password1.$variableadmin_semillamd5;
$passwordmd5=md5($password);
$quiensoymd5=md5($nick.$passwordmd5);
$perfildeusuario="1";
$sql="insert into $nombre_tabla (id_usuario,num_tipousuario,nick,password,quiensoy,listadecorreo,listadesms,email,telefonomovil,nombre,apellidos,empresa,num_empresa,fotografia,esdatopredeterminado,fechapublicacion,usuariopublicacion,fechaultimamodificacion,usuarioultimamodificacion,num_perfildeusuario,revisado,cuentahabilitada,fechaactivar,fechadesactivar,hacambiadosusdatos,eliminado,fechaeliminar,usuarioqueelimina) values(null, 1, '$nick', '$passwordmd5', '$quiensoymd5', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '$datetime_ahora', 1, '$datetime_ahora', 1, '$perfildeusuario', 'SI', 'SI', '$datetime_ahora', '$variableadmin_fechadesactivacion', 'NO', 'NO', null, null)";
$res=mysql_query($sql,$db);



/* SE COMPRUEBA QUE TODO HA IDO BIEN AL INSERTAR EL USUARIO */
if($res){
echo 'EL USUARIO <b>'.$nick.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR EL USUARIO <b>'.$nick.'</b> </font><br>';
}

/* INSERTAMOS EL USUARIO ADMINISTRADOR QUE SE LE ENTREGA AL CLIENTE ADMIN (ID=2)*/

$nick=$nick2;
$num_dato="2";
$password=$password2.$variableadmin_semillamd5;
$passwordmd5=md5($password);
$quiensoymd5=md5($nick.$passwordmd5);
$perfildeusuario="2";
$sql="insert into $nombre_tabla (id_usuario,num_tipousuario,nick,password,quiensoy,listadecorreo,listadesms,email,telefonomovil,nombre,apellidos,empresa,num_empresa,fotografia,esdatopredeterminado,fechapublicacion,usuariopublicacion,fechaultimamodificacion,usuarioultimamodificacion,num_perfildeusuario,revisado,cuentahabilitada,fechaactivar,fechadesactivar,hacambiadosusdatos,eliminado,fechaeliminar,usuarioqueelimina) values(null, 1, '$nick', '$passwordmd5', '$quiensoymd5', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '$datetime_ahora', 1, '$datetime_ahora', 1, '$perfildeusuario', 'SI', 'SI', '$datetime_ahora', '$variableadmin_fechadesactivacion', 'NO', 'NO', null, null)";
$res=mysql_query($sql,$db);

/* SE COMPRUEBA QUE TODO HA IDO BIEN AL INSERTAR EL USUARIO */
if($res){
echo 'EL USUARIO <b>'.$nick.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR EL USUARIO <b>'.$nick.'</b> </font><br>';
}

echo "<hr>";



mysql_close($db); //Cerramos la CONEXION 
?>
