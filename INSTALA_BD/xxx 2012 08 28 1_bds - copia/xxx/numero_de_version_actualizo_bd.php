<?php


include("../cnfg.php"); 
$ruta = '../'.$cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");

// **********************************************************************
// Definimos el Nombre de la Tabla que estamos creando
$nombre_tabla=$variableadmin_prefijo_tablas."versiones";


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




$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoy.php'; include("$ruta");
$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/horaahora.php'; include("$ruta");

$datetime_ahora=$fechahoybd." ".$horaahorabd;

//include("numero_de_version.php"); 

$sql="insert into $nombre_tabla (id_version,fechaactualizacion,version) values(null, '$datetime_ahora', '$numero_de_version')";
$res=mysql_query($sql,$db);




// SE COMPRUEBA QUE TODO HA IDO BIEN AL INSERTAR EL USUARIO 
if($res){
echo 'LA VERSIÓN <b>'.$numero_de_version.'</b> SE HA ACTUALIZADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO ACTUALIZAR LA VERSIÓN <b>'.$numero_de_version.'</b> </font><br>';
}




mysql_close($db); //Cerramos la CONEXION 
?>
