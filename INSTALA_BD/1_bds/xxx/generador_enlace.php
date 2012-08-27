<?php

if($nivel==1){
	$f_destino=$cnfg_prefijo_carpetas.$carpeta; 
	$enlace="index.php?g=1&amp;f=$f_destino";
}


if($nivel==2){

	$sql="select carpeta from $nombre_tabla where id_opcion='$pertenece_a'";
	$res=mysql_query($sql,$db);
	while ($reg=mysql_fetch_array($res))
	{
			$carpetaNivelSuperior=$reg['carpeta'];
	}

	$f_destino=$cnfg_prefijo_carpetas.$carpetaNivelSuperior; 
	$enlace="index.php?g=1&amp;f=$f_destino&amp;f1=$carpeta";
}


if($nivel==3){
//echo "<br>__________s1: ",$s1,"_________________",strlen($s1),"<br>";
	$sql="select pertenece_a,carpeta from $nombre_tabla where id_opcion='$pertenece_a'";
	$res=mysql_query($sql,$db);
	while ($reg=mysql_fetch_array($res))
	{
			$pertenece_aNivelSuperior=$reg['pertenece_a'];
			$carpeta=$reg['carpeta'];

	}

	$sql="select carpeta from $nombre_tabla where id_opcion='$pertenece_aNivelSuperior'";
	$res=mysql_query($sql,$db);
	while ($reg=mysql_fetch_array($res))
	{
			$carpetaNivelSuperior=$reg['carpeta'];
	}

	$f_destino=$cnfg_prefijo_carpetas.$carpetaNivelSuperior; 
	if(strlen(trim($s1))>0){
	$enlace="index.php?g=1&amp;f=$f_destino&amp;f1=$carpeta&amp;s1=$s1";
	}
}



?>

