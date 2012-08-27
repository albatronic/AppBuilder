<?php

for ($i_checkbox=0; $i_checkbox<$num_campos; $i_checkbox++){ // INICIO: bucle for
	$nombreCampo=mysql_field_name($res,$i_checkbox);
	$tipo_campo=mysql_field_type($res,$i_checkbox);
	$longitud_campo=mysql_field_len($res,$i_checkbox);
if($tipo_campo=="string" and $longitud_campo==1){
if($$nombreCampo!=1){$$nombreCampo="0";}

}

} // FIN: bucle for


?>
