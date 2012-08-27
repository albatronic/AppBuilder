<?php
if(strlen(trim($imagen_icono))<1){if(strlen(trim($carpeta))>0){$imagen_icono="ico_".$carpeta.".jpg";}}

if($imagen_icono=="ico_nuevo.jpg"){$s1="0_nuevo";}
if($imagen_icono=="ico_listado.jpg"){$s1="0_listado";}

include("generador_enlace.php"); 


$sqlinsert="insert into $nombre_tabla (id_opcion,nivel,pertenece_a,txtmostrar,descripcion,mostrar,es_opcion_super,orden,carpeta,imagen_icono,enlace,s1) values(null,  '$nivel', '$pertenece_a', '$opcion', '$descripcion', '$mostraropcion', '$es_opcion_super', null, '$carpeta', '$imagen_icono', '$enlace', '$s1')";
$resinsert=mysql_query($sqlinsert,$db);


$veoultimoid=mysql_insert_id();

$sqlupdate="update $nombre_tabla set orden='$veoultimoid' where id_opcion='$veoultimoid'";
$resupdate=mysql_query($sqlupdate,$db);
if(!$resupdate){$erroresbd=$erroresbd+1;}


if($resinsert){
echo 'LA OPCIÓN <b>'.$opcion.'</b> SE HA CREADO CON EXITO!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO CREAR LA OPCIÓN <b>'.$opcion.'</b> </font><br>';
}

include("ejecutoinsertoopciones.php"); // EJECUTAMOS SCRIPTS DE PERMISOS


// A ESTAS VARIABLES LE DAREMOS VALORES CUANDO TENGAN UN VALOR DISTINTO DEL QUE AQUI SE INDICA
$mostraropcion="SI"; $es_opcion_super="NO"; $descripcion=""; $imagen_icono=""; $carpeta=""; $s1=""; $enlace="";

?>

