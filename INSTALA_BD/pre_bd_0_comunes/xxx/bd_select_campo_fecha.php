<?php

if($tipo_campo=="datetime"){
		if(in_array($nombre_campo, $variableadmin_campos_fecha_no_formularios)){  // INICIO: if(in_array) // FIN: if(in_array)
		}else{

			$fechahora_problema=$$nombre_campo;
			$ruta = $variableadmin_prefijo_bd.'funciones/decodificofechahora.php'; include("$ruta");
		
			$nombreCampoDia="dia_".$nombre_campo; $$nombreCampoDia=$dia_decode; 
			$nombreCampoMes="mes_".$nombre_campo; $$nombreCampoMes=$mes_decode; 
			$nombreCampoYear="year_".$nombre_campo; $$nombreCampoYear=$year_decode; 
			
			//echo $nombreCampoDia,": ",$$nombreCampoDia,"<br>";
			//echo $nombreCampoMes,": ",$$nombreCampoMes,"<br>";
			//echo $nombreCampoYear,": ",$$nombreCampoYear,"<br>";
		}
}
?>