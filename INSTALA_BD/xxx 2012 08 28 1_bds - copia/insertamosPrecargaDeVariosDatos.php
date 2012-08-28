<?php

$name_tabla=$nombre_tabla; 
$listado_campos="";

$sql="select * from $name_tabla";
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

//$$campoProblema="'".$dato."'";
//$$variablesubmodulo_nombre_campo_md5="'".$clave_md5."'";

//$ruta_almacenamiento="'".$ruta_almacenamiento_problema."'";
//$Publicar="'SI'";
//$esdatopredeterminado="'NO'";
$Publicar="'".$publicar_problema."'";

$EsPredeterminado="'".$esdatopredeterminado_problema."'";

//$es_de_superadministrador="'NO'";
//$solo_visible_para_superadministrador="'NO'";
//$fechapublicacion_bd="'".$datetime_ahora."'";
$CreatedAt="'".$datetime_ahora."'";
$CreatedBy="'1'";
$ModifiedAt="'".$datetime_ahora."'";
$ModifiedBy="'1'";
$Deleted="'NO'";
$VigenteDesde="'".$variableadmin_fechaactivacion."'";
$VigenteHasta="'".$variableadmin_fechadesactivacion."'";


//_________________________________________________________________

$ruta = $datosPredeterminados.'.php';
if(file_exists($ruta)){	include("$ruta"); }




$sqlinsert="insert into $name_tabla ($listado_campos) values(";


for ($i=0; $i<$num_campos; $i++){
	$nombre_campo=mysql_field_name($res,$i);
	$sqlinsert.=$$nombre_campo;
	if($i<($num_campos-1)){$sqlinsert.=", ";}
} 

$sqlinsert.=")";
$resinsert=mysql_query($sqlinsert,$db);

//echo "<br>",$sqlinsert,"<br>";


$veoultimoid=mysql_insert_id();


$clave_md5=md5($veoultimoid.$variableadmin_semillamd5.$datetime_ahora);

$sqlupdate="update $name_tabla set $variablesubmodulo_nombre_campo_md5='$clave_md5' where $variablesubmodulo_nombre_campo_id='$veoultimoid'";
$resupdate=mysql_query($sqlupdate,$db);

//echo $sqlupdate,"<br>";


?>