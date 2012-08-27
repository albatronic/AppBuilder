<?php

for ($i=0; $i<$num_campos; $i++){ // INICIO: bucle for

	$nombreCampo=mysql_field_name($res,$i);
	$tipo_campo=mysql_field_type($res,$i);

	if($tipo_campo=="datetime"){ // INICIO if($tipo_campo=="datetime")
		if(in_array($nombreCampo, $variableadmin_campos_fecha_no_formularios)){  // INICIO: if(in_array) // FIN: if(in_array)
		}else{
			$sqlupdate="update $name_tabla set ";
			$sqlupdate.="$nombreCampo='".$$nombreCampo."'";
			$sqlupdate.=" where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
			$resupdate=mysql_query($sqlupdate,$db);
		}
	}// FIN if($tipo_campo=="datetime")
	

}// FIN: bucle for

?>
