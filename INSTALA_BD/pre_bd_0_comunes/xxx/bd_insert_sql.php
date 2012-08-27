<?php

$name_tabla=$variablesubmodulo_tabla_submodulo; 


$sql="select * from $name_tabla";
//echo $sql,"<br>";
$res=mysql_query($sql,$db);
$num_campos=mysql_num_fields($res);
//echo "num_campos: ",$num_campos,"<br>";

for ($i=0; $i<$num_campos; $i++){
	$nombre=mysql_field_name($res,$i);
	$listado_campos.=$nombre;
	if($i<($num_campos-1)){$listado_campos.=",";}
}


for ($i=0; $i<$num_campos; $i++){
	$nombre_campo=mysql_field_name($res,$i);
	$$nombre_campo='null';
}


//_________________________________________________________________
// ESTOS SON LOS VALORES PREDETERMINADOS PARA TODAS LAS TABLAS
//$es_privado="'NO'";
$ruta_almacenamiento="'".$variablesubmodulo_rutaalmacenamiento."'";
$publicar="'SI'";
$esdatopredeterminado="'NO'";
//$es_de_superadministrador="'NO'";
//$solo_visible_para_superadministrador="'NO'";
//$fechapublicacion_bd="'".$datetime_ahora."'";
$fechapublicacion="'".$datetime_ahora."'";
$usuariopublicacion="'".$iu."'";
$fechaultimamodificacion="'".$datetime_ahora."'";
$usuarioultimamodificacion="'".$iu."'";
$eliminado="'NO'";
//_________________________________________________________________

if(strlen(trim($variablesubmodulo_valores_insert))>0){
	$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_valores_insert.'.php'; include("$ruta");//if (file_exists($ruta)){}
}



//$query="lock tables $name_tabla write"; $result=mysql_query($query,$db); 


$sqlinsert="insert into $name_tabla ($listado_campos) values(";


for ($i=0; $i<$num_campos; $i++){
	$nombre_campo=mysql_field_name($res,$i);
	$sqlinsert.=$$nombre_campo;
	if($i<($num_campos-1)){$sqlinsert.=", ";}
} 

$sqlinsert.=")";
$resinsert=mysql_query($sqlinsert,$db);

//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';$sqlinsert;


$veoultimoid=mysql_insert_id();

/*
$sqlupdate="update $name_tabla set $conf_nombre_campo_num='$veoultimoid' where $conf_nombre_campo_id='$veoultimoid'";
$resupdate=mysql_query($sqlupdate,$db);

$sqlupdate="update $name_tabla set orden='$veoultimoid' where $conf_nombre_campo_id='$veoultimoid'";
$resupdate=mysql_query($sqlupdate,$db);
*/

if($cnfg_valores_orden_particulares == "SI"){
	//$ruta_valores_insert = $modulo.'/028_insert_orden_particulares.php'; include("$ruta_valores_insert");
}


$clave_md5=md5($veoultimoid.$variableadmin_semillamd5.$datetime_ahora);

$sqlupdate="update $name_tabla set $variablesubmodulo_nombre_campo_md5='$clave_md5' where $variablesubmodulo_nombre_campo_id='$veoultimoid'";
$resupdate=mysql_query($sqlupdate,$db);
//echo $sqlupdate;


		global $num_objeto;
		$num_objeto=$veoultimoid;

		global $num_objeto_md5;
		$num_objeto_md5=$clave_md5;

		$_SESSION['controlinsert']=1; 

/*$query="unlock tables"; $result=mysql_query($query,$db); 


	if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso Insert <b>[".$name_tabla."]</b></font></center><br>";
	}
*/
?>