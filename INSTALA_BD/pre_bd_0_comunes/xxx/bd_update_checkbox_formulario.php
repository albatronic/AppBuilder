<?php

for ($i=0; $i<$num_campos; $i++){ // INICIO: bucle for

	$nombreCampo=mysql_field_name($res,$i);
	$tipo_campo=mysql_field_type($res,$i);
	$longitud_campo=mysql_field_len($res,$i);
	if($tipo_campo=="string" and $longitud_campo==1){ // INICIO if($tipo_campo=="string" and $longitud_campo==1)
			$sqlupdate="update $name_tabla set ";
			$sqlupdate.="$nombreCampo='".$$nombreCampo."'";
			$sqlupdate.=" where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
			$resupdate=mysql_query($sqlupdate,$db);
	}// FIN if($tipo_campo=="string" and $longitud_campo==1)
	

}// FIN: bucle for

?>
