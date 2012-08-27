<?php

$name_tabla=$variablesubmodulo_tabla_submodulo; 

//$sql="select * from $name_tabla";
$sql="select * from $name_tabla where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
$res=mysql_query($sql,$db);
$num_campos=mysql_num_fields($res);


$camposSqlUpdate="";

for ($i=0; $i<$num_campos; $i++){ // INICIO: bucle for
	$nombreCampo=mysql_field_name($res,$i);

	if(in_array($nombreCampo, $arrayDeCampos)){  // INICIO: if(in_array)
	
		$contadorIndices=0;
		foreach($arrayDeCampos as $veoValores){
			$contadorIndices=$contadorIndices+1;
			if($veoValores==$nombreCampo){$miIndiceProblema=$contadorIndices; break;}
		}
	
		$camposSqlUpdate.="$nombreCampo='$arrayDeValores[$miIndiceProblema]', "; 

	}// FIN: if(in_array)

}// FIN: bucle for

$camposSqlUpdate=substr($camposSqlUpdate,0,-2);


// UPDATE DE LOS CAMPOS QUE LLEGAN POR EL FORMULARIO__________________________________________
$sqlupdate="update $name_tabla set ";
$sqlupdate.=$camposSqlUpdate;
$sqlupdate.=" where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
$resupdate=mysql_query($sqlupdate,$db);
//echo $sqlupdate;

// UPDATE DE LOS CAMPOS PREDETERMINADOS__________________________________________
$sqlupdate="update $name_tabla set ";
$sqlupdate.="fechaultimamodificacion='$datetime_ahora', usuarioultimamodificacion='$iu'";
$sqlupdate.=" where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
$resupdate=mysql_query($sqlupdate,$db);

// UPDATE DE CAMPOS ESPECIALES Y PARTICULARES __________________________________________
$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_update_campos_particulares; if(file_exists($ruta)){ include("$ruta"); }


// REGISTRO DE MODIFICACIONES_____________________________________________________________________________
$tabla_registromodificaciones=$variablesubmodulo_tabla_submodulo;
$ruta = $variableadmin_prefijo_bd.'0_modificaciones/gestion_registromodificaciones.php'; include("$ruta");

?>
